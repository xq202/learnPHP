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
        $userModel = new UserModel();
        $commentModel = new CommentModel();
        $tag = new TagModel();
        $time = new TimePassed();
        $idPost = $_GET['idPost'];
        $index = $_GET['index'];
        $listIdComment = $commentModel->getListIdCommentByIdPost($idPost, $index);
        $data = [];
        $listData = [];
        foreach($listIdComment as $idComment){
            $comment = $commentModel->getCommentById($idComment);
            $id = $comment['id'];
            $text = $comment['text'];
            $idUser = $comment['id_user'];
            $timeComment = $time->timeComment($comment['create_time']);
            $user = $userModel->getUserById($idUser);
            $srcAvatar = $user->getAnhDaiDien();
            $userName = $user->getTen();
            $listReply = $commentModel->getListReplyOfCommentByIdComment($id);
            $replyComments = [];
            //tag
            $listTag = $tag->getListIdUserTagByTypeAndId('comment',$id);
            $listUserNameTag = [];
            foreach($listTag as $t){
                $u = $userModel->getUserById($t);
                $listUserNameTag[$t] = $u->getTen();
            }
            foreach($listReply as $reply){
                $idReply = $reply['id_reply_comment'];
                $commentReply = $commentModel->getCommentById($idReply);
                $textReply = $commentReply['text'];
                $idUserReply = $commentReply['id_user'];
                $timeReply = $time->timeComment($commentReply['create_time']);
                
                $userReply = $userModel->getUserById($idUserReply);

                $listTag = $tag->getListIdUserTagByTypeAndId('comment',$idReply);
                // print_r($listTag);
                $listUserNameTag1 = [];
                foreach($listTag as $t){
                    $u = $userModel->getUserById($t);
                    $listUserNameTag1[$t] = $u->getTen();
                }
                $replyComments[] = [
                    'id'=>$idReply,
                    'text'=>$textReply,
                    'srcAvatar'=>$userReply->getAnhDaiDien(),
                    'userName'=>$userReply->getTen(),
                    'listUserNameTag'=>$listUserNameTag1,
                    'passed'=>$timeReply
                ];
            }
            $data = [
                'id'=>$id,
                'text'=>$text,
                'srcAvatar'=>$srcAvatar,
                'userName'=>$userName,
                'listReply'=>$replyComments,
                'listUserNameTag'=>$listUserNameTag,
                'passed'=>$timeComment
            ];
            $listData[] = $data;
        }
        // print_r($listData);
        echo json_encode($listData);
    }
    public function addCommentAPI(){
        $commentModel = new CommentModel();
        $tagModel = new TagModel();
        $userModel = new UserModel();
        $time = new TimePassed();
        $text = $_POST['text'];
        $idUser = $_POST['idUser'];
        $idComment = $_POST['idComment'];
        $newId = $commentModel->addCommentAndGetNewId($text,$idUser);
        $comment = $commentModel->getCommentById($idComment);
        $tagId = $comment['id_user'];
        $commentModel->addReplyOfComment($commentModel->searchIdCommentByIdReplyComment($idComment),$newId);
        if($tagId != $idUser && $tagId!=null){
            $tagModel->addTagByTypeAndIdType('comment',$newId,$tagId);
        }
        $listData = [];
        $newComment = $commentModel->getCommentById($newId);
        $user = $userModel->getUserById($idUser);
        $listData['userName'] = $user->getTen();
        $listData['srcAvatar'] = $user->getAnhDaiDien();
        $listData['text'] = $newComment['text'];
        $listData['passed'] = 'vai giay';
        $listData['id'] = $newComment['id'];
        echo json_encode($listData);
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
    case "addcommentapi":
        $apiController->addCommentAPI();
        break;
    default:
        break;
}