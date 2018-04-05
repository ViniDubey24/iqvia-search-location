<?php

require_once __DIR__ . '/MySQL.php';

class Location extends MySQL
{

    public function __construct()
    {
    	parent::__construct();
        $this->tableName = 'locations';
    }

}
