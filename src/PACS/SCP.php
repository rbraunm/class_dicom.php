<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS;

use DCMTK\Process;
use DCMTK\Toolkit;
use DICOM\Exception\IOException;
use DICOM\Tool;
use PACS\Exception\NetworkException;

/**
 * The C-STORE SCP: receives DICOM objects into a directory via storescp. Unlike
 * the one-shot SCU operations, this is a blocking server, so it runs as a managed
 * background process -- start() launches storescp, waits until it is listening,
 * and returns an SCPProcess handle the caller stops when done.
 *
 * By default it accepts all supported transfer syntaxes (storescp +xa); passing a
 * presentation config file instead selects accepted contexts via storescp
 * -xf <file> Default. An optional AE title restricts who it answers as; an optional
 * post-reception command is a shell command storescp runs after each stored object
 * (its shell-safety is the caller's responsibility); fork-per-association lets it
 * serve concurrent senders. ACSE/DIMSE timeouts, reverse-DNS suppression (-dhl),
 * and verbose/debug logging (-v -d) are optional.
 */
final class SCP
{
    private readonly Toolkit $toolkit;

    public function __construct(
        private readonly int $port,
        private readonly string $outputDirectory,
        private readonly ?string $aeTitle = null,
        private readonly ?string $postReceiveCommand = null,
        private readonly bool $forkPerAssociation = false,
        private readonly ?string $presentationConfigFile = null,
        private readonly bool $debug = false,
        private readonly bool $disableHostLookup = false,
        private readonly ?int $acseTimeoutSeconds = null,
        private readonly ?int $dimseTimeoutSeconds = null,
        ?Toolkit $toolkit = null,
    ) {
        if ($this->port < 1 || $this->port > 65535) {
            throw new \InvalidArgumentException("SCP port must be within [1, 65535], got {$this->port}.");
        }
        if ($this->aeTitle !== null) {
            Peer::assertAETitle($this->aeTitle, 'SCP AE title');
        }
        self::assertTimeout($this->acseTimeoutSeconds, 'SCP ACSE timeout');
        self::assertTimeout($this->dimseTimeoutSeconds, 'SCP DIMSE timeout');
        $this->toolkit = $toolkit ?? new Toolkit();
    }

    private static function assertTimeout(?int $seconds, string $label): void
    {
        if ($seconds !== null && $seconds < 1) {
            throw new \InvalidArgumentException("{$label} must be >= 1 second when set, got {$seconds}.");
        }
    }

    /**
     * Start the receiver and return a handle once it is listening.
     *
     * @throws IOException the output directory is missing or not writable
     * @throws NetworkException storescp did not come up (e.g. the port is in use)
     * @throws \DICOM\Exception\ToolkitException storescp is missing or could not be started
     */
    public function start(): SCPProcess
    {
        if (!is_dir($this->outputDirectory)) {
            throw new IOException("SCP output directory does not exist: '{$this->outputDirectory}'.");
        }
        if (!is_writable($this->outputDirectory)) {
            throw new IOException("SCP output directory is not writable: '{$this->outputDirectory}'.");
        }
        if ($this->presentationConfigFile !== null && !is_file($this->presentationConfigFile)) {
            throw new IOException(
                "SCP presentation config file does not exist: '{$this->presentationConfigFile}'.",
            );
        }
        $process = Tool::spawn($this->toolkit, 'storescp', $this->buildArgv());
        $this->awaitListening($process);

        return new SCPProcess($process, $this->port, $this->outputDirectory);
    }

    /** @return list<string> */
    private function buildArgv(): array
    {
        $argv = [];
        if ($this->debug) {
            $argv[] = '-v';
            $argv[] = '-d';
        }
        $argv[] = '-od';
        $argv[] = $this->outputDirectory;
        // A presentation config selects accepted contexts (storescp -xf <file> Default);
        // without one, accept all supported transfer syntaxes (+xa).
        if ($this->presentationConfigFile !== null) {
            $argv[] = '-xf';
            $argv[] = $this->presentationConfigFile;
            $argv[] = 'Default';
        } else {
            $argv[] = '+xa';
        }
        if ($this->aeTitle !== null) {
            $argv[] = '-aet';
            $argv[] = $this->aeTitle;
        }
        if ($this->disableHostLookup) {
            $argv[] = '-dhl';
        }
        if ($this->acseTimeoutSeconds !== null) {
            $argv[] = '-ta';
            $argv[] = (string) $this->acseTimeoutSeconds;
        }
        if ($this->dimseTimeoutSeconds !== null) {
            $argv[] = '-td';
            $argv[] = (string) $this->dimseTimeoutSeconds;
        }
        if ($this->forkPerAssociation) {
            $argv[] = '--fork';
        }
        if ($this->postReceiveCommand !== null) {
            $argv[] = '--exec-on-reception';
            $argv[] = $this->postReceiveCommand;
        }
        $argv[] = (string) $this->port;

        return $argv;
    }

    /**
     * Block until storescp is accepting connections, failing loud if it exits
     * during startup or never starts listening within the timeout.
     */
    private function awaitListening(Process $process): void
    {
        $deadline = microtime(true) + 5.0;
        while (microtime(true) < $deadline) {
            if (!$process->isRunning()) {
                $process->stop();
                throw new NetworkException(
                    "storescp exited during startup on port {$this->port} (the port may be in use).",
                );
            }
            $client = @stream_socket_client("tcp://127.0.0.1:{$this->port}", $errno, $errstr, 0.2);
            if ($client !== false) {
                fclose($client);
                // The port is open, but a successful connect only proves *someone*
                // is listening. On a port conflict that someone is another server
                // while our storescp exits from a failed bind, so confirm ours is
                // still alive through a short settle before declaring it up.
                $settleDeadline = microtime(true) + 0.3;
                while (microtime(true) < $settleDeadline) {
                    if (!$process->isRunning()) {
                        $process->stop();
                        throw new NetworkException(
                            "storescp exited during startup on port {$this->port} (the port may be in use).",
                        );
                    }
                    usleep(50000);
                }

                return;
            }
            usleep(50000);
        }
        $process->stop();
        throw new NetworkException(
            "storescp did not start listening on port {$this->port} within the timeout.",
        );
    }
}
