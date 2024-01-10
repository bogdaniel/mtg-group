<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\FileManipulation\GenerateThumbnails;

use Zenchron\FileBundle\Domain\Contract\GenerateThumbnails;
use Zenchron\FileBundle\Domain\ValueObject\File;

final class GenerateImageThumbnails extends AbstractGenerateImageThumbnails implements GenerateThumbnails
{

    public function support(File $file): bool
    {
        return \str_contains($file->mime(), 'image/') && $file->extension() !== 'gif';
    }
}
