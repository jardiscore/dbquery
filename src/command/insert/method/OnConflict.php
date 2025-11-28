<?php

declare(strict_types=1);

namespace JardisCore\DbQuery\command\insert\method;

use JardisCore\DbQuery\data\InsertState;
use JardisPsr\DbQuery\DbInsertBuilderInterface;

/**
 * Handles ON CONFLICT clause configuration for INSERT statements
 *
 * Sets the columns or constraint to check for conflicts in PostgreSQL/SQLite style upserts.
 */
class OnConflict
{
    /**
     * @template T of DbInsertBuilderInterface
     * @param T $builder
     * @return T
     */
    public function __invoke(
        InsertState $state,
        DbInsertBuilderInterface $builder,
        string ...$columnsOrConstraint
    ): DbInsertBuilderInterface {
        $state->setOnConflictColumns(array_values($columnsOrConstraint));

        return $builder;
    }
}
