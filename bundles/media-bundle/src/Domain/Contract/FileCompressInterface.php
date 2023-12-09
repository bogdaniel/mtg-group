<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Contract;

use Zenchron\FileManagerBundle\Domain\ValueObject\File;

interface FileCompressInterface
{
    public function compress(string $absolutePath): void;

    public function support(File $file): bool;
}
