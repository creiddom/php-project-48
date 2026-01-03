<?php

namespace Differ\DiffTree;

function build(array $data1, array $data2): array
{
    $keys = array_values(array_unique(array_merge(array_keys($data1), array_keys($data2))));
    sort($keys);

    $result = [];

    foreach ($keys as $key) {
        $has1 = array_key_exists($key, $data1);
        $has2 = array_key_exists($key, $data2);

        if (!$has1 && $has2) {
            $result[] = [
                'type' => 'added',
                'key' => $key,
                'value' => $data2[$key],
            ];
            continue;
        }

        if ($has1 && !$has2) {
            $result[] = [
                'type' => 'removed',
                'key' => $key,
                'value' => $data1[$key],
            ];
            continue;
        }

        $v1 = $data1[$key];
        $v2 = $data2[$key];

        if (isAssocArray($v1) && isAssocArray($v2)) {
            $result[] = [
                'type' => 'nested',
                'key' => $key,
                'children' => build($v1, $v2),
            ];
            continue;
        }

        if ($v1 === $v2) {
            $result[] = [
                'type' => 'unchanged',
                'key' => $key,
                'value' => $v1,
            ];
            continue;
        }

        $result[] = [
            'type' => 'changed',
            'key' => $key,
            'oldValue' => $v1,
            'newValue' => $v2,
        ];
    }

    return $result;
}

function isAssocArray(mixed $value): bool
{
    if (!is_array($value)) {
        return false;
    }

    // Ассоциативный массив: ключи не равны 0..n-1
    return array_keys($value) !== range(0, count($value) - 1);
}
