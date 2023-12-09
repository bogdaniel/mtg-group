<?php

declare(strict_types=1);


namespace Zenchron\SharedBundle\Filter\CriteriaBuilder;

use Doctrine\ORM\QueryBuilder;
use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\Driver;
use Zenchron\SharedBundle\Filter\Visitor\VisitorCollection;

class DoctrineCriteriaBuilderFactory
{

    public function __construct(private readonly VisitorCollection $visitorCollection)
    {
    }

    public function create(QueryBuilder $queryBuilder, Criteria $criteria): DoctrineCriteriaBuilder
    {
        return new DoctrineCriteriaBuilder(
            $queryBuilder,
            $criteria,
            $this->visitorCollection->getVisitorsByDriver(Driver::DOCTRINE_ORM->value)
        );

    }
}
