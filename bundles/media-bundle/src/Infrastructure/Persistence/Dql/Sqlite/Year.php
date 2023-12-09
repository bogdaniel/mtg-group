<?php

declare(strict_types=1);


namespace Zenchron\FileManagerBundle\Infrastructure\Persistence\Dql\Sqlite;

/**
 * https://github.com/beberlei/DoctrineExtensions
 */
class Year extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%Y';
    }
}
