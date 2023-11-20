<?php

declare(strict_types=1);

namespace App\Shared\Filter\Visitor;


use App\Shared\Filter\Criteria;
use App\Shared\Filter\ConditionOperator;
use App\Shared\Filter\ConditionFilter;
use App\Shared\Filter\Filter;

class SqlExpressionFilterVisitor extends AbstractFilterVisitor
{

    public function visitConditionFilter(ConditionFilter $filter, Criteria $criteria): ConditionFilter
    {
        $value = match ($filter->operator()) {
            ConditionOperator::EQUALS,
            ConditionOperator::NOT_EQUALS,
            ConditionOperator::GREATER_THAN,
            ConditionOperator::GREATER_THAN_OR_EQUAL,
            ConditionOperator::LESS_THAN,
            ConditionOperator::LESS_THAN_OR_EQUAL,
            ConditionOperator::INCLUDE,
            ConditionOperator::NOT_INCLUDE => \is_string($filter->value()) ? \sprintf(
                '"%s"',
                $filter->value()
            ) : $filter->value(),
            ConditionOperator::LIKE,
            ConditionOperator::NOT_LIKE => \sprintf('"%%%s%%"', \addcslashes($filter->value(), '%_')),
            ConditionOperator::STARTS => \sprintf('"%s%%"', \addcslashes($filter->value(), '%_')),
            ConditionOperator::ENDS => \sprintf('"%%%s"', \addcslashes($filter->value(), '%_')),
        };

        $expression = $filter->expression();
        $expression->setExpression(\sprintf(
            '%s %s %s',
            $filter->field(),
            $filter->operator()->expression(),
            $value,
        ));

        return $filter;
    }


    public function support(Filter $filter, Criteria $criteria): bool
    {
        return true;
    }

    public static function getDefaultPriority(): int
    {
        return 100;
    }

}
