<?php
namespace Model;
// require "./DAO/Database.php";
use DAO\ConnDAO;
use Exception;

class PostModel{
    private $conn = null;
    public function __construct()
    {
        $this->conn = new ConnDAO();
        $this->conn = $this->conn->connect();
    }
    //post
    public function getPostById($id){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("select * from post where id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            return $result->fetch_assoc();
        }
    }
    public function getListIdPostByIdAcc($id, $index){
        $sql = "select * from post_of_user where id_user = ? order by id desc limit ?, 20";
        $stmt = $this->conn->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param("ss",$id,$index);
        $stmt->execute();
        $result = $stmt->get_result();
        $listIdPost = [];
        if($result){
            while($row = $result->fetch_assoc()){
                $listIdPost[] = $row['id_post'];
            }
            return $listIdPost;
        }
        else{
            echo $stmt->error;
        }
    }
    //media
    public function getListIdMediaByIdPost($idPost){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("select * from media_of_post where id_post = ?");
        $stmt->bind_param("s",$idPost);
        $stmt->execute();
        $result = $stmt->get_result();
        $listIdMedia = [];
        if($result){
            while($row = $result->fetch_assoc()){
                $listIdMedia[] = $row["id_media"];
            }
            return $listIdMedia;
        }
        else{
            echo $stmt->error;
        }
    }
    public function getMediaById($id){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("select * from media where id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $media = [];
        if($result){
            while($row = $result->fetch_assoc()){
                $media['src'] = $row['src'];
                $media['create_time'] = $row['create_time'];
                $media['type'] = $row['type'];
            }
            return $media;
        }
        else{
            echo $stmt->error;
        }
    }
    //like
    public function getCountLikeByIdPost($id){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("select count(*) as s from likes where id_post = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            return $result->fetch_assoc()['s'];
        }
        else{
            echo $stmt->error;
        }
    }
    public function actionLikePost($id_user, $id_post){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("select * from likes where id_user_like = ? and id_post = ?");
        $stmt->bind_param("ss",$id_user, $id_post);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            if($row = $result->fetch_assoc()){
                $stmt->prepare("delete from likes where id = ?");
                $stmt->bind_param("s",$row['id']);
                $stmt->execute();
                return 0;
            }
            else{
                $stmt->prepare("insert into likes (id_user_like, id_post) values (?, ?)");
                $stmt->bind_param("ss",$id_user,$id_post);
                $stmt->execute();
                return 1;
            }
        }
        else{
            echo $stmt->error;
            return -1;
        }
    }
    public function checkLike($idUser, $idPost){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("select * from likes where id_user_like = ? and id_post = ?");
        $stmt->bind_param("ss",$idUser, $idPost);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            $c = $result->fetch_assoc();
            if($c){
                return 1;
            }
            else{
                return 0;
            }
        }
        else{
            echo $stmt->error;
        }
    }
    //comment
    public function getCountCommentByIdPost($id){
        $res = 0;
        $listIdComment = $this->getListIdCommentByIdPost($id,-1);
        foreach($listIdComment as $idComment){
            $res+=1;
            $res+=count($this->getListReplyOfCommentByIdComment($idComment));
        }
        return $res;
    }
    public function getCommentById($id){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("select * from comments where id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            return $result->fetch_assoc();
        }
        else{
            echo $stmt->error;
        }
    }
    public function getListIdCommentByIdPost($idPost, $index){
        $stmt = $this->conn->stmt_init();
        if($index>=0) $sql = " limit ?, 50";
        else{
            $sql = '';
        }
        $stmt->prepare("select * from comment_of_post where id_post = ? order by id desc{$sql}");
        if($index>=0) $stmt->bind_param("ss",$idPost, $index);
        else $stmt->bind_param("s",$idPost);
        $stmt->execute();
        $result = $stmt->get_result();
        $listIdComment = [];
        if($result){
            while($row = $result->fetch_assoc()){
                $listIdComment[] = $row['id_comment'];
            }
            return $listIdComment;
        }
        else{
            echo $stmt->error;
        }
    }
    public function getListReplyOfCommentByIdComment($idComment){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("select * from reply_of_comment where id_comment = ?");
        $stmt->bind_param("s",$idComment);
        $stmt->execute();
        $result = $stmt->get_result();
        $listIdComment = [];
        if($result){
            while($row = $result->fetch_assoc()){
                $listIdComment[] = $row;
            }
            return $listIdComment;
        }
        else{
            echo $stmt->error;
        }
    }
    //share
    public function getCountShareByIdPost($id){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("select count(*) as s from share where id_post = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            return $result->fetch_assoc()['s'];
        }
        else{
            echo $stmt->error;
        }
    }
}
?>