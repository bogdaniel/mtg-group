<?php

declare(strict_types=1);


namespace Zenchron\FileBundle\Application\FileManipulation\WriteFile;

use Zenchron\FileBundle\Domain\Contract\FileRepository;
use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\FileBundle\Domain\Contract\TemporaryFileRepository;
use Zenchron\FileBundle\Domain\Service\ThumbnailPathResolver;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;
use Zenchron\FileBundle\Domain\ValueObject\Thumbnail;
use Zenchron\FileBundle\Domain\ValueObject\Thumbnails;
use Zenchron\FileBundle\Infrastructure\Filesystem\Exception\WriteTemporaryFileToOriginException;

class WriteTemporaryFileToOrigin
{
    /**
     * @param array<string, mixed> $breakpoints
     * @param MediaRepository $mediaRepository
     * @param FileRepository $fileRepository
     * @param TemporaryFileRepository $temporaryFileRepository
     */
    public function __construct(
        private readonly array $breakpoints,
        private readonly MediaRepository $mediaRepository,
        private readonly FileRepository $fileRepository,
        private readonly TemporaryFileRepository $temporaryFileRepository,
    ) {
    }

    public function __invoke(string $mediaId): void
    {
        $media = $this->mediaRepository->getById(MediaId::fromString($mediaId));
        $file  = $media->file();

        try {
            // prepare temporary file for processing
            $temporaryOriginalPath = $this->temporaryFileRepository->temporaryFile($file->path());
            if (!$this->temporaryFileRepository->exists($temporaryOriginalPath)) {
                throw new WriteTemporaryFileToOriginException(
                    \sprintf('Temporary %s file is not found', $temporaryOriginalPath)
                );
            }
            /* 1 - write original file to origin */
            $this->fileRepository->write($temporaryOriginalPath, $file->path());
            $file = $file->changeSize($this->temporaryFileRepository->filesize($temporaryOriginalPath));
            $media->changeFile($file, $media->createdBy());
            $media->changeDimension(
                $this->temporaryFileRepository->dimension(
                    $temporaryOriginalPath,
                    $file->mime()
                )
            );

            /* 2 - write thumbnails to origin */
            $thumbnails = new Thumbnails();
            foreach ($this->breakpoints as $nameBreakpoint => $dimensionBreakpoint) {
                $thumbnailPath          = ThumbnailPathResolver::resolve($file->path(), $nameBreakpoint);
                $temporaryThumbnailPath = $this->temporaryFileRepository->temporaryFile($thumbnailPath);
                if (!$this->temporaryFileRepository->exists($temporaryThumbnailPath)) {
                    continue;
                }
                $this->fileRepository->write($temporaryThumbnailPath, $thumbnailPath);
                $thumbnails->add(
                    new Thumbnail(
                        $nameBreakpoint,
                        $file->name(),
                        $thumbnailPath,
                        $this->temporaryFileRepository->filesize($temporaryThumbnailPath),
                        $this->temporaryFileRepository->dimension($temporaryThumbnailPath, $file->mime())
                    )
                );
            }
            $media->changeThumbnails($thumbnails);
            $this->mediaRepository->save($media);
        } catch (\Throwable $e) {
            $this->mediaRepository->delete($media);
            throw new WriteTemporaryFileToOriginException($e->getMessage(), $e->getPrevious());
        }
    }
}
