<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Application\FindMedia;


use Zenchron\FileBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileBundle\Application\DataTransformer\Response\MediaResponse;
use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\FileBundle\Domain\ValueObject\MediaId;

class FindMediaByIds
{

    public function __construct(
        private readonly MediaRepository $mediaRepository,
        private readonly MediaToResponseTransformer $responseTransformer,
    ) {
    }

    /**
     * @param array<string> $ids
     * @return array<MediaResponse>
     */
    public function __invoke(array $ids): array
    {
        $mediaIds = array_map(static fn(string $id) => MediaId::fromString($id), $ids);
        $results        = $this->mediaRepository->findByIds(
            ...$mediaIds
        );

        return $this->responseTransformer->mediaCollectionToArrayResponse($results);
    }


}
