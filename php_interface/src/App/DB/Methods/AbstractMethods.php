<?php

namespace App\DB\Methods;

use App\DB\Base\AbstractConnection;

abstract class AbstractMethods extends AbstractConnection
{
    abstract public function select(array $select, ?array $filter = null);

    abstract public function create(array $values): bool;

    abstract public function update(array $properties, array $filter, array $values): bool;

    abstract public function delete(array $filter): bool;

    abstract protected function parseFilters(array $filter): string;
}