<?php
declare(strict_types=1);

namespace App\FileManager\Application\FindMedia;


use App\FileManager\Application\DataTransformer\MediaToResponseTransformer;
use App\FileManager\Application\DataTransformer\Response\MediaResponse;
use App\FileManager\Domain\Contract\MediaRepositoryInterface;
use App\FileManager\Domain\ValueObject\MediaId;

class FindMediaByIds
{

    public function __construct(
        private readonly MediaRepositoryInterface $mediaRepository,
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
