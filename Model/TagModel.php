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
    public function addTagByTypeAndIdType($type, $idType, $idUser){
        $stmt = $this->conn->stmt_init();
        $stmt->prepare("insert into tag (type, id_type, id_user) values (?, ?, ?)");
        $stmt->bind_param("sss",$type,$idType,$idUser);
        $stmt->execute();
        $result = $stmt->affected_rows;
        if($result>0){
            return 1;
        }
        else{
            echo $stmt->error;
        }
    }
}