<?php

declare(strict_types=1);


namespace App\Shared\Filter\QueryParser\Output;

use Doctrine\ORM\QueryBuilder;
use App\Shared\Filter\Criteria;
use App\Shared\Filter\FilterFactory;
use App\Shared\Filter\QueryParser\AST\Node\CompositeOperatorNode;
use App\Shared\Filter\QueryParser\AST\Node\FunctionNode;
use App\Shared\Filter\QueryParser\AST\Node\Node;
use App\Shared\Filter\QueryParser\AST\Node\WhereCloseGroupNode;
use App\Shared\Filter\QueryParser\AST\Node\WhereOpenGroupNode;
use App\Shared\Filter\Visitor\CriteriaFilterVisitor;
use App\Shared\Filter\Visitor\DoctrineExpressionFilterVisitor;

class DoctrineORMOutputVisitor implements OutputVisitor
{

    private QueryBuilder $queryBuilder;
    private Criteria $criteria;
    private string $queryString = '';

    public function __construct(Criteria $criteria, QueryBuilder $queryBuilder)
    {
        $this->criteria = $criteria;
        $this->queryBuilder  = $queryBuilder;
    }

    public function getOutput(): QueryBuilder
    {
        $this
            ->queryBuilder
            ->andWhere(\trim(\preg_replace(
                ['/\s+/', '/\(\s+/', '/\s+\)/'],
                [' ', '(', ')'],
                $this->queryString
            ) ?? ''));

        return $this->queryBuilder;
    }

    public function visitWhereOpenGroup(WhereOpenGroupNode $node, \ArrayIterator $nodes): ?Node
    {
        $this->queryString .= '(';

        return $node;
    }

    public function visitWhereCloseGroup(WhereCloseGroupNode $node, \ArrayIterator $nodes): ?Node
    {
        $this->queryString .= ')';

        return $node;
    }

    public function visitFunction(FunctionNode $node, \ArrayIterator $nodes): ?Node
    {
        /** @var \App\Shared\Filter\ConditionOperator $functionName */
        $functionName = $node->getAttribute('name');
        $field        = $node->getAttribute('field');
        $value        = $node->getAttribute('value');

        $filter = FilterFactory::create($field, $functionName, $value);
        $criteriaFilterVisitor = new CriteriaFilterVisitor();
        $doctrineCriteriaFilterVisitor = new DoctrineExpressionFilterVisitor();
        $filter->accept($criteriaFilterVisitor, $this->criteria);
        $filter->accept($doctrineCriteriaFilterVisitor, $this->criteria);
        foreach ($filter->expression()->getParameters() as $key => $value){
            $this->queryBuilder->setParameter($key, $value);
        }
        $this->queryString .= \sprintf(
            ' %s ',
            $filter->expression()->getExpression(),
        );

        return $node;
    }

    public function visitCompositeOperator(CompositeOperatorNode $node, \ArrayIterator $nodes): ?Node
    {
        /** @var \App\Shared\Filter\CompositeOperator $operator */
        $operator          = $node->getAttribute('operator');
        $this->queryString .= sprintf(' %s ', $operator->expression());

        return $node;
    }
}
