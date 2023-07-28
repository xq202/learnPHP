<?php
namespace Controller;
// require "./Model/LoginModel.php";
// require "./Model/PostModel.php";
// require "./Model/UserModel.php";

use DateTime;
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
        //user
        $userModel = new UserModel();
        $id = $_GET["id"];
        $index = $_GET["index"];
        $user = $userModel->getUserById($id);
        $name = $user->getTen();
        if($name==null) $name = "noname";
        $srcAvatarPhoto = $user->getAnhDaiDien();
        //post
        $postModel = new PostModel();
        $listIdPost = $postModel->getListIdPostByIdAcc($id, $index);
        $listPost = array();
        foreach($listIdPost as $idPost){
            $listPost[] = $postModel->getPostById($idPost);
        }
        $listPostHtml = [];
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $currentTime = new DateTime('now');
        
        foreach($listPost as $post){
            $targetTime = new DateTime($post['create_time']);
            $time = $currentTime->diff($targetTime);
            $listTime = [$time->days.' ngay',$time->h.' gio',$time->i.' phut',$time->s.' giay'];
            $passed = null;
            if($time->days>7){
                $passed = $targetTime->format('d').' thang '.$targetTime->format('m').', '.$targetTime->format('Y');
            }
            else
            foreach($listTime as $t){
                if($t[0]!=0){
                    $passed = $t;
                    break;
                }
            }

            $listIdMedia = $postModel->getListIdMediaByIdPost($post['id']);
            $listMedia = [];
            foreach($listIdMedia as $id){
                $listMedia[] = $postModel->getMediaById($id);
            }
            $media = "";
            foreach($listMedia as $m){
                if($m['type']=="video"){
                    $media .= '<video class="media" src="'.$m['src'].'" controls></video><br>';
                }
                else{
                    $media .= '<img class="media"src="'.$m['src'].'"><br>';
                }
            }

            $countLike = $postModel->getCountLikeByIdPost($post['id']);
            $countComment = $postModel->getCountCommentByIdPost($post['id']);

            $listPostHtml[] = 
            '
            <div class="post">
                <div class="user_of_post">
                    <div class="small_avatar">
                        <a href=""><img src="'.$srcAvatarPhoto.'" alt=""></a>
                    </div>
                    <div class="name_and_date">
                    <span style="font-size: 15px; font-weight: bold;">'.$name.'</span><br>
                    <span>'.$passed.'</span>
                    </div>
                </div>
                <div class="post_content">
                    <div class="text">
                        <p>'.$post['text'].'
                    </div>
                    <div class="list_media">
                        '.$media.'
                    </div>
                </div>
                <div class="info_of_post">
                    <span class="like">'.$countLike.' like</span>
                    <span class="comment">'.$countComment.' binh luan</span>
                    <span class="share"><?=$share?>chia se</span>
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