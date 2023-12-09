<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\FileManipulation\RenameFile;


use Zenchron\FileManagerBundle\Application\FileManipulation\Thumbnails\RenameThumbnails\RenameThumbnails;
use Zenchron\FileManagerBundle\Application\SafeFileName\SafeFileName;
use Zenchron\FileManagerBundle\Application\UpdateMedia\UpdateMediaRequest;
use Zenchron\FileManagerBundle\Domain\Contract\FilePathResolverInterface;
use Zenchron\FileManagerBundle\Domain\Contract\FileRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Contract\MediaRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Domain\Event\DomainEventPublisher;
use Zenchron\SharedBundle\Domain\ValueObject\UserIdentifier;

class RenameFile
{
    public function __construct(
        private readonly RenameThumbnails $renameThumbnails,
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly FileRepositoryInterface $fileRepository,
        private readonly SafeFileName $safeFileName,
        private readonly FilePathResolverInterface $filePathResolver,
        private readonly DomainEventPublisher $domainEventPublisher
    ) {
    }


    public function __invoke(UpdateMediaRequest $updateMediaRequest, ?string $userIdentifier): void
    {
        $media = $this->mediaRepository->getById(MediaId::fromString($updateMediaRequest->id()));

        if ($updateMediaRequest->name() === \pathinfo($media->file()->name(), \PATHINFO_FILENAME)) {
            return;
        }

        // get safe file name
        $newFileName = $this->safeFileName->__invoke($updateMediaRequest->name(), $media->file()->extension());
        $oldPath     = $this->filePathResolver->resolve($media->file()->path());
        $newPath     = $this->filePathResolver->resolve($newFileName);

        // rename original file
        $this->fileRepository->rename($oldPath, $newPath);
        // TODO: support new directory in path
        $file = $media->file()->update($newFileName, $newFileName);
        $media->updateFile($file, new UserIdentifier($userIdentifier));

        // rename thumbnails file
        $thumbnails = $this->renameThumbnails->__invoke($media->thumbnails(), $newFileName);
        $media->addThumbnails($thumbnails);

        $this->mediaRepository->save($media);
        $this->domainEventPublisher->publish(...$media->recordedEvents());
    }
}
