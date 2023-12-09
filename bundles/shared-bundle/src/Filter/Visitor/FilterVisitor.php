<?php
declare(strict_types=1);

namespace Zenchron\SharedBundle\Filter\Visitor;

use Zenchron\SharedBundle\Filter\CompositeFilter;
use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\ConditionFilter;
use Zenchron\SharedBundle\Filter\Filter;

interface FilterVisitor
{
    public const TAG_NAME = 'zenchron.filter_visitor';
    public function visitConditionFilter(ConditionFilter $filter, Criteria $criteria): ConditionFilter;
    public function visitCompositeFilter(CompositeFilter $filter, Criteria $criteria): CompositeFilter;

    public function support(Filter $filter, Criteria $criteria): bool;
}
