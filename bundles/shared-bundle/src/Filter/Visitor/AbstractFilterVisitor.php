<?php

declare(strict_types=1);


namespace Zenchron\SharedBundle\Filter\Visitor;

use Zenchron\SharedBundle\Filter\CompositeFilter;
use Zenchron\SharedBundle\Filter\ConditionFilter;
use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\Filter;

abstract class AbstractFilterVisitor implements FilterVisitor
{
    abstract public function visitConditionFilter(ConditionFilter $filter, Criteria $criteria): ConditionFilter;
    abstract public function support(Filter $filter, Criteria $criteria): bool;

    public function visitCompositeFilter(CompositeFilter $filter, Criteria $criteria): CompositeFilter
    {
        $listExpressions = \array_map(
            static fn(Filter $filter) => $filter->expression()->getExpression(),
            $filter->filters()
        );
        $filter->expression()->setExpression(
            \sprintf(
                '(%s)',
                \implode(' '.$filter->operator()->expression().' ', $listExpressions)
            )
        );

        return $filter;
    }

    public static function getDefaultPriority(): int
    {
        return 0;
    }
}
