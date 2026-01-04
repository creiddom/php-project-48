<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    #[DataProvider('flatFilesProvider')]
    public function testGenDiffFlatFiles(
        string $file1,
        string $file2,
        string $format,
        string $expectedFile
    ): void {
        $expected = file_get_contents($expectedFile);
        $this->assertNotFalse($expected);

        $actual = genDiff($file1, $file2, $format);

        $normalize = fn(string $s): string =>
            rtrim(str_replace(["\r\n", "\r"], "\n", $s), "\n");

        $this->assertSame($normalize($expected), $normalize($actual));
    }

    public static function flatFilesProvider(): array
    {
        $fixtureDir = __DIR__ . '/fixtures';

        return [
            'json_stylish' => [
                $fixtureDir . '/file1.json',
                $fixtureDir . '/file2.json',
                'stylish',
                $fixtureDir . '/expected.stylish.txt',
            ],
            'yaml_stylish' => [
                $fixtureDir . '/file1.yml',
                $fixtureDir . '/file2.yml',
                'stylish',
                $fixtureDir . '/expected.stylish.txt',
            ],
            'json_plain' => [
                $fixtureDir . '/file1.json',
                $fixtureDir . '/file2.json',
                'plain',
                $fixtureDir . '/expected.plain.txt',
            ],
            'yaml_plain' => [
                $fixtureDir . '/file1.yml',
                $fixtureDir . '/file2.yml',
                'plain',
                $fixtureDir . '/expected.plain.txt',
            ],
        ];
    }
}
