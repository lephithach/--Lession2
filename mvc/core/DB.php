<?php

class DB{

    public $conn;
    protected $servername = "localhost";
    protected $username = "root";
    protected $password = "";
    protected $dbname = "lampart";

    public function __construct(){
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        if(!$this->conn) {
            die('Error');
        }
        mysqli_set_charset($this->conn,"utf8");
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    }

    public function __destruct() {
        mysqli_close($this->conn);
    }
}

?>