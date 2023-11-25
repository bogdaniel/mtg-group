<?php
declare(strict_types=1);

namespace App\FileManager\Application\FileManipulation\Thumbnails\GenerateThumbnails;

use App\FileManager\Domain\Contract\GenerateThumbnailsInterface;
use App\FileManager\Domain\ValueObject\File;

final class GenerateImageThumbnails extends AbstractGenerateImageThumbnails implements GenerateThumbnailsInterface
{

    public function support(File $file): bool
    {
        return \str_contains($file->mime(), 'image/') && $file->extension() !== 'gif';
    }
}
