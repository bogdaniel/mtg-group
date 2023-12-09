<?php

declare(strict_types=1);


namespace Zenchron\SharedBundle\Filter\Visitor\Extension;

use Zenchron\SharedBundle\Filter\ConditionFilter;
use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\Filter;
use Zenchron\SharedBundle\Filter\Visitor\AbstractFilterVisitor;

class FilterExtensionVisitorFacade extends AbstractFilterVisitor
{


    public function __construct(private readonly FilterExtensionVisitor $filterExtensionVisitor)
    {
    }

    public function visitConditionFilter(ConditionFilter $filter, Criteria $criteria): ConditionFilter
    {
        return $this->filterExtensionVisitor->visit($filter, $criteria);
    }

    public function support(Filter $filter, Criteria $criteria): bool
    {
        return $filter instanceof ConditionFilter &&
            $this->filterExtensionVisitor->support($filter, $criteria);
    }

}
