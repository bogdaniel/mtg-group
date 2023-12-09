<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\GetMedia;


use Zenchron\FileManagerBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileManagerBundle\Application\DataTransformer\Response\MediaResponse;
use Zenchron\FileManagerBundle\Domain\Contract\MediaRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;

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
