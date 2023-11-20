<?php

declare(strict_types=1);

namespace App\Shared\Filter\QueryParser\AST\Visitor;


use App\Shared\Filter\QueryParser\AST\Node\Node;

interface VisitableNode
{
    /**
     * @param VisitorNode $visitorNode
     * @param \ArrayIterator<int, Node> $nodes
     * @return void
     */
    public function accept(VisitorNode $visitorNode, \ArrayIterator $nodes): void;
}
