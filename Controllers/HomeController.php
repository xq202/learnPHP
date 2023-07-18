<?php
class HomeController{
    public function __construct()
    {
        
    }
    public function ViewHome(){
        require "./View/home.php";
    }
}
$homeController = new HomeController();
if(!isset($_SESSION["account"])){
    header("location: Login");
    exit();
}
$homeController->ViewHome();