<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    #[DataProvider('nestedFilesProvider')]
    public function testGenDiffNestedFiles(
        string $file1,
        string $file2,
        string $format,
        string $expectedFile
    ): void {
        $expected = file_get_contents($expectedFile);
        $this->assertNotFalse($expected);

        $actual = genDiff($file1, $file2, $format);

        $this->assertSame(
            $this->normalize($expected),
            $this->normalize($actual)
        );
    }

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

        $this->assertSame(
            $this->normalize($expected),
            $this->normalize($actual)
        );
    }

    private function normalize(string $value): string
    {
        return rtrim(
            str_replace(["\r\n", "\r"], "\n", $value),
            "\n"
        );
    }

    public static function nestedFilesProvider(): array
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
            'json_json' => [
                $fixtureDir . '/file1.json',
                $fixtureDir . '/file2.json',
                'json',
                $fixtureDir . '/expected.json.txt',
            ],
            'yaml_json' => [
                $fixtureDir . '/file1.yml',
                $fixtureDir . '/file2.yml',
                'json',
                $fixtureDir . '/expected.json.txt',
            ],
        ];
    }

    public static function flatFilesProvider(): array
    {
        $fixtureDir = __DIR__ . '/fixtures';

        return [
            'flat_json_stylish' => [
                $fixtureDir . '/file1.flat.json',
                $fixtureDir . '/file2.flat.json',
                'stylish',
                $fixtureDir . '/expected.flat.txt',
            ],
            'flat_yaml_stylish' => [
                $fixtureDir . '/file1.flat.yml',
                $fixtureDir . '/file2.flat.yml',
                'stylish',
                $fixtureDir . '/expected.flat.txt',
            ],
        ];
    }
}
