<?php

namespace App\DB\MySQL;

use App\DB\MySQL\Models\Users;

trait Singleton
{
    static public function getInstance()
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new static();
        }
        return $instance;
    }

    final private function __construct() {
        $this->init();
    }

    protected function init() {}

    private function __wakeup() {}
    private function __clone() {}
}