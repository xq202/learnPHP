<?php
namespace Model;
// require "./DAO/Database.php";
use DAO\ConnDAO;

class PostModel{
    public function getPostById($id){
        $conn = new ConnDAO();
        $conn = $conn->connect();
        $stmt = $conn->stmt_init();
        $stmt->prepare("select * from post where id = ?");
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            $post = new Post();
            $row = $result->fetch_assoc();
            $post->setText($row["text"]);
            return $post;
        }
    }
    public function getListIdPostByIdAcc($id, $index){
        $conn = new ConnDAO();
        $sql = "select * from post_of_user where id_acc = ? limit {$index}, 20";
        $conn = $conn->connect();
        $stmt = $conn->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $listIdPost = array();
        if($result){
            while($row = $result->fetch_assoc()){
                $listIdPost[] = $row["id_post"];
            }
        }
        else{
            echo $stmt->error;
        }
        return $listIdPost;
    }
}
class Post{
    private $text;
    public function getText(){
        return $this->text;
    }
    public function setText($text){
        $this->text = $text;
    }
}
?>