<?php
$db_name = "test";
$user = "root";
$pass = "2002";
$db_server = "localhost";
$conn = null;
try{
    $conn = mysqli_connect($db_server, $user, $pass, $db_name);
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
?>