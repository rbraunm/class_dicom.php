<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DCMTK\Toolkit;
use PHPUnit\Framework\TestCase;

final class ToolkitTest extends TestCase
{
    public function testVersionReportsInstalledDCMTK(): void
    {
        $version = (new Toolkit())->version('dcmdump');

        $this->assertNotSame('', $version);
        $this->assertStringContainsStringIgnoringCase('dcmtk', $version);
    }
}
