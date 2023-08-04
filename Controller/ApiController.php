<?php
namespace Controller;
// require "./Model/LoginModel.php";
// require "./Model/PostModel.php";
// require "./Model/UserModel.php";

use DateTime;
use Model\CommentModel;
use Model\LoginModel;
use Model\UserModel;
use Model\PostModel;
use Model\TagModel;
use Model\TimePassed;

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
        $commentModel = new CommentModel();
        $listIdPost = $postModel->getListIdPostByIdAcc($id, $index);
        $listPost = array();
        foreach($listIdPost as $idPost){
            $listPost[] = $postModel->getPostById($idPost);
        }
        $listDataPost = [];
        
        foreach($listPost as $post){
            //time
            $time = new TimePassed();
            $passed = $time->timePost($post['create_time']);
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
            $countComment = $commentModel->getCountCommentByIdPost($post['id']);
            //share
            $countShare = $postModel->getCountShareByIdPost($post['id']);

            $dataPost = [
                'idPost'=>$post['id'],
                'srcAvatarPhoto'=>$srcAvatarPhoto,
                'userName'=>$name,
                'passed'=>(string)$passed,
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
    public function CommentAPI(){
        $commentModel = new CommentModel();
        $idPost = $_GET['idPost'];
        $index = $_GET['index'];
        $listIdComment = $commentModel->getListIdCommentByIdPost($idPost, $index);
        $data = [];
        $listData = [];
        foreach($listIdComment as $idComment){
            $data = $commentModel->getFullInfoCommentById($idComment);
            $id = $data['id'];
            $listReply = $commentModel->getListReplyOfCommentByIdComment($id);
            $replyComments = [];
            foreach($listReply as $reply){
                $idReply = $reply['id_reply_comment'];
                $replyComments[] = $commentModel->getFullInfoCommentById($idReply);
            }
            $data['listReply'] = $replyComments;
            $listData[] = $data;
        }
        // print_r($listData);
        echo json_encode($listData);
    }
    public function addReplyCommentAPI(){
        $commentModel = new CommentModel();
        $tagModel = new TagModel();
        $text = $_POST['text'];
        $idUser = $_POST['idUser'];
        $idComment = $_POST['idCommentRep'];
        $newId = $commentModel->addCommentAndGetNewId($text,$idUser);
        $comment = $commentModel->getCommentById($idComment);
        $tagId = $comment['id_user'];
        $commentModel->addReplyOfComment($commentModel->searchIdCommentByIdReplyComment($idComment),$newId);
        if($tagId != $idUser && $tagId!=null){
            $tagModel->addTagByTypeAndIdType('comment',$newId,$tagId);
        }
        sleep(1);
        $listData = $commentModel->getFullInfoCommentById($newId);
        echo json_encode($listData);
    }
    public function addCommentAPI(){
        $idPost = $_POST['idPost'];
        $text = $_POST['text'];
        $idUser = $_POST['idUser'];
        $commentModel = new CommentModel();
        $newId = $commentModel->addCommentAndGetNewId($text,$idUser);
        $commentModel->addCommentOfPost($newId,$idPost);
        sleep(1);
        echo $idPost.' '.$text.' '.$idUser;
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
    case "commentapi":
        $apiController->CommentAPI();
        break;
    case "addreplycommentapi":
        $apiController->addReplyCommentAPI();
        break;
    case "addcommentapi":
        $apiController->addCommentAPI();
    default:
        break;
}