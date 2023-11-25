<?php

declare(strict_types=1);

namespace App\FileManager\Application\FileManipulation\CompressFile;

use App\FileManager\Domain\Contract\FilePathResolverInterface;
use App\FileManager\Domain\Contract\FileRepositoryInterface;
use App\FileManager\Domain\Contract\MediaRepositoryInterface;
use App\FileManager\Domain\Service\FileCompressHandler;
use App\FileManager\Domain\ValueObject\MediaId;
use App\FileManager\Domain\ValueObject\Thumbnails;

/**
 * Compressing files once files have been resized
 */
class CompressFile
{

    public function __construct(
        private readonly bool $disableCompression,
        private readonly bool $compressOnlyOriginal,
        private readonly FileCompressHandler $compressHandler,
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly FileRepositoryInterface $fileRepository,
        private readonly FilePathResolverInterface $filePathResolver,
    ) {
    }

    public function __invoke(string $mediaId): void
    {
        if ($this->disableCompression) {
            return;
        }
        $media = $this->mediaRepository->getById(MediaId::fromString($mediaId));
        $path  = $this->filePathResolver->resolve($media->file()->path());
        // compress main image
        if(!$this->compressHandler->compress($path, $media->file())) {
            return;
        }
        $oldSize = $media->file()->size();
        $newSize = $this->fileRepository->filesizeFromPath($path);
        if ($newSize !== $oldSize) {
            $media->updateFileSize($newSize);
            $this->mediaRepository->save($media);
        }
        if ($this->compressOnlyOriginal) {
            return;
        }

        // compress thumbnails
        $thumbnails       = $media->thumbnails();
        $updateThumbnails = new Thumbnails();
        $needUpdate       = false;

        /* @var \App\FileManager\Domain\ValueObject\Thumbnail $thumbnail */
        foreach ($thumbnails as $thumbnail) {
            $thumbnailPath = $this->filePathResolver->resolveFromBreakpoint(
                $thumbnail->breakpoint(),
                $media->file()->path()
            );
            $oldSize       = $thumbnail->size();
            if (!$this->compressHandler->compress($thumbnailPath, $media->file())) {
                continue;
            }
            $newSize = $this->fileRepository->filesizeFromPath($thumbnailPath);
            if ($newSize !== $oldSize) {
                $needUpdate = true;
                $updateThumbnails->add($thumbnail->updateSize($newSize));
            } else {
                $updateThumbnails->add($thumbnail);
            }
        }
        if ($needUpdate) {
            $media->updateThumbnails($updateThumbnails);
            $this->mediaRepository->save($media);
        }
    }
}
