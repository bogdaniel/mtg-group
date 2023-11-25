<?php

declare(strict_types=1);


namespace App\FileManager\Presentation\Twig;

use Doctrine\Common\Collections\Collection;
use App\FileManager\Application\DataTransformer\MediaToResponseTransformer;
use App\FileManager\Application\DataTransformer\Response\MediaResponse;
use App\FileManager\Application\FindMedia\FindMediaByIds;
use App\FileManager\Application\GetMedia\GetMediaById;
use App\FileManager\Domain\Exception\NotFoundMediaException;
use App\FileManager\Domain\Model\Media;

class MediaTwigService
{


    public function __construct(
        private readonly GetMediaById $getMediaById,
        private readonly FindMediaByIds $findMediaByIds,
        private readonly MediaToResponseTransformer $responseTransformer,
    ) {
    }

    public function findById(string $mediaId): ?MediaResponse
    {
        try {
            return $this->getMediaById->__invoke($mediaId);
        } catch (NotFoundMediaException) {
            return null;
        }
    }

    /**
     * @param array<string> $ids
     * @return array<MediaResponse>
     */
    public function findByIds(array $ids): array
    {
        return $this->findMediaByIds->__invoke($ids);
    }

    public function mediaToResponse(Media $media): ?MediaResponse
    {
        return $this->responseTransformer->mediaToResponse($media);
    }

    /**
     * @param Collection<int,Media> $mediaCollection
     * @return array<MediaResponse>
     */
    public function mediaCollectionToArrayResponse(Collection $mediaCollection): array
    {
        return $this->responseTransformer->mediaCollectionToArrayResponse($mediaCollection->toArray());
    }
}
