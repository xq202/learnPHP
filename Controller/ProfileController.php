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
        if(!isset($_GET["id"])){
            $id = base64_decode($_SESSION["id"]);
        }
        else{
            $id = $_GET["id"];
        }
        $url = $_SERVER["REQUEST_URI"];
        // echo $url;
        $user = $userModel->getUserById($id);
        $name = $user->getTen();
        if($name==null) $name = "noname";
        $srcCoverPhoto = $user->getAnhBia();
        $srcAvatarPhoto = $user->getAnhDaiDien();
        if(!isset($_SESSION['id'])){
            $_SESSION['id'] = null;
        }
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