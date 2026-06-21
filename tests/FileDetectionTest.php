<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DCMTK\Toolkit;
use DICOM\Exception\IOException;
use DICOM\Exception\ToolkitException;
use DICOM\File;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class FileDetectionTest extends TestCase
{
    /** Real Part 10 files (preamble + DICM): generated fixtures plus shipped examples. */
    public static function dicomFiles(): array
    {
        return [
            'implicit VR LE'   => [__DIR__ . '/fixtures/implicit_vr_le.dcm'],
            'explicit VR LE'   => [__DIR__ . '/fixtures/explicit_vr_le.dcm'],
            'explicit VR BE'   => [__DIR__ . '/fixtures/explicit_vr_be.dcm'],
            'JPEG Baseline'    => [__DIR__ . '/fixtures/jpeg_baseline.dcm'],
            'JPEG Lossless'    => [__DIR__ . '/fixtures/jpeg_lossless.dcm'],
            'example dean.dcm' => [__DIR__ . '/../examples/dean.dcm'],
            'example test.dcm' => [__DIR__ . '/../examples/test.dcm'],
        ];
    }

    /** Readable files that are not DICOM: wrong magic, too short, and a real JPEG. */
    public static function nonDicomFiles(): array
    {
        return [
            'wrong magic at offset 128' => [__DIR__ . '/fixtures/not_dicom.bin'],
            'shorter than 132 bytes'    => [__DIR__ . '/fixtures/too_short.bin'],
            'a JPEG image'              => [__DIR__ . '/../examples/test.jpg'],
        ];
    }

    #[DataProvider('dicomFiles')]
    public function testIsDicomTrueForPart10Files(string $path): void
    {
        $this->assertTrue(File::isDICOM($path));
    }

    #[DataProvider('nonDicomFiles')]
    public function testIsDicomFalseForNonDicomFiles(string $path): void
    {
        $this->assertFalse(File::isDICOM($path));
    }

    public function testIsDicomThrowsIOExceptionForUnreadableFile(): void
    {
        $this->expectException(IOException::class);
        File::isDICOM(__DIR__ . '/fixtures/does_not_exist.dcm');
    }

    public function testMissingToolkitSurfacesAsToolkitException(): void
    {
        // A toolkit pointed at a directory with no DCMTK binaries: the substrate
        // raises BinaryNotFoundException, which File translates at its boundary so
        // the public API only ever throws DICOM\Exception\ExceptionInterface.
        $toolkit = new Toolkit(__DIR__ . '/fixtures');
        $this->expectException(ToolkitException::class);
        File::isDICOM(__DIR__ . '/fixtures/not_dicom.bin', $toolkit);
    }
}
