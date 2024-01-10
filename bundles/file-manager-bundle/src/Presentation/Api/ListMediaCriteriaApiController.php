<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Presentation\Api;

use Zenchron\FileBundle\Application\ListMediaCriteria\ListMediaCriteria;
use Zenchron\FileBundle\Domain\Criteria\MediaCriteria;
use Zenchron\SharedBundle\Domain\Exception\ApiProblem\ApiProblemException;
use Zenchron\SharedBundle\Filter\Attributes\Criteria;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/zenchron/dashboard', name: 'zenchron_file_list_criteria', methods: ['GET'], priority: 1)]
class ListMediaCriteriaApiController extends BaseMediaApiController
{

    public function __construct(private readonly ListMediaCriteria $listMedia)
    {
    }

    public function __invoke(Request $request, #[Criteria] MediaCriteria $criteria): JsonResponse
    {
        try {
            return $this->json($this->listMedia->__invoke($criteria));
        } catch (\Throwable $throwable) {
            throw ApiProblemException::fromThrowable($throwable);
        }
    }

}
