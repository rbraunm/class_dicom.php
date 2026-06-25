<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

namespace DICOM\Tests;

use DICOM\Compress;
use DICOM\Compression;
use DICOM\File;
use DICOM\Tag;
use PHPUnit\Framework\TestCase;

final class CompressTest extends TestCase
{
    private const EXPLICIT_VR_LE = '1.2.840.10008.1.2.1';
    private const JPEG_BASELINE = '1.2.840.10008.1.2.4.50';
    private const JPEG_EXTENDED = '1.2.840.10008.1.2.4.51';
    private const JPEG_LOSSLESS = '1.2.840.10008.1.2.4.57';
    private const JPEG_LOSSLESS_SV1 = '1.2.840.10008.1.2.4.70';

    /** @var list<string> */
    private array $temps = [];

    /** A real pixel-bearing image: JPEG-baseline Secondary Capture. */
    private function example(): File
    {
        return File::open(__DIR__ . '/../examples/dean.dcm');
    }

    /** An uncompressed Explicit VR LE source with pixels (dogfoods decompress). */
    private function uncompressedSource(): File
    {
        return (new Compress($this->example()))->decompress($this->outPath());
    }

    private function outPath(): string
    {
        $path = tempnam(sys_get_temp_dir(), 'dcm');
        $this->temps[] = $path;

        return $path;
    }

    private function transferSyntax(File $file): ?string
    {
        return $file->dataset()->get(0x0002, 0x0010);
    }

    protected function tearDown(): void
    {
        foreach ($this->temps as $temp) {
            @unlink($temp);
        }
        $this->temps = [];
    }

    public function testDecompressYieldsExplicitVrLittleEndian(): void
    {
        $result = (new Compress($this->example()))->decompress($this->outPath());
        $this->assertSame(self::EXPLICIT_VR_LE, $this->transferSyntax($result));
    }

    public function testCompressDefaultIsLosslessSV1(): void
    {
        $result = (new Compress($this->uncompressedSource()))->compress($this->outPath());
        $this->assertSame(self::JPEG_LOSSLESS_SV1, $this->transferSyntax($result));
    }

    public function testCompressLossless(): void
    {
        $result = (new Compress($this->uncompressedSource()))
            ->compress($this->outPath(), Compression::lossless());
        $this->assertSame(self::JPEG_LOSSLESS, $this->transferSyntax($result));
    }

    public function testCompressBaseline(): void
    {
        $result = (new Compress($this->uncompressedSource()))
            ->compress($this->outPath(), Compression::baseline(75));
        $this->assertSame(self::JPEG_BASELINE, $this->transferSyntax($result));
    }

    public function testCompressExtended(): void
    {
        $result = (new Compress($this->uncompressedSource()))
            ->compress($this->outPath(), Compression::extended(75));
        $this->assertSame(self::JPEG_EXTENDED, $this->transferSyntax($result));
    }

    public function testLosslessRoundTripRestoresExplicitVrLeAndDimensions(): void
    {
        $source = $this->uncompressedSource();
        $compressed = (new Compress($source))->compress($this->outPath());
        $restored = (new Compress($compressed))->decompress($this->outPath());

        $this->assertSame(self::EXPLICIT_VR_LE, $this->transferSyntax($restored));
        $this->assertSame($source->getInteger(Tag::Rows), $restored->getInteger(Tag::Rows));
        $this->assertSame($source->getInteger(Tag::Columns), $restored->getInteger(Tag::Columns));
    }

    public function testCompressReturnsTaggableFile(): void
    {
        $result = (new Compress($this->uncompressedSource()))->compress($this->outPath());
        $result->setText(Tag::PatientID, 'CMP-001');
        $this->assertSame('CMP-001', $result->getText(Tag::PatientID));
    }

    public function testCompressBaselineQualityOutOfRangeThrows(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        Compression::baseline(101);
    }

    public function testCompressVanishedSourceThrowsIoException(): void
    {
        // dcmcjpeg and dcmdjpeg are lenient -- they tolerate odd-but-readable input
        // (no pixels, already-uncompressed) rather than failing. The reachable
        // failure is I/O: open a real DICOM, remove the underlying file, and the
        // failed dcmcjpeg run is surfaced as IOException rather than guessed at.
        $path = $this->outPath();
        copy(__DIR__ . '/../examples/dean.dcm', $path);
        $file = File::open($path);
        unlink($path);

        $this->expectException(\DICOM\Exception\IOException::class);
        (new Compress($file))->compress($this->outPath());
    }
}
