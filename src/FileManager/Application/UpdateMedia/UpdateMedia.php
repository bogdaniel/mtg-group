<?php
declare(strict_types=1);

namespace App\FileManager\Application\UpdateMedia;

use App\FileManager\Application\DataTransformer\MediaToResponseTransformer;
use App\FileManager\Application\DataTransformer\Response\MediaResponse;
use App\FileManager\Application\FileManipulation\RenameFile\RenameFile;
use App\FileManager\Domain\Contract\MediaRepositoryInterface;
use App\FileManager\Domain\ValueObject\Description;
use App\FileManager\Domain\ValueObject\MediaId;
use App\Shared\Domain\Event\DomainEventPublisherContract;
use App\Shared\Domain\ValueObject\UserIdentifier;

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
