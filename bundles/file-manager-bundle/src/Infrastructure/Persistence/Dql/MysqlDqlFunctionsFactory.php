<?php

declare(strict_types=1);


namespace Zenchron\FileBundle\Infrastructure\Persistence\Dql;

use Zenchron\FileBundle\Infrastructure\Persistence\Dql\Mysql\MimeSubType;
use Zenchron\FileBundle\Infrastructure\Persistence\Dql\Mysql\MimeType;
use Zenchron\FileBundle\Infrastructure\Persistence\Dql\Mysql\Month;
use Zenchron\FileBundle\Infrastructure\Persistence\Dql\Mysql\Year;

/**
 * @phpstan-import-type DqlFunctions from DqlFunctionsFactory
 */
class MysqlDqlFunctionsFactory implements DqlFunctionsFactory
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
