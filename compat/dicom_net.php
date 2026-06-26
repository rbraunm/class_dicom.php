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

    /**
     * C-ECHO (DICOM verification "ping") to $host:$port. Returns 0 on success or the
     * error output string on failure. $my_ae is the calling AE, $target_ae the called.
     *
     * @return int|string 0 on success, error string on failure
     */
    public function echoscu($host, $port, $my_ae, $target_ae)
    {
        return ShimContract::run(
            'echoscu() is deprecated; use PACS\\EchoSCU in new code.',
            function () use ($host, $port, $my_ae, $target_ae): int {
                $peer = new Peer((string) $host, (int) $port, (string) $target_ae);
                (new EchoSCU($peer, new Association((string) $my_ae)))->verify();

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

        return ShimContract::run(
            'send_dcm() is deprecated; use PACS\\SCU::send()/sendDirectory() in new code.',
            function () use ($host, $port, $my_ae, $target_ae, $batch, $file): int {
                $scu = new SCU(
                    new Peer((string) $host, (int) $port, (string) $target_ae),
                    new Association((string) $my_ae),
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
}
