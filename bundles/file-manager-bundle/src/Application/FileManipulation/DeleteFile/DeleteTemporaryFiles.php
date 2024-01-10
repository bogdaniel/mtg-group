<?php

declare(strict_types=1);


namespace Zenchron\FileBundle\Application\FileManipulation\DeleteFile;

use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\FileBundle\Domain\Contract\TemporaryFileRepository;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;

class DeleteTemporaryFiles
{
    /**
     * @param MediaRepository $mediaRepository
     * @param TemporaryFileRepository $temporaryFileRepository
     */
    public function __construct(
        private readonly MediaRepository $mediaRepository,
        private readonly TemporaryFileRepository $temporaryFileRepository,
    ) {
    }

    public function __invoke(string $mediaId): void
    {
        $media = $this->mediaRepository->getById(MediaId::fromString($mediaId));
        $file  = $media->file();

        $temporaryOriginalPath = $this->temporaryFileRepository->temporaryFile($file->path());
        if ($this->temporaryFileRepository->exists($temporaryOriginalPath)) {
            $this->temporaryFileRepository->delete($temporaryOriginalPath);
        }

        foreach ($media->thumbnails() as $thumbnail) {
            $temporaryThumbnailPath = $this->temporaryFileRepository->temporaryFile($thumbnail->path());
            if ($this->temporaryFileRepository->exists($temporaryThumbnailPath)) {
                $this->temporaryFileRepository->delete($temporaryThumbnailPath);
            }
        }
    }
}
