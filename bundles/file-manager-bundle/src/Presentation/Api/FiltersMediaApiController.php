<?php
declare(strict_types=1);

namespace Zenchron\FileBundle\Presentation\Api;

use Zenchron\FileBundle\Application\ListFilter\ListFilter;
use Zenchron\SharedBundle\Domain\Exception\ApiProblem\ApiProblemException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/zenchron/dashboard/filters', name: 'zenchron_file_filters', methods: ['GET'], priority: 2)]
class FiltersMediaApiController extends BaseMediaApiController
{

    public function __construct(
        private readonly ListFilter $listFilter
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            return $this->json($this->listFilter->__invoke());
        } catch (\Throwable $throwable) {
            throw ApiProblemException::fromThrowable($throwable);
        }
    }

}
