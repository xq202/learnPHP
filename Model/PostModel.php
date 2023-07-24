<?php
class PostModel{
    public function getPostById($id){
        include "./DAO/Database.php";
        $conn = new Conn();
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
}
class Post{
    private $text;
    public function getText(){
        return $this->getText();
    }
    public function setText($text){
        $this->text = $text;
    }
}
?>