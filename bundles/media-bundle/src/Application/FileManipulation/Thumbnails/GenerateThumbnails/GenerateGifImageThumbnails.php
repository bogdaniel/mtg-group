<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\FileManipulation\Thumbnails\GenerateThumbnails;

use Zenchron\FileManagerBundle\Domain\Contract\GenerateThumbnailsInterface;
use Zenchron\FileManagerBundle\Domain\ValueObject\File;

final class GenerateGifImageThumbnails extends AbstractGenerateImageThumbnails implements GenerateThumbnailsInterface
{

    public function support(File $file): bool
    {
        return $file->extension() === 'gif';
    }
}
