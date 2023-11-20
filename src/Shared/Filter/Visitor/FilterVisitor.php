<?php
declare(strict_types=1);

namespace App\Shared\Filter\Visitor;

use App\Shared\Filter\CompositeFilter;
use App\Shared\Filter\Criteria;
use App\Shared\Filter\ConditionFilter;
use App\Shared\Filter\Filter;

interface FilterVisitor
{
    public const TAG_NAME = 'ranky.filter_visitor';
    public function visitConditionFilter(ConditionFilter $filter, Criteria $criteria): ConditionFilter;
    public function visitCompositeFilter(CompositeFilter $filter, Criteria $criteria): CompositeFilter;

    public function support(Filter $filter, Criteria $criteria): bool;
}
