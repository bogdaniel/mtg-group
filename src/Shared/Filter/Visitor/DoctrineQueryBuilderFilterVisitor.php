<?php

declare(strict_types=1);

namespace App\Shared\Filter\Visitor;

use Doctrine\ORM\QueryBuilder;
use App\Shared\Filter\CompositeFilter;
use App\Shared\Filter\Criteria;
use App\Shared\Filter\ConditionFilter;
use App\Shared\Filter\Filter;


class DoctrineQueryBuilderFilterVisitor implements FilterVisitor
{

    private QueryBuilder $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function visitConditionFilter(ConditionFilter $filter, Criteria $criteria): ConditionFilter
    {
        $filter->accept(new DoctrineExpressionFilterVisitor(), $criteria);
        $this->queryBuilder->andWhere($filter->expression()->getExpression());
        foreach ($filter->expression()->getParameters() as $key => $value){
            $this->queryBuilder->setParameter($key, $value);
        }

        return $filter;
    }

    public function visitCompositeFilter(CompositeFilter $filter, Criteria $criteria): CompositeFilter
    {
        $filter->accept(new DoctrineExpressionFilterVisitor(), $criteria);

        return $filter;
    }

    public function support(Filter $filter, Criteria $criteria): bool
    {
        return true;
    }
}
