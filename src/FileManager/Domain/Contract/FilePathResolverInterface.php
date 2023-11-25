<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Contract;

interface FilePathResolverInterface
{
    public function resolve(?string $path = null): string;

    public function resolveFromBreakpoint(string $breakpoint, ?string $path = null): string;
}
