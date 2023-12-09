<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\FileManipulation\Thumbnails\RenameThumbnails;

use Zenchron\FileManagerBundle\Domain\Contract\FilePathResolverInterface;
use Zenchron\FileManagerBundle\Domain\Contract\FileRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Contract\FileUrlResolverInterface;
use Zenchron\FileManagerBundle\Domain\ValueObject\Thumbnail;
use Zenchron\FileManagerBundle\Domain\ValueObject\Thumbnails;

class RenameThumbnails
{

    public function __construct(
        private readonly FileRepositoryInterface $fileRepository,
        private readonly FileUrlResolverInterface $fileUrlResolver,
        private readonly FilePathResolverInterface $filePathResolver,
    ) {
    }

    public function __invoke(Thumbnails $thumbnails, string $newFileName): Thumbnails
    {
        $newThumbnails = new Thumbnails();
        /* @var Thumbnail $thumbnail */
        foreach ($thumbnails as $thumbnail) {
            $oldPath = $this->filePathResolver->resolveFromBreakpoint($thumbnail->breakpoint(), $thumbnail->name());
            $newPath = $this->filePathResolver->resolveFromBreakpoint($thumbnail->breakpoint(), $newFileName);
            $this->fileRepository->rename($oldPath, $newPath);

            $thumbnailPath = $this->fileUrlResolver->resolvePathFromBreakpoint($thumbnail->breakpoint(), $newFileName);
            $newThumbnails->add($thumbnail->rename($newFileName, $thumbnailPath));
        }

        return $newThumbnails;
    }

}
