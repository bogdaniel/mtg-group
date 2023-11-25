<?php
declare(strict_types=1);

namespace App\FileManager\Application\GetMedia;


use App\FileManager\Application\DataTransformer\MediaToResponseTransformer;
use App\FileManager\Application\DataTransformer\Response\MediaResponse;
use App\FileManager\Domain\Contract\MediaRepositoryInterface;
use App\FileManager\Domain\ValueObject\MediaId;

class GetMediaById
{

    public function __construct(
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly MediaToResponseTransformer $responseTransformer
    ) {
    }


    public function __invoke(string $mediaId): MediaResponse
    {
        $media = $this->mediaRepository->getById(MediaId::fromString($mediaId));

        return $this->responseTransformer->mediaToResponse($media);
    }


}
