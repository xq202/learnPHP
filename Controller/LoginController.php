<?php
include("../DAO/Database.php");
include("../Model/Encrypt.php");
function login($username, $password){
    $conn = new Conn;
    $conn = $conn->connect();
    $stmt = $conn->stmt_init();
    $stmt->prepare("select username, password from account where username = ?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if(isset($row)){
        $encrypt = new Encrypt();
        $pass = base64_encode($encrypt->encrypt($password));
        // echo $pass.'<br>'.$row["password"];
        if($pass===$row["password"])
        return 1;
        else return 2;
    }
    else{
        return 0;
    }
}
// echo login("admin","admin");
function register($username, $password){

}
?>