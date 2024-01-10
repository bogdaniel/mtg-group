<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\GetMedia;


use Zenchron\FileBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileBundle\Application\DataTransformer\Response\MediaResponse;
use Zenchron\FileBundle\Domain\Contract\MediaRepository;

class GetMediaByFileName
{

    public function __construct(
        private readonly MediaRepository $mediaRepository,
        private readonly MediaToResponseTransformer $responseTransformer
    ) {
    }


    public function __invoke(string $fileName): MediaResponse
    {
        $media = $this->mediaRepository->getByFileName($fileName);

        return $this->responseTransformer->mediaToResponse($media);
    }


}
