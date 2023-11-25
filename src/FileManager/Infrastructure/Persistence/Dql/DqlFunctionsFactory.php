<?php

declare(strict_types=1);

namespace App\FileManager\Infrastructure\Persistence\Dql;

/**
 * @phpstan-type DqlFunctions = array<"string_functions"|"datetime_functions"|"numeric_functions", array<string, class-string<\Doctrine\ORM\Query\AST\Functions\FunctionNode>>>
 */
interface DqlFunctionsFactory
{
    /**
     * @return DqlFunctions
     */
    public static function functions(): array;
}
