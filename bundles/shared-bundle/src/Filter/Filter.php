<?php
declare(strict_types=1);

namespace Zenchron\SharedBundle\Filter;

use Zenchron\SharedBundle\Filter\Visitor\FilterVisitor;

interface Filter
{
    public function operator(): ConditionOperator|CompositeOperator;
    public function accept(FilterVisitor $filterVisitor, Criteria $criteria): void;
    public function setExpression(Expression $expression): void;
    public function expression(): Expression;
}
