<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\FileManipulation\GenerateThumbnails;

use Zenchron\FileBundle\Domain\Contract\GenerateThumbnails;
use Zenchron\FileBundle\Domain\ValueObject\File;

final class GenerateGifImageThumbnails extends AbstractGenerateImageThumbnails implements GenerateThumbnails
{

    public function support(File $file): bool
    {
        return $file->extension() === 'gif';
    }
}
