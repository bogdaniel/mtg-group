<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Contract;

interface FilePathResolverInterface
{
    public function resolve(?string $path = null): string;

    public function resolveFromBreakpoint(string $breakpoint, ?string $path = null): string;
}
