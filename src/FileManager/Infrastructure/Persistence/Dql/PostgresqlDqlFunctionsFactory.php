<?php

declare(strict_types=1);


namespace App\FileManager\Infrastructure\Persistence\Dql;

use App\FileManager\Infrastructure\Persistence\Dql\Postgresql\MimeSubType;
use App\FileManager\Infrastructure\Persistence\Dql\Postgresql\MimeType;
use App\FileManager\Infrastructure\Persistence\Dql\Postgresql\Month;
use App\FileManager\Infrastructure\Persistence\Dql\Postgresql\Year;

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
