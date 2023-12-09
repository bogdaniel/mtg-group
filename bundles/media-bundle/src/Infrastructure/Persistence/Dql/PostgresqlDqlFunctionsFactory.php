<?php

declare(strict_types=1);


namespace Zenchron\FileManagerBundle\Infrastructure\Persistence\Dql;

use Zenchron\FileManagerBundle\Infrastructure\Persistence\Dql\Postgresql\MimeSubType;
use Zenchron\FileManagerBundle\Infrastructure\Persistence\Dql\Postgresql\MimeType;
use Zenchron\FileManagerBundle\Infrastructure\Persistence\Dql\Postgresql\Month;
use Zenchron\FileManagerBundle\Infrastructure\Persistence\Dql\Postgresql\Year;

/**
 * @phpstan-import-type DqlFunctions from DqlFunctionsFactory
 */
class PostgresqlDqlFunctionsFactory implements DqlFunctionsFactory
{
    /**
     * @return DqlFunctions
     */
    public static function functions(): array
    {
        return [
            'string_functions' => [
                'MIME_TYPE' => MimeType::class,
                'MIME_SUBTYPE' => MimeSubType::class,
            ],
            'datetime_functions' => [
                'YEAR' => Year::class,
                'MONTH' => Month::class,
            ],
        ];
    }
}
