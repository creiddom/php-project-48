<?php

namespace Differ;

function parseFile(string $path): array
{
    $fullPath = realpath($path);
    if ($fullPath === false) {
        throw new \RuntimeException("File not found: {$path}");
    }

    $content = file_get_contents($fullPath);
    if ($content === false) {
        throw new \RuntimeException("Cannot read file: {$fullPath}");
    }

    $data = json_decode($content, true);
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new \RuntimeException('Invalid JSON: ' . json_last_error_msg());
    }

    return $data;
}
