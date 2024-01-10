<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Application\FileManipulation\GenerateThumbnails;

use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\FileBundle\Domain\Contract\TemporaryFileRepository;
use Zenchron\FileBundle\Domain\Service\FileResizeHandler;
use Zenchron\FileBundle\Domain\Service\ThumbnailPathResolver;
use Zenchron\FileBundle\Domain\ValueObject\Dimension;
use Zenchron\FileBundle\Domain\ValueObject\File;

abstract class AbstractGenerateImageThumbnails
{
    /**
     * @param int|null $originalMaxWidth
     * @param array<string, mixed> $breakpoints
     * @param FileResizeHandler $fileResizeHandler
     * @param MediaRepository $mediaRepository
     * @param TemporaryFileRepository $temporaryFileRepository
     */
    public function __construct(
        protected readonly ?int $originalMaxWidth,
        protected readonly array $breakpoints,
        protected readonly FileResizeHandler $fileResizeHandler,
        protected readonly MediaRepository $mediaRepository,
        protected readonly TemporaryFileRepository $temporaryFileRepository,
    ) {
    }

    public function generate(string $mediaId, File $file, Dimension $dimension): void
    {

        if (!$this->fileResizeHandler->support($file)) {
            return;
        }
        // resize original if originalMaxWidth is set
        if (\is_int($this->originalMaxWidth)) {
            $this->resizeOriginal($file, $dimension);
        }
        // generate thumbnails
        $this->generateThumbnails($file, $dimension);
    }

    protected function resizeOriginal(File $file, Dimension $dimension): void
    {
        if ($dimension->width() && $dimension->width() > $this->originalMaxWidth) {
            $temporaryOutputPath = $this->temporaryFileRepository->temporaryFile($file->path());
            $this->fileResizeHandler->resize(
                $file,
                $temporaryOutputPath,
                $temporaryOutputPath,
                new Dimension($this->originalMaxWidth)
            );
        }
    }

    protected function generateThumbnails(File $file, Dimension $dimension): void
    {
        $temporaryOriginalPath = $this->temporaryFileRepository->temporaryFile($file->path());

        foreach ($this->breakpoints as $nameBreakpoint => $dimensionBreakpoint) {
            if ($dimensionBreakpoint[0] && $dimensionBreakpoint[0] >= $dimension->width()) {
                continue;
            }
            $thumbnailPath          = ThumbnailPathResolver::resolve($file->path(), $nameBreakpoint);
            $temporaryThumbnailPath = $this->temporaryFileRepository->temporaryFile($thumbnailPath);
            $this->temporaryFileRepository->makeDirectory($temporaryThumbnailPath);

            $this->fileResizeHandler->resize(
                $file,
                $temporaryOriginalPath,
                $temporaryThumbnailPath,
                Dimension::fromArray($dimensionBreakpoint)
            );
        }
    }
}
