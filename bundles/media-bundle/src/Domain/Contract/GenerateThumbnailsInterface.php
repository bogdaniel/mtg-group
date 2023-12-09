<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Domain\Contract;

use Zenchron\FileManagerBundle\Domain\ValueObject\File;

interface GenerateThumbnailsInterface
{
    public function generate(string $mediaId): void;

    public function support(File $file): bool;
}
