<?php

namespace App\DB\MySQL\Methods;

use App\DB\Base\AbstractConnection;

abstract class AbstractMethods extends AbstractConnection
{
    /**
     * @param array $select
     * @param array|null $filter
     * @return array
     */
    abstract public function select(array $select, ?array $filter = null): array;

    /**
     * @param array $values
     * @return bool|\PDOStatement
     */
    abstract public function create(array $values): bool | \PDOStatement;

    /**
     * @param array $properties
     * @param array $filter
     * @param array $values
     * @return bool|\PDOStatement
     */
    abstract public function update(array $properties, array $filter, array $values): bool | \PDOStatement;

    /**
     * @param array $filter
     * @return bool|\PDOStatement
     */
    abstract public function delete(array $filter): bool | \PDOStatement;

    /**
     * @param array $filter
     * @return string
     */
    abstract protected function parseFilters(array $filter): string;
}