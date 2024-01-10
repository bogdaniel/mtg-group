<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Contract;

interface FilePathResolver
{
    public function resolve(?string $path = null, ?string $breakpoint = null): string;
}
