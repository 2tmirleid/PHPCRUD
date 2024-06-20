<?php

namespace App\DB\Base;

use App\DB\MySQL\Credentials;

abstract class AbstractConnection
{
    protected string $host;
    protected string $dbname;
    protected string $username;
    protected string $password;

    abstract protected function createConnection(Credentials $credentials): object;
}
