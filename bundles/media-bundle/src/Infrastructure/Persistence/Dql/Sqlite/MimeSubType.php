<?php
declare(strict_types=1);

namespace Zenchron\FileManagerBundle\Infrastructure\Persistence\Dql\Sqlite;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;


class MimeSubType extends FunctionNode
{
    public Node|string|null $field = null;

    /**
     * @throws \Doctrine\ORM\Query\QueryException
     */
    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->field = $parser->ArithmeticPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }


    /**
     * @throws \Doctrine\ORM\Query\AST\ASTException
     */
    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf(
            'SUBSTR(%1$s, INSTR(%1$s, "/") + 1, LENGTH(%1$s))',
            $this->field->dispatch($sqlWalker)
        );
    }

}
