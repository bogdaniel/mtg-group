<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Contract;

use Zenchron\FileBundle\Domain\ValueObject\File;

interface FileCompress
{
    public function compress(string $path): void;

    public function support(File $file): bool;
}
