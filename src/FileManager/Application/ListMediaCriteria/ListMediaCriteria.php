<?php

declare(strict_types=1);

namespace App\FileManager\Application\ListMediaCriteria;


use App\FileManager\Application\DataTransformer\MediaToResponseTransformer;
use App\FileManager\Domain\Contract\MediaRepositoryInterface;
use App\Shared\Filter\Criteria;
use App\Shared\Filter\Pagination\Pagination;

class ListMediaCriteria
{

    public function __construct(
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly MediaToResponseTransformer $responseTransformer
    ) {
    }


    /**
     * @param Criteria $criteria
     * @return Pagination<\App\FileManager\Application\DataTransformer\Response\MediaResponse>
     */
    public function __invoke(Criteria $criteria): Pagination
    {
        $results = $this->mediaRepository->filter($criteria);
        $count   = $this->mediaRepository->size($criteria);


        return new Pagination(
            $this->responseTransformer->mediaCollectionToArrayResponse($results),
            $count,
            $criteria->offsetPagination()
        );
    }


}
