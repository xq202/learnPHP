<?php
namespace Controller;
use Model\UserModel;
class ProfileController{
    public function __construct()
    {
        echo "<base href=\"/learnPHP/\">";
    }
    public function ProfileView($page){
        // require "./Model/UserModel.php";
        $userModel = new UserModel();
        $id = null;
        //
        // $_SESSION['id'] = base64_encode('1');
        //
        $userView = null;
        $srcAvatarView = null;
        if(!isset($_SESSION['id'])){
            $_SESSION['id'] = null;
        }
        else{
            $userView = $userModel->getUserById(base64_decode($_SESSION['id']));
            $srcAvatarView = $userView->getAnhDaiDien();
        }
        if(!isset($_GET["id"])){
            $id = base64_decode($_SESSION["id"]);
        }
        else{
            $id = $_GET["id"];
        }
        if($id==null){
            echo "<script> alert('vui long dang nhap');</script>";
            header("location: /learnPHP/Login");
            exit();
        }
        $url = $_SERVER["REQUEST_URI"];
        // echo $url;
        $user = $userModel->getUserById($id);
        $name = $user->getTen();
        $srcCoverPhoto = $user->getAnhBia();
        $srcAvatarPhoto = $user->getAnhDaiDien();
        require "./View/profile.php";
    }
}
$profileController = new ProfileController();
switch($action){
    case "gioi-thieu":
        $profileController->ProfileView("./View/about.php");
        break;
    case "ban-be":
        $profileController->ProfileView("./View/friend.php");
        break;
    case "anh":
        $profileController->ProfileView("./View/photo.php");
        break;
    case "video":
        $profileController->ProfileView("./View/video.php");
        break;
    default:
        $profileController->ProfileView("./View/post.php");
        break;
}
?>