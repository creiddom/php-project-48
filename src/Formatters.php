<?php

namespace Differ\Formatters;

use function Differ\Formatters\Stylish\format as formatStylish;

function format(array $diffTree, string $format): string
{
    return match ($format) {
        'stylish', 'default' => formatStylish($diffTree),
        default => throw new \RuntimeException("Unknown format: {$format}"),
    };
}
