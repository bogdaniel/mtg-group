<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Infrastructure\Filesystem\Local;

use Psr\Log\LoggerInterface;
use Zenchron\FileBundle\Domain\Contract\TemporaryFileRepository;

class LocalTemporaryFileRepository extends LocalFileRepository implements TemporaryFileRepository
{
    public function __construct(
        private readonly string $temporaryDirectory,
        LocalTemporaryFilePathResolver $localTemporaryFilePathResolver,
        LoggerInterface $logger
    ) {
        parent::__construct($localTemporaryFilePathResolver, $logger);
    }

    public function temporaryFile(string $path): string
    {
        return sprintf(
            '%s%s%s',
            \rtrim($this->temporaryDirectory, \DIRECTORY_SEPARATOR),
            \DIRECTORY_SEPARATOR,
            \ltrim($path, \DIRECTORY_SEPARATOR)
        );
    }
}
