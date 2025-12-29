<?php

namespace Differ\Differ;

use function Differ\parseFile;
use function Funct\Collection\sortBy;

function genDiff(string $path1, string $path2): string
{
    $data1 = parseFile($path1);
    $data2 = parseFile($path2);

    $keys = array_values(array_unique(array_merge(array_keys($data1), array_keys($data2))));
    $sortedKeys = sortBy($keys, fn($key) => $key);

    $lines = array_map(function ($key) use ($data1, $data2) {
        $has1 = array_key_exists($key, $data1);
        $has2 = array_key_exists($key, $data2);

        if ($has1 && !$has2) {
            return [formatLine('-', $key, $data1[$key])];
        }

        if (!$has1 && $has2) {
            return [formatLine('+', $key, $data2[$key])];
        }

        if ($data1[$key] === $data2[$key]) {
            return [formatLine(' ', $key, $data1[$key])];
        }

        return [
            formatLine('-', $key, $data1[$key]),
            formatLine('+', $key, $data2[$key]),
        ];
    }, $sortedKeys);

    $flatLines = array_merge(...$lines);

    return "{\n" . implode("\n", $flatLines) . "\n}";
}

function formatLine(string $sign, string $key, mixed $value): string
{
    return "  {$sign} {$key}: " . stringify($value);
}

function stringify(mixed $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if ($value === null) {
        return 'null';
    }

    if (is_array($value)) {
        return '[complex value]';
    }

    return (string) $value;
}
