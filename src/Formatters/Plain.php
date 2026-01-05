<?php

namespace Differ\Formatters\Plain;

function format(array $diffTree): string
{
    $lines = iter($diffTree, '');
    return implode("\n", $lines);
}

function iter(array $nodes, string $path): array
{
    $result = [];

    foreach ($nodes as $node) {
        $key = $node['key'];
        $propertyPath = $path === '' ? $key : "{$path}.{$key}";
        $type = $node['type'];

        if ($type === 'nested') {
            $children = $node['children'] ?? [];
            $result = array_merge($result, iter($children, $propertyPath));
            continue;
        }

        if ($type === 'added') {
            $value = formatValue($node['value']);
            $result[] = "Property '{$propertyPath}' was added with value: {$value}";
            continue;
        }

        if ($type === 'removed') {
            $result[] = "Property '{$propertyPath}' was removed";
            continue;
        }

        if ($type === 'changed') {
            $from = formatValue($node['oldValue']);
            $to = formatValue($node['newValue']);
            $result[] = "Property '{$propertyPath}' was updated. From {$from} to {$to}";
            continue;
        }

        if ($type === 'unchanged') {
            continue;
        }
    }

    return $result;
}

function formatValue(mixed $value): string
{
    if (is_array($value)) {
        return '[complex value]';
    }

    if ($value === null) {
        return 'null';
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if (is_string($value)) {
        return "'" . $value . "'";
    }

    return (string) $value;
}
