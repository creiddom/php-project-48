<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\format as formatStylish;
use function Differ\Formatters\Plain\format as formatPlain;
use function Differ\Formatters\Json\format as formatJson;

function format(array $diffTree, string $formatName): string
{
    $formatter = getFormatter($formatName);
    return $formatter($diffTree);
}

function getFormatter(string $formatName): callable
{
    return match ($formatName) {
        'stylish' => fn(array $tree): string => formatStylish($tree),
        'plain' => fn(array $tree): string => formatPlain($tree),
        'json' => fn(array $tree): string => formatJson($tree),
        default => throw new \RuntimeException("Unknown format: {$formatName}"),
    };
}
