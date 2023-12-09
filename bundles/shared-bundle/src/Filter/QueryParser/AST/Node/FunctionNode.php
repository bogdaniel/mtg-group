<?php

declare(strict_types=1);


namespace Zenchron\SharedBundle\Filter\QueryParser\AST\Node;


use Zenchron\SharedBundle\Filter\QueryParser\AST\NodeGrammar;
use Zenchron\SharedBundle\Filter\QueryParser\AST\Visitor\VisitorNode;

/**
 * @property array{name: \Zenchron\SharedBundle\Filter\ConditionOperator, field: string, value: mixed} $attributes
 */
class FunctionNode extends Node
{
    /**
     * @param VisitorNode $visitorNode
     * @param \ArrayIterator<int, Node> $nodes
     * @return void
     */
    public function accept(VisitorNode $visitorNode, \ArrayIterator $nodes): void
    {
        $visitorNode->visitFunction($this, $nodes);
    }

    public function getType(): string
    {
        return NodeGrammar::FUNCTION->name;
    }
}
