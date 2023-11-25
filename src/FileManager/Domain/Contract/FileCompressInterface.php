<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Contract;

use App\FileManager\Domain\ValueObject\File;

interface FileCompressInterface
{
    public function compress(string $absolutePath): void;

    public function support(File $file): bool;
}
