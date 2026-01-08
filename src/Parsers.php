<?php

namespace Differ;

use Symfony\Component\Yaml\Yaml;

function getFileData(string $path): array
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

    return [$content, $ext];
}

function parse(string $content, string $ext): array
{
    $parser = getParser($ext);
    return $parser($content);
}

function parseJson(string $content): array
{
    $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

    if (!is_array($data)) {
        throw new \RuntimeException('Invalid JSON: expected an object with key-value pairs');
    }

    return $data;
}

function parseYaml(string $content): array
{
    $data = Yaml::parse($content);

    if ($data === null) {
        return [];
    }

    if (!is_array($data)) {
        throw new \RuntimeException('Invalid YAML: expected an object with key-value pairs');
    }

    return $data;
}

function getParser(string $ext): callable
{
    return match ($ext) {
        'json' => fn(string $content): array => parseJson($content),
        'yml', 'yaml' => fn(string $content): array => parseYaml($content),
        default => throw new \RuntimeException("Unsupported file format: {$ext}"),
    };
}
