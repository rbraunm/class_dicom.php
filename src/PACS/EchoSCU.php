<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace PACS;

use DCMTK\Toolkit;
use DICOM\Tool;
use PACS\Exception\NetworkException;

/**
 * The C-ECHO (Verification) SCU: confirms a peer is reachable and willing to
 * associate, via echoscu. Named EchoSCU rather than Echo because `echo` is a
 * reserved word in PHP.
 *
 * Constructed from a Peer (the SCP to verify) and an optional Association (local
 * AE title and timeouts; a default is used when omitted).
 */
final class EchoSCU
{
    private readonly Toolkit $toolkit;

    public function __construct(
        private readonly Peer $peer,
        private readonly ?Association $association = null,
        ?Toolkit $toolkit = null,
    ) {
        $this->toolkit = $toolkit ?? new Toolkit();
    }

    /**
     * Issue a C-ECHO to the peer. Returns normally on success.
     *
     * @throws NetworkException the peer could not be reached or the association was
     *   rejected (e.g. a called AE title the peer does not answer to)
     * @throws \DICOM\Exception\ToolkitException echoscu is missing or could not be started
     */
    public function verify(): void
    {
        $association = $this->association ?? new Association();
        $argv = array_merge(
            $association->flags(),
            $this->peer->flags(),
            [$this->peer->host(), (string) $this->peer->port()],
        );
        $result = Tool::run($this->toolkit, 'echoscu', $argv);
        if (!$result->succeeded()) {
            throw new NetworkException(sprintf(
                'C-ECHO to %s:%d failed (echoscu exit %d): %s',
                $this->peer->host(),
                $this->peer->port(),
                $result->exitCode,
                trim($result->stderr),
            ));
        }
    }

    /**
     * Whether the peer answered a C-ECHO. The non-throwing form of verify(), for a
     * plain reachability check.
     *
     * @throws \DICOM\Exception\ToolkitException echoscu is missing or could not be started
     */
    public function isReachable(): bool
    {
        try {
            $this->verify();

            return true;
        } catch (NetworkException) {
            return false;
        }
    }
}
