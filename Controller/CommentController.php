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
        if($userName==null) $userName = "noname";
        //post
        $post = $postModel->getPostById($idPost);
        $text = $post['text'];
        //time
        $passed = new TimePassed($post['create_time']);
        $passed = (string) $passed;
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