<?php

declare(strict_types=1);

namespace JardisCore\DbQuery\factory;

use InvalidArgumentException;
use JardisCore\DbQuery\command\delete\DeleteMySql;
use JardisCore\DbQuery\command\delete\DeletePostgresSql;
use JardisCore\DbQuery\command\delete\DeleteSqlBuilder;
use JardisCore\DbQuery\command\delete\DeleteSqliteSql;
use JardisCore\DbQuery\command\insert\InsertMySql;
use JardisCore\DbQuery\command\insert\InsertPostgresSql;
use JardisCore\DbQuery\command\insert\InsertSqlBuilder;
use JardisCore\DbQuery\command\insert\InsertSqliteSql;
use JardisCore\DbQuery\command\update\UpdateMySql;
use JardisCore\DbQuery\command\update\UpdatePostgresSql;
use JardisCore\DbQuery\command\update\UpdateSqlBuilder;
use JardisCore\DbQuery\command\update\UpdateSqliteSql;
use JardisCore\DbQuery\data\Dialect;
use JardisCore\DbQuery\query\MySql;
use JardisCore\DbQuery\query\PostgresSql;
use JardisCore\DbQuery\query\SqlBuilder;
use JardisCore\DbQuery\query\SqliteSql;

/**
 * Factory for creating SQL builders based on database dialect
 *
 * Provides methods for creating SELECT, INSERT, UPDATE, and DELETE SQL builders
 * for different database dialects (MySQL/MariaDB, PostgreSQL, SQLite).
 */
class SqlBuilderFactory
{
    /**
     * Create a SELECT SQL builder for the specified dialect
     *
     * @param string $dialect Database dialect: 'mysql', 'mariadb', 'postgres', 'sqlite'
     * @param string|null $version Database version (e.g., '8.0', '14'). Uses default if null.
     * @return SqlBuilder
     * @throws InvalidArgumentException If dialect is not supported
     */
    public static function createSelect(string $dialect, ?string $version = null): SqlBuilder
    {
        $dialectEnum = self::parseDialect($dialect);
        self::setBuilderContext($dialectEnum, $version);

        return match ($dialectEnum) {
            Dialect::PostgreSQL => new PostgresSql(),
            Dialect::SQLite => new SqliteSql(),
            Dialect::MySQL, Dialect::MariaDB => new MySql(),
        };
    }

    /**
     * Create an INSERT SQL builder for the specified dialect
     *
     * @param string $dialect Database dialect: 'mysql', 'mariadb', 'postgres', 'sqlite'
     * @param string|null $version Database version (e.g., '8.0', '14'). Uses default if null.
     * @return InsertSqlBuilder
     * @throws InvalidArgumentException If dialect is not supported
     */
    public static function createInsert(string $dialect, ?string $version = null): InsertSqlBuilder
    {
        $dialectEnum = self::parseDialect($dialect);
        self::setBuilderContext($dialectEnum, $version);

        return match ($dialectEnum) {
            Dialect::PostgreSQL => new InsertPostgresSql(),
            Dialect::SQLite => new InsertSqliteSql(),
            Dialect::MySQL, Dialect::MariaDB => new InsertMySql(),
        };
    }

    /**
     * Create an UPDATE SQL builder for the specified dialect
     *
     * @param string $dialect Database dialect: 'mysql', 'mariadb', 'postgres', 'sqlite'
     * @param string|null $version Database version (e.g., '8.0', '14'). Uses default if null.
     * @return UpdateSqlBuilder
     * @throws InvalidArgumentException If dialect is not supported
     */
    public static function createUpdate(string $dialect, ?string $version = null): UpdateSqlBuilder
    {
        $dialectEnum = self::parseDialect($dialect);
        self::setBuilderContext($dialectEnum, $version);

        return match ($dialectEnum) {
            Dialect::PostgreSQL => new UpdatePostgresSql(),
            Dialect::SQLite => new UpdateSqliteSql(),
            Dialect::MySQL, Dialect::MariaDB => new UpdateMySql(),
        };
    }

    /**
     * Create a DELETE SQL builder for the specified dialect
     *
     * @param string $dialect Database dialect: 'mysql', 'mariadb', 'postgres', 'sqlite'
     * @param string|null $version Database version (e.g., '8.0', '14'). Uses default if null.
     * @return DeleteSqlBuilder
     * @throws InvalidArgumentException If dialect is not supported
     */
    public static function createDelete(string $dialect, ?string $version = null): DeleteSqlBuilder
    {
        $dialectEnum = self::parseDialect($dialect);
        self::setBuilderContext($dialectEnum, $version);

        return match ($dialectEnum) {
            Dialect::PostgreSQL => new DeletePostgresSql(),
            Dialect::SQLite => new DeleteSqliteSql(),
            Dialect::MySQL, Dialect::MariaDB => new DeleteMySql(),
        };
    }

    /**
     * Parse dialect string to Dialect enum
     *
     * @param string $dialect Database dialect string
     * @return Dialect The parsed dialect enum
     * @throws InvalidArgumentException If dialect is not supported
     */
    private static function parseDialect(string $dialect): Dialect
    {
        return Dialect::tryFromString($dialect)
            ?? throw new InvalidArgumentException("Unsupported dialect: {$dialect}");
    }

    /**
     * Set BuilderRegistry context for version-aware builder resolution
     *
     * @param Dialect $dialect Database dialect enum
     * @param string|null $version Database version, uses default if null
     */
    private static function setBuilderContext(Dialect $dialect, ?string $version): void
    {
        $resolvedVersion = $version ?? $dialect->defaultVersion();
        BuilderRegistry::setContext($dialect->value, $resolvedVersion);
    }
}
