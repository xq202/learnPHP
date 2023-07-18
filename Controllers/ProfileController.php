<?php
class ProfileController{
    public function __construct()
    {
        
    }
    public function ProfileView(){
        $nameUser = "test";
        if(!isset($_GET["id"])){
            $_GET["id"] = $_SESSION["id"];
        }
        require "./View/profile.php";
    }
}
$profileController = new ProfileController();
$profileController->ProfileView();