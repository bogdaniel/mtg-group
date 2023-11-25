<?php
declare(strict_types=1);

namespace App\FileManager\Domain\Contract;

use App\FileManager\Domain\ValueObject\File;

interface GenerateThumbnailsInterface
{
    public function generate(string $mediaId): void;

    public function support(File $file): bool;
}
