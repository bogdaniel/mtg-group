<?php

declare(strict_types=1);


namespace Zenchron\FileBundle\Presentation\Twig;

use Doctrine\Common\Collections\Collection;
use Zenchron\FileBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileBundle\Application\DataTransformer\Response\MediaResponse;
use Zenchron\FileBundle\Application\FindMedia\FindMediaByIds;
use Zenchron\FileBundle\Application\GetMedia\GetMediaById;
use Zenchron\FileBundle\Domain\Exception\NotFoundMediaException;
use Zenchron\FileBundle\Domain\Model\Media;

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
