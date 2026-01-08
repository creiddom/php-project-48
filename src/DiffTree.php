<?php

namespace Differ\DiffTree;

function buildDiffTree(array $data1, array $data2): array
{
    $keys = collect(array_merge(array_keys($data1), array_keys($data2)))
        ->unique()
        ->sort()
        ->values()
        ->all();

    return array_map(fn(string $key): array => buildNode($key, $data1, $data2), $keys);
}

function buildNode(string $key, array $data1, array $data2): array
{
    $has1 = array_key_exists($key, $data1);
    $has2 = array_key_exists($key, $data2);

    if (!$has1) {
        return [
            'type' => 'added',
            'key' => $key,
            'value' => $data2[$key],
        ];
    }

    if (!$has2) {
        return [
            'type' => 'removed',
            'key' => $key,
            'value' => $data1[$key],
        ];
    }

    $v1 = $data1[$key];
    $v2 = $data2[$key];

    if (isAssocArray($v1) && isAssocArray($v2)) {
        return [
            'type' => 'nested',
            'key' => $key,
            'children' => buildDiffTree($v1, $v2),
        ];
    }

    if ($v1 === $v2) {
        return [
            'type' => 'unchanged',
            'key' => $key,
            'value' => $v1,
        ];
    }

    return [
        'type' => 'changed',
        'key' => $key,
        'oldValue' => $v1,
        'newValue' => $v2,
    ];
}

function isAssocArray(mixed $value): bool
{
    if (!is_array($value)) {
        return false;
    }

    return array_keys($value) !== range(0, count($value) - 1);
}
