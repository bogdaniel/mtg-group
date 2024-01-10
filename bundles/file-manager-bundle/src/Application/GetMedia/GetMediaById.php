<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\GetMedia;


use Zenchron\FileBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileBundle\Application\DataTransformer\Response\MediaResponse;
use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;

class GetMediaById
{

    public function __construct(
        private readonly MediaRepository $mediaRepository,
        private readonly MediaToResponseTransformer $responseTransformer
    ) {
    }


    public function __invoke(string $mediaId): MediaResponse
    {
        $media = $this->mediaRepository->getById(MediaId::fromString($mediaId));

        return $this->responseTransformer->mediaToResponse($media);
    }


}
