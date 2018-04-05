<?php

require_once __DIR__ . '/MySQL.php';

class User extends MySQL
{

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'users';
    }

}
