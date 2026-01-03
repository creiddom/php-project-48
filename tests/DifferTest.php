<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    #[DataProvider('flatFilesProvider')]

    public function testGenDiffFlatFiles(string $file1, string $file2): void
    {
        $fixtureDir = __DIR__ . '/fixtures';

        $expected = file_get_contents($fixtureDir . '/expected.stylish.txt');
        $this->assertNotFalse($expected);

        $actual = genDiff($file1, $file2, 'stylish');

        $normalize = fn(string $s): string => rtrim(str_replace(["\r\n", "\r"], "\n", $s), "\n");

        $this->assertSame($normalize($expected), $normalize($actual));
    }

    public static function flatFilesProvider(): array
    {
        $fixtureDir = __DIR__ . '/fixtures';

        return [
            'json' => [
                $fixtureDir . '/file1.json',
                $fixtureDir . '/file2.json',
            ],
            'yaml' => [
                $fixtureDir . '/file1.yml',
                $fixtureDir . '/file2.yml',
            ],
        ];
    }
}
