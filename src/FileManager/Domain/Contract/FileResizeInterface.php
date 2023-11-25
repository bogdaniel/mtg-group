<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Contract;

use App\FileManager\Domain\ValueObject\Dimension;
use App\FileManager\Domain\ValueObject\File;

interface FileResizeInterface
{
    public function resize(string $inputPath, string $outputPath, Dimension $dimension): bool;

    public function support(File $file): bool;
}
