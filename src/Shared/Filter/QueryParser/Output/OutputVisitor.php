<?php

declare(strict_types=1);

namespace App\Shared\Filter\QueryParser\Output;

use App\Shared\Filter\QueryParser\AST\Visitor\VisitorNode;

interface OutputVisitor extends VisitorNode
{
    public function getOutput(): mixed;
}
