<?php

declare(strict_types=1);

namespace Zenchron\SharedBundle\Filter\Attributes;

use Zenchron\SharedBundle\Domain\Exception\ApiProblem\ApiProblemException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\InvalidMetadataException;

class CriteriaValueResolver implements ArgumentValueResolverInterface
{
    public function __construct(private readonly ?int $paginationLimit = null)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (!$argument->getAttributes() || null === $argument->getType()) {
            return false;
        }

        return $argument->getAttributes()[0] instanceof Criteria
            && \is_a(
                $argument->getType(),
                \Zenchron\SharedBundle\Filter\Criteria::class,
                true
            );
    }


    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument
     * @return iterable<\Zenchron\SharedBundle\Filter\Criteria>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $pagination = $request->query->all('page');
        /** @var array<Criteria> $criteriaAttributes */
        $criteriaAttributes = $argument->getAttributes();
        if (isset($pagination['limit'])) {
            $pagination['limit'] = (int)$pagination['limit'];
        } elseif (isset($criteriaAttributes[0]) && $criteriaAttributes[0]->getPaginationLimit()) {
            $pagination['limit'] = $criteriaAttributes[0]->getPaginationLimit();
        } elseif ($this->paginationLimit) {
            $pagination['limit'] = $this->paginationLimit;
        }

        if (isset($pagination['disable'])) {
            $pagination['disable'] = (bool)$pagination['disable'];
        }

        try {
            /* @var \Zenchron\SharedBundle\Filter\Criteria $criteria */
            if (!$criteria = $argument->getType()) {
                throw new InvalidMetadataException(
                    'The argument type not found in the CriteriaValueResolver class'
                );
            }
            yield $criteria::fromRequest(
                $request->query->all('filters'),
                $pagination,
                $request->query->all('sort')
            );
        } catch (\Throwable $throwable) {
            throw ApiProblemException::fromThrowable($throwable);
        }
    }
}
