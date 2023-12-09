<?php

declare(strict_types=1);

namespace Zenchron\SharedBundle\Filter\QueryParser\Output;

use Zenchron\SharedBundle\Filter\QueryParser\AST\Visitor\VisitorNode;

interface OutputVisitor extends VisitorNode
{
    public function getOutput(): mixed;
}
