<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Exception\ExceptionInterface;
use DICOM\Exception\InvalidDICOMException;
use DICOM\Exception\IOException;
use DICOM\File;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class FileMetaTest extends TestCase
{
    /** fixture path => exact TransferSyntaxUID (0002,0010) it declares. */
    public static function transferSyntaxCases(): array
    {
        return [
            'implicit VR LE'   => [__DIR__ . '/fixtures/implicit_vr_le.dcm', '1.2.840.10008.1.2'],
            'explicit VR LE'   => [__DIR__ . '/fixtures/explicit_vr_le.dcm', '1.2.840.10008.1.2.1'],
            'explicit VR BE'   => [__DIR__ . '/fixtures/explicit_vr_be.dcm', '1.2.840.10008.1.2.2'],
            'JPEG Baseline'    => [__DIR__ . '/fixtures/jpeg_baseline.dcm', '1.2.840.10008.1.2.4.50'],
            'JPEG Lossless'    => [__DIR__ . '/fixtures/jpeg_lossless.dcm', '1.2.840.10008.1.2.4.70'],
            'example dean.dcm' => [__DIR__ . '/../examples/dean.dcm', '1.2.840.10008.1.2.4.50'],
        ];
    }

    #[DataProvider('transferSyntaxCases')]
    public function testTransferSyntaxUidIsReadFromFileMeta(string $path, string $expected): void
    {
        $this->assertSame($expected, File::open($path)->transferSyntaxUID());
    }

    public function testMediaStorageSopClassUidIsReadFromFileMeta(): void
    {
        $file = File::open(__DIR__ . '/fixtures/explicit_vr_le.dcm');
        // The fixtures are written as Secondary Capture Image Storage.
        $this->assertSame('1.2.840.10008.5.1.4.1.1.7', $file->mediaStorageSOPClassUID());
    }

    public function testOpenThrowsInvalidDicomForNonDicomFile(): void
    {
        $this->expectException(InvalidDICOMException::class);
        File::open(__DIR__ . '/fixtures/not_dicom.bin');
    }

    public function testOpenThrowsIOExceptionForUnreadableFile(): void
    {
        $this->expectException(IOException::class);
        File::open(__DIR__ . '/fixtures/does_not_exist.dcm');
    }

    public function testLibraryExceptionsAreCatchableViaTheSharedMarker(): void
    {
        // Every exception this library throws implements the marker interface,
        // so a caller can catch the whole library with one catch block.
        try {
            File::open(__DIR__ . '/fixtures/not_dicom.bin');
            $this->fail('expected File::open to throw on a non-DICOM file');
        } catch (ExceptionInterface $caught) {
            $this->assertInstanceOf(InvalidDICOMException::class, $caught);
        }
    }

    public function testMetaReadOfAVanishedFileRaisesIOException(): void
    {
        // A File opened on valid DICOM whose backing file then disappears: the meta
        // read's dcmdump fails, and the disambiguation routes it to IOException
        // (the file is gone) rather than InvalidDICOMException.
        $temp = tempnam(sys_get_temp_dir(), 'dcm');
        copy(__DIR__ . '/fixtures/explicit_vr_le.dcm', $temp);
        $file = File::open($temp);
        unlink($temp);

        $this->expectException(IOException::class);
        $file->transferSyntaxUID();
    }
}
