<?php

declare(strict_types=1);

namespace App\FileManager\Application\CreateMedia;

use App\FileManager\Application\DataTransformer\MediaToResponseTransformer;
use App\FileManager\Application\DataTransformer\Response\MediaResponse;
use App\FileManager\Domain\Contract\FilePathResolverInterface;
use App\FileManager\Domain\Contract\FileRepositoryInterface;
use App\FileManager\Domain\Contract\MediaRepositoryInterface;
use App\FileManager\Domain\Model\Media;
use App\FileManager\Domain\ValueObject\Description;
use App\FileManager\Domain\ValueObject\MediaId;
use App\Shared\Common\FileHelper;
use App\Shared\Domain\Event\DomainEventPublisherContract;
use App\Shared\Domain\ValueObject\UserIdentifier;

class CreateMedia
{

    public function __construct(
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly FileRepositoryInterface $fileRepository,
        private readonly FilePathResolverInterface $filePathResolver,
        private readonly DomainEventPublisher $domainEventPublisher,
        private readonly MediaToResponseTransformer $responseTransformer
    ) {
    }

    public function __invoke(
        UploadedFileRequest $uploadedFileRequest,
        ?string $userIdentifier = null,
        ?string $mediaId = null
    ): MediaResponse {
        // value objects
        $id               = $mediaId ? MediaId::fromString($mediaId) : $this->mediaRepository->nextIdentity();
        $userIdentifierVO = new UserIdentifier($userIdentifier);
        // upload file
        $file = $this->fileRepository->upload($uploadedFileRequest);
        // create and save media
        $media = Media::create(
            $id,
            $file,
            $userIdentifierVO,
            $this->fileRepository->dimensionsFromPath(
                $this->filePathResolver->resolve($file->path()),
                $file->mime()
            ),
            new Description(FileHelper::humanTitleFromFileName($file->name()))
        );
        $this->mediaRepository->save($media);
        // publish domain events
        $this->domainEventPublisher->publish(...$media->recordedEvents());

        return $this->responseTransformer->mediaToResponse($media);
    }


}
