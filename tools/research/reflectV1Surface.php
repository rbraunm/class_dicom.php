<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm

/*
 * Phase 0.5 -- reflect the v1 public surface into JSON (clean-room).
 *
 * Includes the legacy library and reports its public surface -- classes (with their public
 * methods, constants, and properties) and top-level functions -- as deterministic JSON. It finds
 * the library's symbols by diffing the declared classes/functions before and after the include,
 * so it needs no prior knowledge of their names and never reads the source text. Reflection
 * exposes signatures, not method bodies, so the output is interface facts only (names, parameter
 * and return types, visibility) -- reusable across the relicense and serving as the frozen
 * contract the v2 compatibility shim must reproduce.
 *
 * Usage:  php reflectV1Surface.php [path/to/class_dicom.php]
 *   Default path: the repo-root class_dicom.php (two directories up from tools/research/).
 *   JSON goes to stdout. Anything the include itself emits, and any error, goes to stderr so
 *   stdout stays valid JSON. Exits non-zero (loudly) if the file is missing or fails to load.
 */

declare(strict_types=1);

function fail(string $message): never
{
    fwrite(STDERR, "reflectV1Surface: {$message}\n");
    exit(1);
}

function typeToString(?ReflectionType $type): ?string
{
    if ($type === null) {
        return null;
    }
    if ($type instanceof ReflectionNamedType) {
        $bare = $type->getName();
        $nullable = $type->allowsNull() && $bare !== 'mixed' && $bare !== 'null';
        return ($nullable ? '?' : '') . $bare;
    }
    if ($type instanceof ReflectionUnionType) {
        return implode('|', array_map(static fn (ReflectionType $t): string => (string) $t, $type->getTypes()));
    }
    if ($type instanceof ReflectionIntersectionType) {
        return implode('&', array_map(static fn (ReflectionType $t): string => (string) $t, $type->getTypes()));
    }
    return (string) $type;
}

function encodableValue(mixed $value): mixed
{
    // Keep scalars/null/arrays (JSON-encodable); represent anything exotic by its type so a
    // surprising constant or default can never make the report fail to serialize.
    if ($value === null || is_scalar($value)) {
        return $value;
    }
    if (is_array($value)) {
        return array_map(static fn (mixed $v): mixed => encodableValue($v), $value);
    }
    return ['__nonScalar' => get_debug_type($value)];
}

function reflectParameter(ReflectionParameter $parameter): array
{
    $entry = [
        'name' => $parameter->getName(),
        'position' => $parameter->getPosition(),
        'type' => typeToString($parameter->getType()),
        'optional' => $parameter->isOptional(),
        'variadic' => $parameter->isVariadic(),
        'byReference' => $parameter->isPassedByReference(),
        'hasDefault' => $parameter->isDefaultValueAvailable(),
    ];
    if ($parameter->isDefaultValueAvailable()) {
        $entry['default'] = $parameter->isDefaultValueConstant()
            ? ['__constant' => $parameter->getDefaultValueConstantName()]
            : encodableValue($parameter->getDefaultValue());
    }
    return $entry;
}

function reflectMethod(ReflectionMethod $method): array
{
    $parameters = array_map(reflectParameter(...), $method->getParameters());
    usort($parameters, static fn (array $a, array $b): int => $a['position'] <=> $b['position']);
    return [
        'name' => $method->getName(),
        'static' => $method->isStatic(),
        'abstract' => $method->isAbstract(),
        'returnType' => typeToString($method->getReturnType()),
        'parameters' => $parameters,
    ];
}

function reflectClass(string $name): array
{
    $class = new ReflectionClass($name);

    $methods = array_map(reflectMethod(...), $class->getMethods(ReflectionMethod::IS_PUBLIC));
    usort($methods, static fn (array $a, array $b): int => strcmp($a['name'], $b['name']));

    $constants = [];
    foreach ($class->getReflectionConstants(ReflectionClassConstant::IS_PUBLIC) as $constant) {
        $constants[] = ['name' => $constant->getName(), 'value' => encodableValue($constant->getValue())];
    }
    usort($constants, static fn (array $a, array $b): int => strcmp($a['name'], $b['name']));

    $properties = [];
    foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
        $properties[] = [
            'name' => $property->getName(),
            'static' => $property->isStatic(),
            'type' => typeToString($property->getType()),
        ];
    }
    usort($properties, static fn (array $a, array $b): int => strcmp($a['name'], $b['name']));

    $kind = match (true) {
        $class->isInterface() => 'interface',
        $class->isTrait() => 'trait',
        $class->isAbstract() => 'abstract class',
        default => 'class',
    };

    return [
        'name' => $class->getName(),
        'kind' => $kind,
        'methods' => $methods,
        'constants' => $constants,
        'properties' => $properties,
    ];
}

function reflectFunction(string $name): array
{
    $function = new ReflectionFunction($name);
    $parameters = array_map(reflectParameter(...), $function->getParameters());
    usort($parameters, static fn (array $a, array $b): int => $a['position'] <=> $b['position']);
    return [
        'name' => $function->getName(),
        'returnType' => typeToString($function->getReturnType()),
        'parameters' => $parameters,
    ];
}

// --- locate the legacy library ---------------------------------------------
$default = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'class_dicom.php';
$legacy = $argv[1] ?? $default;
if (!is_file($legacy)) {
    fail("legacy library not found at: {$legacy} (pass the path as the first argument).");
}

// --- snapshot, include, diff -----------------------------------------------
$classesBefore = array_merge(get_declared_classes(), get_declared_interfaces(), get_declared_traits());
$functionsBefore = get_defined_functions()['user'];

ob_start();
try {
    require $legacy;
} catch (Throwable $error) {
    $noise = ob_get_clean();
    if (is_string($noise) && $noise !== '') {
        fwrite(STDERR, $noise . "\n");
    }
    fail('including the legacy library threw ' . $error::class . ': ' . $error->getMessage());
}
$noise = ob_get_clean();
if (is_string($noise) && $noise !== '') {
    fwrite(STDERR, "(include emitted output; kept off stdout)\n{$noise}\n");
}

$classesAfter = array_merge(get_declared_classes(), get_declared_interfaces(), get_declared_traits());
$functionsAfter = get_defined_functions()['user'];

$newClasses = array_values(array_diff($classesAfter, $classesBefore));
$newFunctions = array_values(array_diff($functionsAfter, $functionsBefore));
sort($newClasses);
sort($newFunctions);

$surface = [
    'meta' => [
        'generator' => 'tools/research/reflectV1Surface.php',
        'description' => 'class_dicom.php v1 public surface, reflected. Interface facts only '
            . '(names, signatures, visibility); no implementation. Frozen contract for the v2 '
            . 'compatibility shim.',
    ],
    'functions' => array_map(reflectFunction(...), $newFunctions),
    'classes' => array_map(reflectClass(...), $newClasses),
];

echo json_encode($surface, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), "\n";
