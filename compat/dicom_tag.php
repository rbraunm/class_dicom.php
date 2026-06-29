<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
//
// Clean-room note: newly authored. The legacy class_dicom.php source was never
// read; this re-creates v1's global dicom_tag class from the reflected footprint
// and empirical blackbox observation of its methods. Public names, signatures, and
// the loose return shapes are reproduced verbatim; house naming applies only to
// the internal Compat\ShimContract helper this delegates to.
declare(strict_types=1);

use Compat\ShimContract;
use DCMTK\Exception\ExceptionInterface as ToolkitException;
use DCMTK\Toolkit;
use DICOM\Dataset;
use DICOM\Exception\ExceptionInterface as DICOMException;
use PACS\Exception\ExceptionInterface as PACSException;

/**
 * v1 compatibility: read and write top-level DICOM tags.
 *
 * v1 fidelity points reproduced here:
 * - load_tags() reads the file once and populates the public $tags map; it returns
 *   null and, on any read failure, leaves $tags empty (never throws).
 * - get_tag() is a pure lookup into the already-loaded $tags; it does not read the
 *   file itself, so it returns '' until load_tags() has run.
 * - $tags is keyed "gggg,eeee" with values rendered as dcmdump's default (no -Un),
 *   so well-known UIDs appear as dictionary names (e.g. 'JPEGBaseline') while
 *   unmappable UIDs stay numeric.
 * - write_tags() returns int 0 on success and an error string on failure.
 *
 * @deprecated Use DICOM\Dataset (get/all/put) in new code. Dataset reads UIDs
 *             numerically; the dictionary-name rendering is a v1-only behavior kept
 *             in this shim.
 */
class dicom_tag
{
    /** @var string Path to the DICOM file, stored verbatim from the constructor. */
    public $file = '';

    /** @var array<string, string> "gggg,eeee" => value, populated by load_tags(). */
    public $tags = [];

    public function __construct($file = '')
    {
        $this->file = $file;
    }

    /**
     * Look up a single tag from the loaded $tags map. Returns '' when the tag is
     * absent (including before load_tags() has been called), never throwing -- v1's
     * loose behavior.
     */
    public function get_tag($group, $element)
    {
        ShimContract::deprecate('get_tag() is deprecated; use DICOM\\Dataset::get() in new code.');

        return $this->tags[strtolower($group . ',' . $element)] ?? '';
    }

    /**
     * Read every top-level tag into $tags, with well-known UIDs rendered as
     * dictionary names. Returns null. On a read failure $tags is left empty.
     */
    public function load_tags()
    {
        $this->tags = ShimContract::run(
            'load_tags() is deprecated; use DICOM\\Dataset::all() in new code.',
            fn (): array => ShimContract::readNameRenderedTags(new Toolkit(), (string) $this->file),
            [],
        );

        return null;
    }

    /**
     * Write each "gggg,eeee" => value entry to the file via the v2 write path.
     * Returns int 0 on success, or an error string on failure (a malformed key, or
     * a write the toolkit rejects) -- v1's falsy-on-success contract. Does not
     * refresh $tags; call load_tags() again to observe the written values.
     *
     * @param array<string, string> $tag_arr
     * @return int|string
     */
    public function write_tags($tag_arr)
    {
        ShimContract::deprecate('write_tags() is deprecated; use DICOM\\Dataset::put() in new code.');

        try {
            $dataset = new Dataset((string) $this->file);
            foreach ($tag_arr as $key => $value) {
                $parts = explode(',', (string) $key);
                if (count($parts) !== 2 || !ctype_xdigit($parts[0]) || !ctype_xdigit($parts[1])) {
                    $message = "write_tags(): malformed tag key '{$key}' (expected \"GGGG,EEEE\").";
                    @trigger_error($message, E_USER_WARNING);

                    return $message;
                }
                $dataset->put(hexdec($parts[0]), hexdec($parts[1]), (string) $value);
            }

            return 0;
        } catch (DICOMException | PACSException | ToolkitException $exception) {
            @trigger_error($exception->getMessage(), E_USER_WARNING);

            return $exception->getMessage();
        }
    }
}
