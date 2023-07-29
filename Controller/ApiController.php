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
        $listDataPost = [];
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $currentTime = new DateTime('now');
        
        foreach($listPost as $post){
            //time
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
            //media
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
            //like
            $countLike = $postModel->getCountLikeByIdPost($post['id']);
            $checkLike = $postModel->checkLike(base64_decode($_SESSION['id']),$post['id']);
            //comment
            $countComment = $postModel->getCountCommentByIdPost($post['id']);
            //share
            $countShare = $postModel->getCountShareByIdPost($post['id']);

            $dataPost = [
                'idPost'=>$post['id'],
                'srcAvatarPhoto'=>$srcAvatarPhoto,
                'userName'=>$name,
                'passed'=>$passed,
                'text'=>$post['text'],
                'media'=>$media,
                'countLike'=>$countLike,
                'checkLike'=>$checkLike,
                'countComment'=>$countComment,
                'countShare'=>$countShare
            ];
            $listDataPost[] = $dataPost;
        }
        echo json_encode($listDataPost);
        // print_r($listDataPost);
    }
    public function LikeAPI(){
        $postModel = new PostModel();
        $idPost = $_GET['idPost'];
        $idUser = $_GET['idUser'];
        $res = $postModel->actionLikePost($idUser, $idPost);
        if($res==1){
            echo '1';
        }
        elseif($res==0){
            echo '0';
        }
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
    case "likeapi":
        $apiController->LikeAPI();
        break;
    default:
        break;
}