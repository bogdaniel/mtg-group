<?php

declare(strict_types=1);


namespace App\FileManager\Infrastructure\Persistence\Dql\Sqlite;

/**
 * https://github.com/beberlei/DoctrineExtensions
 */
class Month extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%m';
    }
}
