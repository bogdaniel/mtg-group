<?php

declare(strict_types=1);


namespace App\Shared\Filter\CriteriaBuilder;

use Doctrine\ORM\QueryBuilder;
use App\Shared\Filter\Criteria;
use App\Shared\Filter\Driver;
use App\Shared\Filter\Visitor\VisitorCollection;

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
