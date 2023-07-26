<?php
namespace Controller;
use Model\LoginModel;
class LoginController{
    public function __construct()
    {
        echo "<base href=\"/learnPHP/\">";
    }
    public function Login(){
        // require "./Model/LoginModel.php";
        $loginModel = new LoginModel();
        $mess = $loginModel->checkLogin();
        $mess0 = "";
        $mess1 = "";
        $mess2 = "";
        $password = "";
        if(!isset($_POST["username"])) $username = "";
        else $username = $_POST["username"];
        if(isset($_SESSION["logged"])){
            sleep(2);
            header("location: /learnPHP/Home");
            exit();
        }
        if(!isset($_POST["username"])){
            require "./View/login.php";
            exit();
        }
        $loginReturn = $loginModel->login();
        if($mess==1){
            if($loginReturn[0]==1){
                $mess0 = "Đăng nhập thành công!";
                $password = $_POST["password"];
                require "./View/login.php";
                $_SESSION["logged"] = 1;
                $_SESSION["id"] = base64_encode(substr($loginReturn,2));
                header("refresh:0");
                exit();
            }
            elseif($loginReturn==0){
                $mess1 = "Tài khoản không tồn tại";
                $mess2 = "";
            }
            else{
                $mess2 = "Mật khẩu sai";
                $mess1 = "";
            }
        }
        elseif($mess==2){
            $mess1 = "Hãy nhập tài khoản";
            $mess2 = "";
        }
        else{
            $mess1 = "";
            $mess2 = "Hãy nhập mật khẩu";
        }
        require "./View/login.php";
    }
    public function QuenMatKhau(){
        require "./View/quen_mat_khau.php";
    }
}
$view = new LoginController();
// echo $action;
if($action == "quen-mat-khau"){
    $view->QuenMatKhau();
}
else{
    $view->Login();
}
?>