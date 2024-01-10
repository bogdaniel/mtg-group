<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Infrastructure\Filesystem\Local;

use Zenchron\FileBundle\Domain\Contract\FilePathResolver;
use Zenchron\FileBundle\Domain\Enum\Breakpoint;
use Zenchron\FileBundle\Domain\Exception\InvalidBreakpointException;
use Zenchron\FileBundle\Domain\Service\ThumbnailPathResolver;
use Zenchron\SharedBundle\Common\FileHelper;

final class LocalTemporaryFilePathResolver implements FilePathResolver
{
    public function __construct(
        private readonly string $temporaryDirectory
    ) {
    }

    public function resolve(?string $path = null, ?string $breakpoint = null): string
    {
        if ($path && (
            \str_starts_with($path, $this->temporaryDirectory) || \str_starts_with($path, \sys_get_temp_dir())
        )) {
            return $path;
        }
        if ($breakpoint && !Breakpoint::tryFrom($breakpoint)) {
            throw InvalidBreakpointException::withName($breakpoint);
        }

        if ($breakpoint && $path) {
            $path = ThumbnailPathResolver::resolve(
                $path,
                $breakpoint,
                \DIRECTORY_SEPARATOR
            );
        }

        return FileHelper::pathJoin($this->temporaryDirectory, $path ?? '');
    }
}
