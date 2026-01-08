<?php

namespace Differ\Differ;

use function Differ\getFileData;
use function Differ\parse;
use function Differ\DiffTree\buildDiffTree;
use function Differ\Formatters\formatDiff;

function genDiff(string $path1, string $path2, string $format = 'stylish'): string
{
    [$content1, $ext1] = getFileData($path1);
    [$content2, $ext2] = getFileData($path2);

    $data1 = parse($content1, $ext1);
    $data2 = parse($content2, $ext2);

    $diffTree = buildDiffTree($data1, $data2);

    return formatDiff($diffTree, $format) . PHP_EOL;
}
