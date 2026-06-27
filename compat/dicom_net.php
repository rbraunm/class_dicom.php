<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
//
// Clean-room note: newly authored. The legacy class_dicom.php source was never
// read; this re-creates v1's global dicom_net class from the reflected footprint,
// the README, and empirical blackbox observation of its methods (the echoscu
// return contract, the send_dcm batch flag and 0/error-string returns, and the
// exact storescp invocation store_server builds). Public names, signatures, and
// return shapes are reproduced verbatim; house naming applies only to the internal
// Compat\ShimContract helper this delegates to.
//
// This file grows over the 6g checkpoints: echoscu first, then send_dcm, then the
// blocking store_server.
declare(strict_types=1);

use Compat\ShimContract;
use DICOM\File;
use PACS\Association;
use PACS\EchoSCU;
use PACS\Peer;
use PACS\SCP;
use PACS\SCU;

/**
 * v1 compatibility: DICOM networking over DCMTK -- C-ECHO (echoscu), C-STORE send
 * (send_dcm), and a blocking C-STORE receive server (store_server).
 *
 * v1 fidelity points reproduced here:
 * - echoscu()/send_dcm() return 0 on success and the tool's error output string on
 *   failure; they never throw. A peer-side failure (unreachable, association
 *   rejected) is softened to that error string with an E_USER_WARNING. An input the
 *   v2 substrate now rejects (e.g. an AE title over 16 characters) -- which v1
 *   passed through to the tool -- is likewise returned as an error string, but with
 *   an E_USER_DEPRECATED, since that usage is invalid in v2 going forward.
 * - $my_ae is the calling (local) AE title; $target_ae is the called (peer) AE.
 *
 * @deprecated Use PACS\EchoSCU, PACS\SCU, and PACS\SCP in new code.
 */
class dicom_net
{
    /** @var string Path to the DICOM file send_dcm() transmits; set by the caller. */
    public $file = '';

    // Tunable timeouts and flags mirroring DCMTK's per-tool knobs. Defaults match
    // v1's hardcoded values; set any property before a call to override.
    /** echoscu ACSE / DIMSE / TCP-connection timeouts in seconds (echoscu -ta/-td/-to). */
    public int $echo_acse_timeout = 5;
    public int $echo_dimse_timeout = 5;
    public int $echo_connection_timeout = 5;
    /** send_dcm ACSE / DIMSE / TCP-connection timeouts in seconds (storescu -ta/-td/-to). */
    public int $send_acse_timeout = 10;
    public int $send_dimse_timeout = 10;
    public int $send_connection_timeout = 10;
    /** store_server ACSE / DIMSE timeouts in seconds (storescp -ta/-td). */
    public int $server_acse_timeout = 20;
    public int $server_dimse_timeout = 20;
    /** store_server: handle concurrent associations (storescp --fork). */
    public bool $fork = true;
    /** store_server: skip reverse-DNS lookup of the peer (storescp -dhl). */
    public bool $disable_host_lookup = true;
    /** store_server: block until the server process exits (v1 ran in the foreground). */
    public bool $blocking = true;

    /**
     * C-ECHO (DICOM verification "ping") to $host:$port. Returns 0 on success or the
     * error output string on failure. $my_ae is the calling AE, $target_ae the called.
     *
     * @return int|string 0 on success, error string on failure
     */
    public function echoscu($host, $port, $my_ae, $target_ae)
    {
        $acse = $this->echo_acse_timeout;
        $dimse = $this->echo_dimse_timeout;
        $connection = $this->echo_connection_timeout;

        return ShimContract::run(
            'echoscu() is deprecated; use PACS\\EchoSCU in new code.',
            function () use ($host, $port, $my_ae, $target_ae, $acse, $dimse, $connection): int {
                $peer = new Peer((string) $host, (int) $port, (string) $target_ae);
                $association = new Association((string) $my_ae, $acse, $dimse, $connection);
                (new EchoSCU($peer, $association))->verify();

                return 0;
            },
            static fn (\Throwable $exception): string => $exception->getMessage(),
        );
    }

    /**
     * C-STORE send of $this->file to $host:$port. With a falsy $batch it sends the
     * single file; with a truthy $batch it sends every file in that file's directory
     * (non-recursive), v1's batch mode. Returns 0 on success or the error output
     * string on failure. $my_ae is the calling AE, $target_ae the called.
     *
     * @return int|string 0 on success, error string on failure
     */
    public function send_dcm($host, $port, $my_ae, $target_ae, $batch = 0)
    {
        $file = (string) $this->file;
        $acse = $this->send_acse_timeout;
        $dimse = $this->send_dimse_timeout;
        $connection = $this->send_connection_timeout;

        return ShimContract::run(
            'send_dcm() is deprecated; use PACS\\SCU::send()/sendDirectory() in new code.',
            function () use ($host, $port, $my_ae, $target_ae, $batch, $file, $acse, $dimse, $connection): int {
                $scu = new SCU(
                    new Peer((string) $host, (int) $port, (string) $target_ae),
                    new Association((string) $my_ae, $acse, $dimse, $connection),
                );
                if ($batch) {
                    $scu->sendDirectory(dirname($file));
                } else {
                    $scu->send(File::open($file));
                }

                return 0;
            },
            static fn (\Throwable $exception): string => $exception->getMessage(),
        );
    }

    /**
     * Run a blocking C-STORE SCP (storescp) that receives objects into $storage_dir.
     * $handler_script, if given, is run after each received object as a bare command
     * with v1's placeholders appended -- "<handler> #p #f #c #a" (storage dir, file,
     * called AE, calling AE) -- so it must be executable with a shebang. $config_file,
     * if given, selects accepted presentation contexts (storescp -xf <file> Default);
     * otherwise all transfer syntaxes are accepted. A truthy $debug adds -v -d.
     *
     * Server timeouts and the fork/host-lookup/blocking behavior come from the
     * $server_*_timeout, $fork, $disable_host_lookup, and $blocking properties.
     * Blocking (the default, matching v1) runs in the foreground until the process
     * exits and returns null; non-blocking returns the SCPProcess handle.
     *
     * @return \PACS\SCPProcess|null the handle when non-blocking, otherwise null
     */
    public function store_server($port, $storage_dir, $handler_script, $config_file = '', $debug = 0)
    {
        $port = (int) $port;
        $storage = (string) $storage_dir;
        $handler = (string) $handler_script;
        $config = (string) $config_file;
        $acse = $this->server_acse_timeout;
        $dimse = $this->server_dimse_timeout;
        $fork = $this->fork;
        $disableHostLookup = $this->disable_host_lookup;
        $blocking = $this->blocking;

        return ShimContract::run(
            'store_server() is deprecated; use PACS\\SCP in new code.',
            function () use ($port, $storage, $handler, $config, $debug, $acse, $dimse, $fork, $disableHostLookup, $blocking) {
                if (!is_dir($storage) && !mkdir($storage, 0775, true) && !is_dir($storage)) {
                    throw new \RuntimeException("store_server(): could not create storage directory '{$storage}'.");
                }
                $scp = new SCP(
                    port: $port,
                    outputDirectory: $storage,
                    postReceiveCommand: $handler !== '' ? $handler . ' #p #f #c #a' : null,
                    forkPerAssociation: $fork,
                    presentationConfigFile: $config !== '' ? $config : null,
                    debug: (bool) $debug,
                    disableHostLookup: $disableHostLookup,
                    acseTimeoutSeconds: $acse,
                    dimseTimeoutSeconds: $dimse,
                );
                $process = $scp->start();
                if (!$blocking) {
                    return $process;
                }
                while ($process->isRunning()) {
                    usleep(200000);
                }

                return null;
            },
            null,
        );
    }
}
