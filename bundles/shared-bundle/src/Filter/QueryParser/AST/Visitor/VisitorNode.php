<?php

declare(strict_types=1);

namespace Zenchron\SharedBundle\Filter\QueryParser\AST\Visitor;


use Zenchron\SharedBundle\Filter\QueryParser\AST\Node\CompositeOperatorNode;
use Zenchron\SharedBundle\Filter\QueryParser\AST\Node\FunctionNode;
use Zenchron\SharedBundle\Filter\QueryParser\AST\Node\Node;
use Zenchron\SharedBundle\Filter\QueryParser\AST\Node\WhereCloseGroupNode;
use Zenchron\SharedBundle\Filter\QueryParser\AST\Node\WhereOpenGroupNode;

interface VisitorNode
{
    /**
     * @param WhereOpenGroupNode $node
     * @param \ArrayIterator<int,Node> $nodes
     * @return Node|null
     */
    public function visitWhereOpenGroup(WhereOpenGroupNode $node, \ArrayIterator $nodes): ?Node;

    /**
     * @param WhereCloseGroupNode $node
     * @param \ArrayIterator<int,Node> $nodes
     * @return Node|null
     */
    public function visitWhereCloseGroup(WhereCloseGroupNode $node, \ArrayIterator $nodes): ?Node;

    /**
     * @param FunctionNode $node
     * @param \ArrayIterator<int,Node> $nodes
     * @return Node|null
     */
    public function visitFunction(FunctionNode $node, \ArrayIterator $nodes): ?Node;
    /**
     * @param CompositeOperatorNode $node
     * @param \ArrayIterator<int,Node> $nodes
     * @return Node|null
     */
    public function visitCompositeOperator(CompositeOperatorNode $node, \ArrayIterator $nodes): ?Node;

}
