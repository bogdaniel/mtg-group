<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Contract;

interface FileUrlResolverInterface
{
    public function resolve(string $path, bool $absolute = false): string;

    public function resolveFromBreakpoint(string $breakpoint, string $path, bool $absolute = false): string;

    public function resolvePathFromBreakpoint(string $breakpoint, string $path): string;
}
