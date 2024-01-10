<?php

declare(strict_types=1);


namespace Zenchron\FileBundle\Infrastructure\Persistence\Dql;

use Zenchron\FileBundle\Infrastructure\Persistence\Dql\Sqlite\MimeSubType;
use Zenchron\FileBundle\Infrastructure\Persistence\Dql\Sqlite\MimeType;
use Zenchron\FileBundle\Infrastructure\Persistence\Dql\Sqlite\Month;
use Zenchron\FileBundle\Infrastructure\Persistence\Dql\Sqlite\Year;

/**
 * @phpstan-import-type DqlFunctions from DqlFunctionsFactory
 */
class SqliteDqlFunctionsFactory implements DqlFunctionsFactory
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