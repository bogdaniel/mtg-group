<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Application\FileManipulation\RenameFile;

use Zenchron\FileBundle\Application\SafeFileName\SafeFileName;
use Zenchron\FileBundle\Application\UpdateMedia\UpdateMediaRequest;
use Zenchron\FileBundle\Domain\Contract\FileRepository;
use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Domain\Event\DomainEventPublisher;
use Zenchron\SharedBundle\Domain\ValueObject\UserIdentifier;

class RenameFile
{
    public function __construct(
        private readonly RenameThumbnails $renameThumbnails,
        private readonly MediaRepository $mediaRepository,
        private readonly FileRepository $fileRepository,
        private readonly SafeFileName $safeFileName,
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
        $oldFileName = $media->file()->name();

        // rename original file
        $this->fileRepository->rename($oldFileName, $newFileName);
        $file = $media->file()->changeName($newFileName, $newFileName);
        $media->changeFile($file, new UserIdentifier($userIdentifier));

        // rename thumbnails file
        $thumbnails = $this->renameThumbnails->__invoke($media->thumbnails(), $newFileName);
        $media->changeThumbnails($thumbnails);

        $this->mediaRepository->save($media);
        $this->domainEventPublisher->publish(...$media->recordedEvents());
    }
}
