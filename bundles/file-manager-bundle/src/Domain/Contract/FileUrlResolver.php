<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Contract;

interface FileUrlResolver
{
    public function resolve(string $path, ?string $breakpoint = null): string;

}
