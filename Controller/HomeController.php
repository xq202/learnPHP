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
if(!isset($_SESSION["id"])){
    header("location: Login");
    exit();
}
$homeController->ViewHome();