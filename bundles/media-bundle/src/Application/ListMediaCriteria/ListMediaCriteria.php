<?php

declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Application\ListMediaCriteria;


use Zenchron\FileManagerBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileManagerBundle\Domain\Contract\MediaRepositoryInterface;
use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\Pagination\Pagination;

class ListMediaCriteria
{

    public function __construct(
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly MediaToResponseTransformer $responseTransformer
    ) {
    }


    /**
     * @param Criteria $criteria
     * @return Pagination<\Zenchron\FileManagerBundle\Application\DataTransformer\Response\MediaResponse>
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
