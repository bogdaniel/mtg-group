<?php

declare(strict_types=1);


namespace Zenchron\FileManagerBundle\Infrastructure\Persistence\Dql;

/**
 * @phpstan-import-type DqlFunctions from DqlFunctionsFactory
 */
class DqlFunctionsManager
{
    public const MYSQL      = 'mysql';
    public const MARIADB    = 'mariadb';
    public const SQLITE     = 'sqlite';
    public const POSTGRESQL = 'postgresql';
    public const DRIVERS    = [
        self::MARIADB,
        self::MYSQL,
        self::SQLITE,
        self::POSTGRESQL,
    ];

    /**
     * @param string $driver
     * @return DqlFunctions
     */
    public static function getFunctionsByDriver(string $driver): array
    {
        return match ($driver) {
            self::MARIADB,
            self::MYSQL => MysqlDqlFunctionsFactory::functions(),
            self::SQLITE => SqliteDqlFunctionsFactory::functions(),
            self::POSTGRESQL => PostgresqlDqlFunctionsFactory::functions(),
            default => throw new \InvalidArgumentException(
                \sprintf(
                    'Invalid database driver %s. Available drivers: %s',
                    $driver,
                    \implode(',', \array_keys(self::DRIVERS))
                )
            ),
        };
    }

    /**
     * @param string $classPlatform
     * @return DqlFunctions
     */
    public static function getFunctionsByClassPlatform(string $classPlatform): array
    {
        $classPlatform = \mb_strtolower($classPlatform);

        /** @see \Doctrine\DBAL\Platforms\AbstractPlatform */
        return match (true) {
            (
                \str_contains($classPlatform, self::MYSQL) ||
                \str_contains($classPlatform, self::MARIADB)
            ) => MysqlDqlFunctionsFactory::functions(),
            (\str_contains($classPlatform, self::SQLITE)) => SqliteDqlFunctionsFactory::functions(),
            (\str_contains($classPlatform, self::POSTGRESQL)) => PostgresqlDqlFunctionsFactory::functions(),
            default => throw new \InvalidArgumentException(
                \sprintf(
                    'Invalid database driver %s. Available drivers: %s',
                    $classPlatform,
                    \implode(',', \array_keys(self::DRIVERS))
                )
            ),
        };
    }

}
