<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\FindMedia;


use Zenchron\FileManagerBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileManagerBundle\Application\DataTransformer\Response\MediaResponse;
use Zenchron\FileManagerBundle\Domain\Contract\MediaRepositoryInterface;
use Zenchron\FileManagerBundle\Domain\ValueObject\MediaId;

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
