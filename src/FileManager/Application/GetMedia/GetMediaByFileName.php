<?php
declare(strict_types=1);

namespace App\FileManager\Application\GetMedia;


use App\FileManager\Application\DataTransformer\MediaToResponseTransformer;
use App\FileManager\Application\DataTransformer\Response\MediaResponse;
use App\FileManager\Domain\Contract\MediaRepositoryInterface;

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
