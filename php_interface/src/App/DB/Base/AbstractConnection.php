<?php

namespace App\DB\Base;

abstract class AbstractConnection
{
    protected string $host;
    protected string $dbname;
    protected string $username;
    protected string $password;

    abstract protected function createConnection(): object;
}
