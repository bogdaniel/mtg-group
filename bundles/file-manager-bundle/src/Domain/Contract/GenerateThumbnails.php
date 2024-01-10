<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Domain\Contract;

use Zenchron\FileBundle\Domain\ValueObject\Dimension;
use Zenchron\FileBundle\Domain\ValueObject\File;

interface GenerateThumbnails
{
    public function generate(string $mediaId, File $file, Dimension $dimension): void;

    public function support(File $file): bool;
}
