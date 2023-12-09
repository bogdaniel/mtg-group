<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\GetMedia;


use Zenchron\FileManagerBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileManagerBundle\Application\DataTransformer\Response\MediaResponse;
use Zenchron\FileManagerBundle\Domain\Contract\MediaRepositoryInterface;

class GetMediaByFileName
{

    public function __construct(
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly MediaToResponseTransformer $responseTransformer
    ) {
    }


    public function __invoke(string $fileName): MediaResponse
    {
        $media = $this->mediaRepository->getByFileName($fileName);

        return $this->responseTransformer->mediaToResponse($media);
    }


}
