<?php

declare(strict_types=1);

namespace Zenchron\SharedBundle\Filter\Visitor;

use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\ConditionOperator;
use Zenchron\SharedBundle\Filter\ConditionFilter;
use Zenchron\SharedBundle\Filter\Filter;

class DoctrineExpressionFilterVisitor extends AbstractFilterVisitor
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
            ConditionOperator::NOT_INCLUDE => $filter->value(),
            ConditionOperator::LIKE,
            ConditionOperator::NOT_LIKE => \sprintf('%%%s%%', \addcslashes($filter->value(), '%_')),
            ConditionOperator::STARTS => \sprintf('%s%%', \addcslashes($filter->value(), '%_')),
            ConditionOperator::ENDS => \sprintf('%%%s', \addcslashes($filter->value(), '%_')),
        };

        $keyParameter = $filter->fieldToKeyParameter();
        $customParameter = null;
        if ($filter->operator() === ConditionOperator::INCLUDE ||
            $filter->operator() === ConditionOperator::NOT_INCLUDE) {
            $customParameter = \sprintf('(%s)', $keyParameter);
        }

        $filter->expression()->setParameters([$keyParameter => $value]);
        $filter->expression()->setExpression(
            \sprintf(
                '%s %s %s',
                $filter->field(),
                $filter->operator()->expression(),
                $customParameter ?? $keyParameter
            )
        );

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
