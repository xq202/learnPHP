<?php
namespace Model;

use DAO\ConnDAO;

class TagModel{
    private $conn;
    public function __construct()
    {
        $DAO = new ConnDAO();
        $this->conn = $DAO->connect();
    }
    public function getListIdUserTagByTypeAndId($type,$id){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("select * from tag where type = ? and id_type = ?");
        $stmt->bind_param("ss",$type,$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $listIdTag = [];
        if($result){
            while($row = $result->fetch_assoc()){
                $listIdTag[] = $row['id_user'];
            }
            return $listIdTag;
        }
        else{
            echo $stmt->error;
        }
    }
}