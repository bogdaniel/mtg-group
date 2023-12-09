<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Contract;

use Zenchron\FileManagerBundle\Domain\ValueObject\Dimension;
use Zenchron\FileManagerBundle\Domain\ValueObject\File;

interface FileResizeInterface
{
    public function resize(string $inputPath, string $outputPath, Dimension $dimension): bool;

    public function support(File $file): bool;
}
