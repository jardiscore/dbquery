<?php

declare(strict_types=1);

namespace JardisCore\DbQuery\query\builder\method;

use JardisCore\DbQuery\data\QueryConditionCollector;
use JardisCore\DbQuery\query\condition\QueryCondition;
use JardisPsr\DbQuery\DbQueryConditionBuilderInterface;

/**
 * Stateless builder for WHERE clause initialization
 *
 * Can be reused across DbQuery, DbUpdate, DbDelete without side effects.
 */
class Where
{
    /**
     * Initialize WHERE condition
     *
     * @param QueryConditionCollector $collector The condition collector
     * @param QueryCondition $queryCondition The condition builder instance
     * @param string|null $field The field name (already resolved)
     * @param string|null $openBracket Opening brackets
     * @return DbQueryConditionBuilderInterface
     */
    public function __invoke(
        QueryConditionCollector $collector,
        QueryCondition $queryCondition,
        ?string $field,
        ?string $openBracket
    ): DbQueryConditionBuilderInterface {
        $condition = count($collector->whereConditions()) ? ' AND ' : ' WHERE ';
        $queryCondition->initCondition($condition . $openBracket . $field);

        return $queryCondition;
    }
}
