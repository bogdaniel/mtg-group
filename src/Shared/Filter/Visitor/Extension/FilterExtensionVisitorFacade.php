<?php

declare(strict_types=1);


namespace App\Shared\Filter\Visitor\Extension;

use App\Shared\Filter\ConditionFilter;
use App\Shared\Filter\Criteria;
use App\Shared\Filter\Filter;
use App\Shared\Filter\Visitor\AbstractFilterVisitor;

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
