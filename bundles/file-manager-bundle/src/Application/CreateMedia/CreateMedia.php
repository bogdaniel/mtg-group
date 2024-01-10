<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Application\CreateMedia;

use Zenchron\FileBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileBundle\Application\DataTransformer\Response\MediaResponse;
use Zenchron\FileBundle\Application\SafeFileName\SafeFileName;
use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\FileBundle\Domain\Contract\TemporaryFileRepository;
use Zenchron\FileBundle\Domain\Model\Media;
use Zenchron\FileBundle\Domain\ValueObject\Description;
use Zenchron\FileBundle\Domain\ValueObject\File;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Common\FileHelper;
use Zenchron\SharedBundle\Domain\Event\DomainEventPublisher;
use Zenchron\SharedBundle\Domain\ValueObject\UserIdentifier;

class CreateMedia
{
    public function __construct(
        private readonly SafeFileName $safeFileName,
        private readonly MediaRepository $mediaRepository,
        private readonly TemporaryFileRepository $temporaryFileRepository,
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
        $fileName         = $this->safeFileName->__invoke(
            $uploadedFileRequest->name(),
            $uploadedFileRequest->extension()
        );
        $file             = new File(
            $fileName,
            $fileName,
            $uploadedFileRequest->mime(),
            $uploadedFileRequest->extension(),
            $uploadedFileRequest->size()
        );

        $dimension   = $this->temporaryFileRepository->dimension($uploadedFileRequest->path(), $file->mime());
        $description = new Description(FileHelper::humanTitleFromFileName($file->name()));
        // prepare temporary file for processing
        $temporaryFile = $this->temporaryFileRepository->temporaryFile($file->path());
        $this->temporaryFileRepository->copy($uploadedFileRequest->path(), $temporaryFile);
        // create and save media
        $media = Media::create(
            $id,
            $file,
            $userIdentifierVO,
            $dimension,
            $description
        );
        $this->mediaRepository->save($media);

        // publish domain events
        $this->domainEventPublisher->publish(...$media->recordedEvents());

        return $this->responseTransformer->mediaToResponse($media);
    }
}
