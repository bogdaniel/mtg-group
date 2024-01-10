<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\UpdateMedia;

use Zenchron\FileBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileBundle\Application\DataTransformer\Response\MediaResponse;
use Zenchron\FileBundle\Application\FileManipulation\RenameFile\RenameFile;
use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\FileBundle\Domain\ValueObject\Description;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;
use Zenchron\SharedBundle\Domain\Event\DomainEventPublisher;
use Zenchron\SharedBundle\Domain\ValueObject\UserIdentifier;

class UpdateMedia
{

    public function __construct(
        private readonly MediaRepository $mediaRepository,
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

        $media->changeDescription($description, $userIdentifierVO);
        $this->mediaRepository->save($media);
        $this->domainEventPublisher->publish(...$media->recordedEvents());

        return $this->responseTransformer->mediaToResponse($media);
    }


}
