<?php

declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\FileManipulation\Thumbnails\GenerateThumbnails;

use Zenchron\FileManagerBundle\Domain\Contract\FilePathResolverInterface;
use Zenchron\FileManagerBundle\Domain\Contract\FileRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Contract\FileUrlResolverInterface;
use Zenchron\FileManagerBundle\Domain\Contract\MediaRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Service\FileResizeHandler;
use Zenchron\FileManagerBundle\Domain\ValueObject\Dimension;
use Zenchron\FileManagerBundle\Domain\ValueObject\File;
use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;
use Zenchron\FileManagerBundle\Domain\ValueObject\Thumbnail;
use Zenchron\FileManagerBundle\Domain\ValueObject\Thumbnails;

abstract class AbstractGenerateImageThumbnails
{

    /**
     * @param int|null $originalMaxWidth
     * @param array<string, mixed> $breakpoints
     * @param FileResizeHandler $fileResizeHandler
     * @param MediaRepositoryInterface $mediaRepository
     * @param FileRepositoryInterface $fileRepository
     * @param FilePathResolverInterface $filePathResolver
     * @param FileUrlResolverInterface $fileUrlResolver
     */
    public function __construct(
        protected readonly ?int $originalMaxWidth,
        protected readonly array $breakpoints,
        protected readonly FileResizeHandler $fileResizeHandler,
        protected readonly MediaRepositoryInterface $mediaRepository,
        protected readonly FileRepositoryInterface $fileRepository,
        protected readonly FilePathResolverInterface $filePathResolver,
        protected readonly FileUrlResolverInterface $fileUrlResolver
    ) {
    }

    public function generate(string $mediaId): void
    {
        $media         = $this->mediaRepository->getById(MediaId::fromString($mediaId));
        $file          = $media->file();
        $fileDimension = $media->dimension();

        if(!$this->fileResizeHandler->support($file)) {
             return;
         }
        // resize original if is the case
        if (\is_int($this->originalMaxWidth)) {
            [$file, $fileDimension] = $this->resizeOriginalFile($file, $fileDimension);
            $media->updateFileDimension($file, $fileDimension);
        }

        // generate thumbnails
        $media->addThumbnails($this->makeThumbnails($fileDimension, $file));
        $this->mediaRepository->save($media);
    }

    /**
     * @param \Zenchron\FileManagerBundle\Domain\ValueObject\File $file
     * @param \Zenchron\FileManagerBundle\Domain\ValueObject\Dimension $fileDimension
     *
     * @return array{File, Dimension}
     */
    protected function resizeOriginalFile(File $file, Dimension $fileDimension): array
    {
        if ($fileDimension->width() && $fileDimension->width() > $this->originalMaxWidth) {
            $outputPath = $this->filePathResolver->resolve($file->path());
            if (!$this->fileResizeHandler->resize(
                $file,
                $outputPath,
                $outputPath,
                new Dimension($this->originalMaxWidth)
            )) {
                return [$file, $fileDimension];
            }
            $file          = $file->updateSize($this->fileRepository->filesizeFromPath($outputPath));
            $fileDimension = $this->fileRepository->dimensionsFromPath($outputPath);
        }

        return [$file, $fileDimension];
    }


    protected function makeThumbnails(Dimension $fileDimension, File $file): Thumbnails
    {
        $filePath   = $this->filePathResolver->resolve($file->path());
        $thumbnails = new Thumbnails();
        foreach ($this->breakpoints as $nameBreakpoint => $dimensionBreakpoint) {
            if ($dimensionBreakpoint[0] && $dimensionBreakpoint[0] > $fileDimension->width()) {
                continue;
            }

            $outputPath = $this->filePathResolver->resolveFromBreakpoint($nameBreakpoint, $file->path());
            $this->fileRepository->makeDirectory($outputPath);

            if (!$this->fileResizeHandler->resize(
                $file,
                $filePath,
                $outputPath,
                Dimension::fromArray($dimensionBreakpoint)
            )){
                continue;
            }

            $thumbnailUrlPath = $this->fileUrlResolver->resolvePathFromBreakpoint($nameBreakpoint, $file->path());
            $thumbnails->add(
                new Thumbnail(
                    $nameBreakpoint,
                    $file->name(),
                    $thumbnailUrlPath,
                    $this->fileRepository->filesizeFromPath($outputPath),
                    $this->fileRepository->dimensionsFromPath($outputPath, $file->mime())
                )
            );
        }

        return $thumbnails;
    }
}
