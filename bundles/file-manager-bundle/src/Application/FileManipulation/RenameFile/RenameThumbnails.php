<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\FileManipulation\RenameFile;

use Zenchron\FileBundle\Domain\Contract\FileRepository;
use Zenchron\FileBundle\Domain\Service\ThumbnailPathResolver;
use Zenchron\FileBundle\Domain\ValueObject\Thumbnail;
use Zenchron\FileBundle\Domain\ValueObject\Thumbnails;

class RenameThumbnails
{

    public function __construct(
        private readonly FileRepository $fileRepository,
    ) {
    }

    public function __invoke(Thumbnails $thumbnails, string $newFileName): Thumbnails
    {
        $newThumbnails = new Thumbnails();
        /* @var Thumbnail $thumbnail */
        foreach ($thumbnails as $thumbnail) {
            $oldPath = $thumbnail->path();
            $newPath = ThumbnailPathResolver::resolve($newFileName, $thumbnail->breakpoint());
            $this->fileRepository->rename($oldPath, $newPath);
            $newThumbnails->add($thumbnail->rename($newFileName, $newPath));
        }

        return $newThumbnails;
    }

}
