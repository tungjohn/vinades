<?php

class Database {
    public $host = "localhost";
    public $user = "root";
    public $password = "";
    public $dbname = 'vinades';
    public $connection;

    public function connectDB()
    {
        $connection = mysqli_connect($this->host, $this->user, $this->password, $this->dbname);
        return $connection;
    }
    public function __construct()
    {
        return $this->connection = $this->connectDB();
    }
    public function create($sql) 
    {
        $result = mysqli_query($this->connection, $sql);
        return $result;
    }

    public function runQuery($sql)
    {
        $data = array();
        $result = mysqli_query($this->connection, $sql);

        while ($row = mysqli_fetch_assoc($result))
        {
            $data[] = $row;
        }
        
        return $data;
    }
    function check_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    
 
}



?>