<?php

require_once 'MySQL.php';

class User extends MySQL
{

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'users';
    }

}
