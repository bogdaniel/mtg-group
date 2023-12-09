<?php

declare(strict_types=1);


namespace Zenchron\SharedBundle\Filter\QueryParser\Output;

use Zenchron\SharedBundle\Filter\Criteria;
use Zenchron\SharedBundle\Filter\FilterFactory;
use Zenchron\SharedBundle\Filter\QueryParser\AST\Node\CompositeOperatorNode;
use Zenchron\SharedBundle\Filter\QueryParser\AST\Node\FunctionNode;
use Zenchron\SharedBundle\Filter\QueryParser\AST\Node\Node;
use Zenchron\SharedBundle\Filter\QueryParser\AST\Node\WhereCloseGroupNode;
use Zenchron\SharedBundle\Filter\QueryParser\AST\Node\WhereOpenGroupNode;
use Zenchron\SharedBundle\Filter\Visitor\CriteriaFilterVisitor;
use Zenchron\SharedBundle\Filter\Visitor\SqlExpressionFilterVisitor;

class SQLOutputVisitor implements OutputVisitor
{

    private string $queryString = '';
    private Criteria $criteria;

    public function __construct(Criteria $criteria)
    {
        $this->criteria = $criteria;
    }

    public function getOutput(): string
    {
        return \trim(\preg_replace(
            ['/\s+/', '/\(\s+/', '/\s+\)/'],
            [' ', '(', ')'],
            $this->queryString
        ) ?? '');
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
        /** @var \Zenchron\SharedBundle\Filter\ConditionOperator $functionName */
        $functionName = $node->getAttribute('name');
        $field        = $node->getAttribute('field');
        $value        = $node->getAttribute('value');

        $filter = FilterFactory::create($field, $functionName, $value);
        $criteriaFilterVisitor = new CriteriaFilterVisitor();
        $qlCriteriaFilterVisitor = new SqlExpressionFilterVisitor();
        $filter->accept($criteriaFilterVisitor, $this->criteria);
        $filter->accept($qlCriteriaFilterVisitor, $this->criteria);

        $this->queryString .= \sprintf(
            ' %s ',
            $filter->expression(),
        );

        return $node;
    }

    public function visitCompositeOperator(CompositeOperatorNode $node, \ArrayIterator $nodes): ?Node
    {
        /** @var \Zenchron\SharedBundle\Filter\CompositeOperator $operator */
        $operator          = $node->getAttribute('operator');
        $this->queryString .= sprintf(' %s ', $operator->expression());

        return $node;
    }
}
