<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Contract;

use Zenchron\FileBundle\Domain\ValueObject\Dimension;
use Zenchron\FileBundle\Domain\ValueObject\File;

interface FileResize
{
    public function resize(string $inputPath, string $outputPath, Dimension $dimension): bool;

    public function support(File $file): bool;
}
