<?php
declare(strict_types=1);

namespace App\FileManager\Application\FileManipulation\Thumbnails\RenameThumbnails;

use App\FileManager\Domain\Contract\FilePathResolverInterface;
use App\FileManager\Domain\Contract\FileRepositoryInterface;
use App\FileManager\Domain\Contract\FileUrlResolverInterface;
use App\FileManager\Domain\ValueObject\Thumbnail;
use App\FileManager\Domain\ValueObject\Thumbnails;

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
