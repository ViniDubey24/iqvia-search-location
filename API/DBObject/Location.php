<?php

require_once 'MySQL.php';

class Location extends MySQL
{

    public function __construct()
    {
    	parent::__construct();
        $this->tableName = 'locations';
    }

}
