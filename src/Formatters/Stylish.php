<?php

namespace Differ\Formatters\Stylish;

function format(array $diffTree): string
{
    return iter($diffTree, 1);
}

function iter(array $nodes, int $depth): string
{
    $lines = array_map(fn($node) => formatNode($node, $depth), $nodes);

    $open = "{\n";
    $body = implode("\n", $lines);
    $close = "\n" . indent($depth - 1, 0) . "}";

    return "{$open}{$body}{$close}";
}

function formatNode(array $node, int $depth): string
{
    $key = $node['key'];
    $type = $node['type'];

    return match ($type) {
        'added' => line($depth, '+', $key, stringify($node['value'], $depth + 1)),
        'removed' => line($depth, '-', $key, stringify($node['value'], $depth + 1)),
        'unchanged' => line($depth, ' ', $key, stringify($node['value'], $depth + 1)),
        'changed' => implode("\n", [
            line($depth, '-', $key, stringify($node['oldValue'], $depth + 1)),
            line($depth, '+', $key, stringify($node['newValue'], $depth + 1)),
        ]),
        'nested' => line($depth, ' ', $key, iter($node['children'], $depth + 1)),
        default => throw new \RuntimeException("Unknown node type: {$type}"),
    };
}

function line(int $depth, string $sign, string $key, string $value): string
{
    $prefix = indent($depth, 2);
    return "{$prefix}{$sign} {$key}: {$value}";
}

function indent(int $depth, int $shiftLeft): string
{
    $spaces = $depth * 4 - $shiftLeft;
    return str_repeat(' ', max(0, $spaces));
}

function stringify(mixed $value, int $depth): string
{
    if (is_array($value)) {
        return stringifyObject($value, $depth);
    }

    if ($value === null) {
        return 'null';
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    return (string) $value;
}

function stringifyObject(array $value, int $depth): string
{
    $keys = collect(array_keys($value))
        ->sort()
        ->values()
        ->all();

    $lines = array_map(
        fn(string $k): string => sprintf(
            '%s%s: %s',
            indent($depth, 0),
            $k,
            stringify($value[$k], $depth + 1)
        ),
        $keys
    );

    $open = "{\n";
    $body = implode("\n", $lines);
    $close = "\n" . indent($depth - 1, 0) . "}";

    return "{$open}{$body}{$close}";
}
