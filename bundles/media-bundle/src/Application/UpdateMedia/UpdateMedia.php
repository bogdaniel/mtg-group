<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\UpdateMedia;

use Zenchron\FileManagerBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileManagerBundle\Application\DataTransformer\Response\MediaResponse;
use Zenchron\FileManagerBundle\Application\FileManipulation\RenameFile\RenameFile;
use Zenchron\FileManagerBundle\Domain\Contract\MediaRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\ValueObject\Description;
use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Domain\Event\DomainEventPublisher;
use Zenchron\SharedBundle\Domain\ValueObject\UserIdentifier;

class UpdateMedia
{

    public function __construct(
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly MediaToResponseTransformer $responseTransformer,
        private readonly RenameFile $renameFile,
        private readonly DomainEventPublisher $domainEventPublisher
    ) {
    }


    public function __invoke(UpdateMediaRequest $updateMediaRequest, ?string $userIdentifier): MediaResponse
    {
        $this->renameFile->__invoke($updateMediaRequest, $userIdentifier);

        $media            = $this->mediaRepository->getById(MediaId::fromString($updateMediaRequest->id()));
        $userIdentifierVO = new UserIdentifier($userIdentifier);
        $description      = new Description($updateMediaRequest->alt(), $updateMediaRequest->title());

        $media->updateDescription($description, $userIdentifierVO);
        $this->mediaRepository->save($media);
        $this->domainEventPublisher->publish(...$media->recordedEvents());

        return $this->responseTransformer->mediaToResponse($media);
    }


}
