<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiffFlatJson(): void
    {
        $fixtureDir = __DIR__ . '/fixtures';

        $file1 = $fixtureDir . '/file1.json';
        $file2 = $fixtureDir . '/file2.json';

        $expected = file_get_contents($fixtureDir . '/expected.txt');
        $this->assertNotFalse($expected);

        $actual = genDiff($file1, $file2);

        $normalize = fn(string $s): string => rtrim(str_replace(["\r\n", "\r"], "\n", $s), "\n");

        $this->assertSame($normalize($expected), $normalize($actual));
    }
}
