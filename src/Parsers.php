<?php

namespace Differ;

use Symfony\Component\Yaml\Yaml;

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

    $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

    if ($ext === 'json') {
        return parseJson($content);
    }

    if ($ext === 'yml' || $ext === 'yaml') {
        return parseYaml($content);
    }

    throw new \RuntimeException("Unsupported file format: {$ext}");
}

function parseJson(string $content): array
{
    $data = json_decode($content, true);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new \RuntimeException('Invalid JSON: ' . json_last_error_msg());
    }

    if (!is_array($data)) {
        throw new \RuntimeException('Invalid JSON: expected an object with key-value pairs');
    }

    return $data;
}

function parseYaml(string $content): array
{
    $data = Yaml::parse($content);

    // пустой файл YAML
    if ($data === null) {
        return [];
    }

    if (!is_array($data)) {
        throw new \RuntimeException('Invalid YAML: expected an object with key-value pairs');
    }

    return $data;
}
