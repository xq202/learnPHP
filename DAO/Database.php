<?php

// use Exception;

class Conn{
    private $db_name = "test";
    private $user = "root";
    private $pass = "2002";
    private $db_server = "localhost";
    private $conn = null;
    public function __construct(){

    }
    public function connect(){
        try{
            $conn = mysqli_connect($this->db_server, $this->user, $this->pass, $this->db_name);
            // if($conn){
            //     echo "connected";
            // }
            // else{
            //     echo "connect fall";
            // }
        }
        catch(mysqli_sql_exception $e){
            echo $e;
        }
        return $conn;
    }
}
?>