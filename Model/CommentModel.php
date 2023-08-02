<?php
namespace Model;

use DAO\ConnDAO;

class CommentModel{
    private $conn = null;
    public function __construct()
    {
        $this->conn = new ConnDAO();
        $this->conn = $this->conn->connect();
    }
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
    public function addReplyOfComment($idComment, $idReplyComment){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("insert into reply_of_comment (id_comment, id_reply_comment) values (?, ?)");
        $stmt->bind_param('ss',$idComment,$idReplyComment);
        $stmt->execute();
        $result = $stmt->affected_rows;
        if($result>0){
            return 1;
        }
        else{
            echo 'addReplyOfCommen '.$stmt->error;
        }
    }
    public function addCommentOfPost($idComment, $idPost){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("insert into comment_of_post (id_comment, id_post) values (?, ?)");
        $stmt->bind_param('ss',$idComment,$idPost);
        $stmt->execute();
        $result = $stmt->affected_rows;
        if($result>0){
            return 1;
        }
        else{
            echo "addCommentOfPost " + $stmt->error;
        }
    }
    public function addCommentAndGetNewId($text, $idUser){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("insert into comments (text, id_user) values (?, ?)");
        $stmt->bind_param("ss",$text,$idUser);
        $stmt->execute();
        $affectedRows = $stmt->affected_rows;
        $newId = $stmt->insert_id;
        if($affectedRows>0){
            return $newId;
        }
        else{
            echo 'addCommentAndGetNewId '.$stmt->error;
        }
    }
    public function searchIdCommentByIdReplyComment($idReplyComment){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("select * from reply_of_comment where id_reply_comment = ?");
        $stmt->bind_param("s",$idReplyComment);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            return $result->fetch_assoc()['id_comment'];
        }
        else{
            echo 'searchIdCommentByIdReplyComment '.$stmt->error;
        }
    }
}