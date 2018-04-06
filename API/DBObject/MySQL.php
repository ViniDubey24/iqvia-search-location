<?php

class MySQL
{

    protected $connection = null;
    protected $tableName = null;

    private $host = 'localhost';
    private $userName = 'root';
    private $password = '';
    private $db = 'iqvia';

    public function __construct()
    {
        $this->connection = mysqli_connect($this->host, $this->userName, $this->password, $this->db);

        if (!$this->connection) {
            die("connection failed: " . mysqli_connect_error());
        }
    }

    public function insert($data)
    {
        $returnData = false;
        try {
            $columns = '`' . implode('`,`', array_keys($data)) . '`';
            $values = '"' . implode('","', $data) . '"';
            $sql = "INSERT INTO  `$this->tableName` ($columns) VALUES ($values)";

            $insertionResult = mysqli_query($this->connection, $sql);
            if ($insertionResult) {
                $returnData = mysqli_insert_id($this->connection);
            }
        } catch (Exception $e) {
            // handle exception
            $returnData = false;
        }

        return $returnData;
    }

    public function getRecord($searchCondition)
    {
        $returnData = null;

        try {
            $whereClause = 1;

            if (!empty($searchCondition)) {
                $tmp = [];
                foreach ($searchCondition as $key => $value) {
                    $tmp[] = "$key = '" . $value . "'";
                }
                $whereClause = implode(' AND ', $tmp);
            }
            $sql = "SELECT * FROM $this->tableName WHERE $whereClause LIMIT 1";

            $result = mysqli_query($this->connection, $sql);
            $returnData = mysqli_fetch_assoc($result);

        } catch (Exception $e) {
            // handle exception
            $returnData = null;
        }

        return $returnData;
    }

    public function getAllRecord($searchCondition = [], $options = [])
    {
        $returnData = null;

        try {
            $whereClause = 1;

            if (!empty($searchCondition)) {
                $tmp = [];
                foreach ($searchCondition as $key => $value) {
                    $tmp[] = "$key = '" . $value . "'";
                }
                $whereClause = implode(' AND ', $tmp);
            }
            $sql = "SELECT * FROM $this->tableName WHERE $whereClause ";

// die($sql);
            if (isset($options['limit']) && isset($options['offset'])) {
                $sql .= ' LIMIT ' . $options['offset'] . ',' . $options['limit'];
            }

            $result = mysqli_query($this->connection, $sql);

            $returnData = [];
            while ($row = $result->fetch_assoc()) {
                $returnData[] = $row;
            }

        } catch (Exception $e) {
            // handle exception
            $returnData = null;
        }

        return $returnData;
    }

    public function getCount($searchCondition = [])
    {
        $returnData = null;

        try {
            $whereClause = 1;
            if (!empty($searchCondition)) {
                $tmp = [];
                foreach ($searchCondition as $key => $value) {
                    $tmp[] = "$key = '" . $value . "'";
                }
                $whereClause = implode(' AND ', $tmp);
            }
            $sql = "SELECT COUNT(*) as count FROM $this->tableName WHERE $whereClause";

            $result = mysqli_query($this->connection, $sql);
            $returnData = (int) mysqli_fetch_assoc($result)['count'];

        } catch (Exception $e) {
            // handle exception
            $returnData = null;
        }

        return $returnData;
    }

    public function updateRecord($searchCondition, $data)
    {
        $returnData = null;

        try {
            $set = $whereClause = '';

            if (!empty($searchCondition)) {
                $tmp = [];
                foreach ($searchCondition as $key => $value) {
                    $tmp[] = "$key = '" . $value . "'";
                }
                $whereClause = implode(' AND ', $tmp);
            }

            if (!empty($data)) {
                $tmp = [];
                foreach ($data as $key => $value) {
                    $tmp[] = "$key = '" . $value . "'";
                }
                $set = implode(', ', $tmp);
            }

            if ($set && $whereClause) {
                $sql = "UPDATE $this->tableName SET $set WHERE $whereClause";
                $returnData = mysqli_query($this->connection, $sql);
            }

        } catch (Exception $e) {
            // handle exception
            $returnData = null;
        }

        return $returnData;
    }

    public function deleteRecord($searchCondition)
    {
        die('deleteRecord query');
    }

}
