<?php

declare(strict_types=1);

namespace App\Shared\Filter\Visitor;

use App\Shared\Filter\CompositeFilter;
use App\Shared\Filter\Criteria;
use App\Shared\Filter\ConditionFilter;
use App\Shared\Filter\Filter;

class CriteriaFilterVisitor implements FilterVisitor
{

    public function visitConditionFilter(ConditionFilter $filter, Criteria $criteria): ConditionFilter
    {
        $field = $criteria::normalizeField($filter->field());
        // TODO: Normalize value with or without prefixing. Currently without prefixing
        $value = $criteria::normalizeValue($filter->field(), $filter->value());

        $filter->setValue($value);
        $filter->setField($field);

        return $filter;
    }

    public function visitCompositeFilter(CompositeFilter $filter, Criteria $criteria): CompositeFilter
    {
        return $filter;
    }

    public function support(Filter $filter, Criteria $criteria): bool
    {
        return true;
    }
}
