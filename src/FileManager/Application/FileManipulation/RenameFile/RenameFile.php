<?php
declare(strict_types=1);

namespace App\FileManager\Application\FileManipulation\RenameFile;


use App\FileManager\Application\FileManipulation\Thumbnails\RenameThumbnails\RenameThumbnails;
use App\FileManager\Application\SafeFileName\SafeFileName;
use App\FileManager\Application\UpdateMedia\UpdateMediaRequest;
use App\FileManager\Domain\Contract\FilePathResolverInterface;
use App\FileManager\Domain\Contract\FileRepositoryInterface;
use App\FileManager\Domain\Contract\MediaRepositoryInterface;
use App\FileManager\Domain\ValueObject\MediaId;
use App\Shared\Domain\Event\DomainEventPublisherContract;
use App\Shared\Domain\ValueObject\UserIdentifier;

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
