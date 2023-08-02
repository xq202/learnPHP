<?php

use Model\PostModel;
use Model\TimePassed;
use Model\UserModel;

class CommentController{
    public function CommentView(){
        $postModel = new PostModel();
        $idPost = $_GET['idPost'];
        $idUser = $_GET['idUser'];
        //user
        $userModel = new UserModel();
        $user = $userModel->getUserById($idUser);
        $userName = $user->getTen();
        $srcAvatarPhoto = $user->getAnhDaiDien();
        $idUserView = null;
        if(!isset($_SESSION['id'])){
            echo '<script> alert("ban can dang nhap");</script>';
            header('location: /learnPHP/Login');
            exit();
        }
        else{
            $idUserView = base64_decode($_SESSION['id']);
        }
        $userView = $userModel->getUserById($idUserView);
        $srcAvatarPhotoView = $userView->getAnhDaiDien();
        if($userName==null) $userName = "noname";
        //post
        $post = $postModel->getPostById($idPost);
        $text = $post['text'];
        //time
        $time = new TimePassed();
        $passed = $time->timePost($post['create_time']);
        // var_dump($passed);
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
        if($checkLike==1){
            $liked = "aqua";
        }
        else{
            $liked = "buttonface";
        }
        require "./View/comment.php";
    }
}
$comment = new CommentController();
$comment->CommentView();