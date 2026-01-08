<?php

namespace Differ\Cli;

use Docopt\Handler;

use function Differ\Differ\genDiff;

function run(): void
{
    $doc = <<<DOC
        Generate diff

        Usage:
          gendiff (-h|--help)
          gendiff (-v|--version)
          gendiff [--format <fmt>] <firstFile> <secondFile>

        Options:
          -h --help                     Show this screen
          -v --version                  Show version
          --format <fmt>                Report format [default: stylish]
        DOC;

    $handler = new Handler();
    $args = $handler->handle($doc);

    echo genDiff(
        $args['<firstFile>'],
        $args['<secondFile>'],
        $args['--format']
    );
}
