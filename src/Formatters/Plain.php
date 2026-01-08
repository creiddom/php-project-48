<?php

namespace Differ\Formatters\Plain;

function format(array $diffTree): string
{
    return implode("\n", iter($diffTree, ''));
}

function iter(array $nodes, string $path): array
{
    $chunks = array_map(fn(array $node): array => formatNode($node, $path), $nodes);

    return array_merge([], ...$chunks);
}

function formatNode(array $node, string $path): array
{
    $key = $node['key'];
    $propertyPath = $path === '' ? $key : "{$path}.{$key}";
    $type = $node['type'];

    return match ($type) {
        'nested' => iter($node['children'] ?? [], $propertyPath),
        'added' => [
            sprintf(
                "Property '%s' was added with value: %s",
                $propertyPath,
                formatValue($node['value'])
            ),
        ],
        'removed' => [
            sprintf("Property '%s' was removed", $propertyPath),
        ],
        'changed' => [
            sprintf(
                "Property '%s' was updated. From %s to %s",
                $propertyPath,
                formatValue($node['oldValue']),
                formatValue($node['newValue'])
            ),
        ],
        'unchanged' => [],
        default => throw new \RuntimeException("Unknown node type: {$type}"),
    };
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
        return "'{$value}'";
    }

    return (string) $value;
}
