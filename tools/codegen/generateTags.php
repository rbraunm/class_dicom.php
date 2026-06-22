<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);

/**
 * Generate src/DICOM/Tag.php from the vendored DCMTK data dictionary
 * (tools/codegen/dicom.dic), which is itself generated from DICOM PS3.6. The
 * dictionary is the single source of truth; no tag is written by hand. Re-run
 * after refreshing the dictionary:
 *
 *   php tools/codegen/generateTags.php
 *
 * Scope decisions (kept narrow and loud):
 * - Only entries whose source group is "DICOM" are included. DICONDE/DICOS and
 *   private entries are skipped (they can be added later by widening this filter).
 * - Repeating-group entries (e.g. "60xx,..." overlay ranges) carry non-hex
 *   placeholders and cannot be a single enum case; they are skipped.
 * - A keyword collision among included entries is a hard error: we fail rather
 *   than silently drop a tag, because that would make the surface lie about the
 *   dictionary.
 */

$dictPath = __DIR__ . '/dicom.dic';
$outPath = dirname(__DIR__, 2) . '/src/DICOM/Tag.php';

if (!is_file($dictPath)) {
    fwrite(STDERR, "Dictionary not found: {$dictPath}\n");
    exit(1);
}

$entries = [];          // keyword => [group, element, vr, vm]
$collisions = [];       // keyword => count, for any keyword seen more than once
$skippedRange = 0;
$skippedSource = 0;
$skippedNoKeyword = 0;
$skippedBadKeyword = 0;

foreach (file($dictPath, FILE_IGNORE_NEW_LINES) as $line) {
    if ($line === '' || $line[0] === '#') {
        continue;
    }
    $parts = explode("\t", $line);
    if (count($parts) < 5) {
        continue;
    }
    [$tag, $vr, $keyword, $vm, $source] = $parts;

    if ($source !== 'DICOM') {
        $skippedSource++;
        continue;
    }
    // Only fully-numeric tags map to a single element; ranges like (60xx,0010) do not.
    if (!preg_match('/^\(([0-9a-fA-F]{4}),([0-9a-fA-F]{4})\)$/', $tag, $m)) {
        $skippedRange++;
        continue;
    }
    if ($keyword === '') {
        $skippedNoKeyword++;
        continue;
    }
    // Enum case names must be valid PHP labels.
    if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $keyword)) {
        $skippedBadKeyword++;
        continue;
    }
    if (isset($entries[$keyword])) {
        $collisions[$keyword] = ($collisions[$keyword] ?? 1) + 1;
        continue;
    }
    if (strlen($vr) !== 2) {
        fwrite(STDERR, "Unexpected VR '{$vr}' for {$keyword} ({$tag})\n");
        exit(1);
    }
    $entries[$keyword] = [hexdec($m[1]), hexdec($m[2]), $vr, $vm];
}

if ($collisions !== []) {
    fwrite(STDERR, "Keyword collisions (would drop tags) -- resolve before generating:\n");
    foreach ($collisions as $keyword => $count) {
        fwrite(STDERR, "  {$keyword}: seen {$count} times\n");
    }
    exit(1);
}

// Deterministic order: by (group, element) so regen diffs stay minimal.
uasort($entries, static function (array $a, array $b): int {
    return [$a[0], $a[1]] <=> [$b[0], $b[1]];
});

$cases = [];
$meta = [];
foreach ($entries as $keyword => [$group, $element, $vr, $vm]) {
    $cases[] = "    case {$keyword};";
    $meta[] = sprintf(
        "        '%s' => [0x%04x, 0x%04x, '%s', '%s'],",
        $keyword,
        $group,
        $element,
        $vr,
        $vm,
    );
}

$header = <<<'PHP'
<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
//
// GENERATED FILE -- do not edit by hand.
// Source: tools/codegen/dicom.dic (DCMTK data dictionary, from DICOM PS3.6).
// Regenerate: php tools/codegen/generateTags.php
declare(strict_types=1);

namespace DICOM;

/**
 * Every standard DICOM data element, addressable by its standard keyword. Type
 * Tag:: in an editor to discover the full set; the same keywords appear in the
 * DICOM standard's data dictionary. Each case resolves to its TagInfo
 * (group/element, value representation, value multiplicity) via info().
 */
enum Tag
{
PHP;

$body = implode("\n", $cases) . "\n\n"
    . "    public function info(): TagInfo\n    {\n"
    . "        [\$group, \$element, \$valueRepresentation, \$valueMultiplicity] = self::META[\$this->name];\n\n"
    . "        return new TagInfo(\$group, \$element, \$valueRepresentation, \$valueMultiplicity);\n"
    . "    }\n\n"
    . "    /** @var array<string, array{0: int, 1: int, 2: string, 3: string}> */\n"
    . "    private const array META = [\n"
    . implode("\n", $meta) . "\n"
    . "    ];\n";

file_put_contents($outPath, $header . "\n" . $body . "}\n");

printf(
    "Generated %d tags -> %s\n  skipped: %d non-DICOM source, %d ranges, %d no-keyword, %d bad-keyword\n",
    count($entries),
    $outPath,
    $skippedSource,
    $skippedRange,
    $skippedNoKeyword,
    $skippedBadKeyword,
);
