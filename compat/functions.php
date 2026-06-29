<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
//
// Clean-room note: newly authored. The legacy class_dicom.php source was never
// read; this re-creates v1's two global functions from the reflected footprint,
// the published examples, and empirical blackbox observation. The public names and
// signatures are reproduced verbatim (snake_case, v1 defaults); house naming
// applies only to the internal Compat\ShimContract helper these delegate to.
declare(strict_types=1);

use Compat\ShimContract;
use DCMTK\Toolkit;

if (!function_exists('is_dcm')) {
    /**
     * v1 compatibility: report whether $file is a DICOM file as 1 or 0 (int, not
     * bool). Preserves v1's use of dcmdump as the detection oracle. Never throws:
     * a missing tool, an unreadable file, or a dcmdump that stalls all degrade to 0
     * with an E_USER_WARNING.
     *
     * @deprecated Prefer DICOM\File::isDICOM() in new code. The v1 dcmdump-based
     *             detection is preserved here only for backward compatibility.
     */
    function is_dcm($file): int
    {
        return ShimContract::run(
            'is_dcm() is deprecated; prefer DICOM\\File::isDICOM() in new code. '
            . 'The v1 dcmdump-based detection is preserved here for compatibility.',
            static function () use ($file): int {
                $binary = (new Toolkit())->locate('dcmdump');

                return ShimContract::dcmdumpDetect($binary, (string) $file);
            },
            0,
        );
    }
}

if (!function_exists('Execute')) {
    /**
     * v1 compatibility: run $command through a shell and return its captured stdout
     * (with v1's `2>&1` appended). stderr is not captured -- it inherits the parent
     * process -- reproducing v1's behavior including the compound-command redirect
     * quirk. The returned string is verbatim.
     *
     * @deprecated Shell execution is intentionally outside the v2 substrate; there
     *             is no v2 replacement.
     */
    function Execute($command): string
    {
        ShimContract::deprecate(
            'Execute() is deprecated; shell execution is intentionally outside the '
            . 'v2 substrate and has no replacement.',
        );

        return ShimContract::shellCapture((string) $command);
    }
}
