<?php

namespace App\DB\MySQL;

readonly class Credentials
{
    public function __construct(
        public string $host = 'bitrixdock_db',
        public string $username = 'bitrix',
        public string $password = '123',
        public string $dbname = 'bitrix',
    ) {
    }
}
