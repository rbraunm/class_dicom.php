<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS;

use DCMTK\Toolkit;
use DICOM\File;
use DICOM\Tool;
use PACS\Exception\NetworkException;

/**
 * The C-STORE SCU: sends DICOM objects to a peer via storescu. A one-shot
 * request/response operation, so it runs through the synchronous Tool::run
 * substrate.
 *
 * Constructed from a Peer (the SCP to send to) and, optionally, an Association
 * (local AE title and timeouts) and a TransferSyntaxProposal (what to propose at
 * association; defaults to storescu's automatic proposal). Whether a send
 * negotiates is the peer's concern -- an SCP that refuses the proposed syntaxes
 * makes the send fail loud as a NetworkException.
 */
final class SCU
{
    private readonly Toolkit $toolkit;

    public function __construct(
        private readonly Peer $peer,
        private readonly ?Association $association = null,
        private readonly ?TransferSyntaxProposal $proposal = null,
        ?Toolkit $toolkit = null,
    ) {
        $this->toolkit = $toolkit ?? new Toolkit();
    }

    /**
     * Send one or more DICOM files via C-STORE.
     *
     * @throws \InvalidArgumentException no files were given
     * @throws \DICOM\Exception\IOException a file is no longer readable
     * @throws NetworkException the peer was unreachable, the association was
     *   rejected, or a C-STORE failed
     * @throws \DICOM\Exception\ToolkitException storescu is missing or could not be started
     */
    public function send(File ...$files): void
    {
        if ($files === []) {
            throw new \InvalidArgumentException('At least one file is required to send.');
        }
        $paths = [];
        foreach ($files as $file) {
            $path = $file->path();
            Tool::assertReadable($path);
            $paths[] = $path;
        }
        $this->runStoreScu([], $paths);
    }

    /**
     * Send every DICOM file in a directory via C-STORE, optionally recursing into
     * subdirectories (storescu's directory scan).
     *
     * @throws \InvalidArgumentException the path is not a directory
     * @throws NetworkException the peer was unreachable, the association was
     *   rejected, or a C-STORE failed
     * @throws \DICOM\Exception\ToolkitException storescu is missing or could not be started
     */
    public function sendDirectory(string $directory, bool $recursive = false): void
    {
        if (!is_dir($directory)) {
            throw new \InvalidArgumentException("Not a directory: '{$directory}'.");
        }
        $options = ['+sd'];
        if ($recursive) {
            $options[] = '+r';
        }
        $this->runStoreScu($options, [$directory]);
    }

    /**
     * @param list<string> $extraOptions storescu options preceding the positional arguments
     * @param list<string> $targets the trailing dcmfile-in arguments (files or a directory)
     */
    private function runStoreScu(array $extraOptions, array $targets): void
    {
        $argv = array_merge(
            ($this->association ?? new Association())->flags(),
            $this->peer->flags(),
            ($this->proposal ?? TransferSyntaxProposal::automatic())->flags(),
            $extraOptions,
            [$this->peer->host(), (string) $this->peer->port()],
            $targets,
        );
        $result = Tool::run($this->toolkit, 'storescu', $argv);
        if (!$result->succeeded()) {
            throw new NetworkException(sprintf(
                'C-STORE to %s:%d failed (storescu exit %d): %s',
                $this->peer->host(),
                $this->peer->port(),
                $result->exitCode,
                trim($result->stderr),
            ));
        }
    }
}
