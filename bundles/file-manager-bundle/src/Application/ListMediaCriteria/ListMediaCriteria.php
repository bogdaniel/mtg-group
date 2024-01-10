<?php

declare(strict_types=1);

namespace Zenchron\FileBundle\Application\ListMediaCriteria;


use Zenchron\FileBundle\Application\DataTransformer\MediaToResponseTransformer;
use Zenchron\FileBundle\Domain\Contract\MediaRepository;
use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\Pagination\Pagination;

class ListMediaCriteria
{

    public function __construct(
        private readonly MediaRepository $mediaRepository,
        private readonly MediaToResponseTransformer $responseTransformer
    ) {
    }


    /**
     * @param Criteria $criteria
     * @return Pagination<\Ranky\FileBundle\Application\DataTransformer\Response\MediaResponse>
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
