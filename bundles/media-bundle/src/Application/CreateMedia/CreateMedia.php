<?php

declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\CreateMedia;

use Zenchron\FileManagerBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileManagerBundle\Application\DataTransformer\Response\MediaResponse;
use Zenchron\FileManagerBundle\Domain\Contract\FilePathResolverInterface;
use Zenchron\FileManagerBundle\Domain\Contract\FileRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Contract\MediaRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\Model\Media;
use Zenchron\FileManagerBundle\Domain\ValueObject\Description;
use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Common\FileHelper;
use Zenchron\SharedBundle\Domain\Event\DomainEventPublisher;
use Zenchron\SharedBundle\Domain\ValueObject\UserIdentifier;

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
