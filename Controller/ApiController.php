<?php
namespace Controller;
// require "./Model/LoginModel.php";
// require "./Model/PostModel.php";
// require "./Model/UserModel.php";
use Model\LoginModel;
use Model\UserModel;
use Model\PostModel;
class ApiController{
    public function RegisterAPI(){
        $register = new LoginModel();
        $result = $register->checkRegister();
        // echo "run";
        if($result==1){
            $res = $register->register();
            if($res==0){
                echo "0:Tài khoản đã tồn tại";
                exit();
            }
            else
            echo "1:Đăng ký thành công!";
            $_SESSION["id"] = base64_encode($res);
            $_SESSION["logged"] = 1;
            exit();
        }
        else{
            echo '0:'.$result;
        }
    }
    public function PostAPI(){
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
        $srcAvatarPhoto = $user->getAnhDaiDien();
        $postModel = new PostModel();
        $listIdPost = $postModel->getListIdPostByIdAcc($id);
        $listPost = array();
        foreach($listIdPost as $idPost){
            $listPost[] = $postModel->getPostById($idPost);
        }
        $media = "";
        $media .= '<video src="./Data/Video/Facebook.mp4" controls></video><br>';
        $media .= '<img class="media"src="./Data/Photo/Avatar/avatar-admin.jpg"><br>';
        $listPostHtml = [];
        foreach($listPost as $post){
            $listPostHtml[] = 
            '
            <div class="post">
                <div class="user_of_post">
                    <div class="small_avatar">
                        <a href=""><img src="'.$srcAvatarPhoto.'" alt=""></a>
                    </div>
                    <div class="name_and_date">
                    <span style="font-size: 15px; font-weight: bold;">'.$name.'</span><br>
                    <span>1 ngay</span>
                    </div>
                </div>
                <div class="post_content">
                    <div class="text">
                        <p>'.$post->getText().'
                    </div>
                    <div class="list_media">
                        '.$media.'
                        <img class="media"src="./Data/Photo/Avatar/avatar-admin.jpg"><br>
                    </div>
                </div>
                <div class="action_with_post">
                    <button>like</button><button>binh luan</button><button>chia se</button>
                </div>
            </div>
            ';
        }
        echo json_encode($listPostHtml);
    }
}
$apiController = new ApiController();
switch($action){
    case "registerapi":
        $apiController->RegisterAPI();
        break;
    case "postapi":
        $apiController->PostAPI();
        break;
    default:
        break;
}