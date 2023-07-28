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
    }
    public function getPostById($id){
        $conn = $this->conn->connect();
        $stmt = $conn->stmt_init();
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
        $conn = $this->conn->connect();
        $stmt = $conn->stmt_init();
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
    public function getListIdMediaByIdPost($idPost){
        $conn = $this->conn->connect();
        $stmt = $conn->stmt_init();
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
        $conn = $this->conn->connect();
        $stmt = $conn->stmt_init();
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
    public function getCountLikeByIdPost($id){
        $conn = $this->conn->connect();
        $stmt = $conn->stmt_init();
        $stmt->prepare("select count(*) as s from likes where id = ?");
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
    public function getCountCommentByIdPost($id){
        $conn = $this->conn->connect();
        $stmt = $conn->stmt_init();
        $stmt->prepare("select count(*) as s from comments where id = ?");
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