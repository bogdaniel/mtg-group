<?php

declare(strict_types=1);

namespace Zenchron\SharedBundle\Filter\Visitor;

use Doctrine\ORM\QueryBuilder;
use Zenchron\SharedBundle\Filter\CompositeFilter;
use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\ConditionFilter;
use Zenchron\SharedBundle\Filter\Filter;


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
