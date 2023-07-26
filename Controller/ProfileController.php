<?php
namespace Controller;
use Model\UserModel;
class ProfileController{
    public function __construct()
    {
        
    }
    public function ProfileView($page){
        // require "./Model/UserModel.php";
        $userModel = new UserModel();
        $id = null;
        if(!isset($_GET["id"])){
            $id = base64_decode($_SESSION["id"]);
        }
        else{
            $id = $_GET["id"];
        }
        $user = $userModel->getUserById($id);
        $name = $user->getTen();
        if($name==null) $name = "noname";
        $srcCoverPhoto = $user->getAnhBia();
        $srcAvatarPhoto = $user->getAnhDaiDien();
        require "./View/profile.php";
    }
}
$profileController = new ProfileController();
if($action == "gioi-thieu"){
    $profileController->ProfileView("./View/gioi-thieu.php");
}
else{
    $profileController->ProfileView("./View/bai-viet.php");
}
?>