<?php

namespace Differ\Differ;

use function Differ\parseFile;
use function Differ\DiffTree\build as buildDiffTree;
use function Differ\Formatters\format as formatDiff;

function genDiff(string $path1, string $path2, string $format = 'default'): string
{
    $data1 = parseFile($path1);
    $data2 = parseFile($path2);

    $diffTree = buildDiffTree($data1, $data2);

    return formatDiff($diffTree, $format);
}
