<?php

// use Exception;
namespace DAO;

use Exception;

class ConnDAO{
    private $db_name = "test";
    private $user = "root";
    private $pass = null;
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
        catch(Exception $e){
            echo $e;
        }
        return $conn;
    }
}
?>