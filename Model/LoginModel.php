<?php
require "./DAO/Database.php";
require "./Model/Encrypt.php";
class LoginModel{
    private $username = "";
    private $password = "";
    private $repassword = "";
    public function __construct()
    {
        $this->username = isset($_POST["username"]) ? filter_input(INPUT_POST,"username",FILTER_SANITIZE_SPECIAL_CHARS) : "";
        $this->password = isset($_POST["password"]) ? filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS) : "";
        $this->repassword = isset($_POST["repassword"]) ? filter_input(INPUT_POST,"repassword",FILTER_SANITIZE_SPECIAL_CHARS) : "";
        // echo $this->username.'<br>';
        // echo $this->password.'<br>';
    }
    public function checkLogin(){
        $username = $this->username;
        $password = $this->password;
        if(trim($username)==""){
            return 2;
        }
        elseif($password==""){
            return 3;
        }
        else{
             return 1;
        }
    }
    public function login(){
        $username = $this->username;
        $password = $this->password;
        $conn = new Conn();
        $conn = $conn->connect();
        $stmt = $conn->stmt_init();
        $stmt->prepare("select * from account where username = ?");
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if(isset($row)){
            $encrypt = new Encrypt();
            $pass = $encrypt->encrypt($password);
            // echo $pass.'<br>'.$row["password"];
            if($pass===$row["password"]){
                $id = null;
                $stmt->prepare("select id from user where id_acc = ?");
                $stmt->bind_param("s",$row['id']);
                $stmt->execute();
                $id = $stmt->get_result()->fetch_assoc()['id'];
                return "1:{$id}";
            }
            else return '2';
        }
        else{
            return '0';
        }
        $conn->close();
    }
    public function checkRegister(){
        $username = $this->username;
        $password = $this->password;
        $repassword = $this->repassword;
        if(trim($username)==""){
            return "Hãy nhập tài khoản";
        }
        elseif($password=="" || $repassword==""){
            return "Hãy nhập mật khẩu";
        }
        else{
            $lib_user = "/^[a-zA-Z\d]{5,}$/";
            if(!preg_match($lib_user,$username)){
                return "Tài khoản phải có ít nhất 5 ký tự gồm có chữ cái hoặc số. Không có ký tự đặc biệt!";
            }
            if($password!=$repassword){
                return "Mật khẩu không khớp nhau";
            }
            $lib_pass = "/^[a-zA-Z\d!@#$%^&*]{5,}$/";
            if(!preg_match($lib_pass,$password)){
                return "Mật khẩu phải có ít nhất 5 ký tự có thể gồm chữ cái, số, ký tự đặc biệt.";
            }
            return 1;
        }
    }
    public function register(){
        $username = $this->username;
        $password = $this->password;
        $conn = new Conn();
        $conn = $conn->connect();
        $sql = "select username from account where username = ?";
        $stmt = $conn->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result = $stmt->get_result();
        $ress = $result->fetch_all();
        if(count($ress)>0){
            return 0;
        }
        else{
            $encrypt = new Encrypt();
            $pass_save = $encrypt->encrypt($password);
            $stmt->prepare("insert into account (username, password) values (?, ?)");
            $stmt->bind_param("ss",$username,$pass_save);
            $stmt->execute();
            $id = $stmt->insert_id;
            $stmt->prepare("insert into user (id_acc) values (?)");
            $stmt->bind_param("s",$id);
            $stmt->execute();
            $id = $stmt->insert_id;
            $stmt->close();
            return $id;
        }
    }
}
?>