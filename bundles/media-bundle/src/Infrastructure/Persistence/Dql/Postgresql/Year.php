<?php

declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Infrastructure\Persistence\Dql\Postgresql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;


class Year extends FunctionNode
{
    public Node|string|null $date = null;

    public function getSql(SqlWalker $sqlWalker): string
    {
        return \sprintf(
            'EXTRACT(YEAR FROM %s)',
            $sqlWalker->walkArithmeticPrimary($this->date)
        );
    }

    /**
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->date = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
