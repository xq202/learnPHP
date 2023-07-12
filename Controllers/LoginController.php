<?php
class LoginController{
    public function __construct()
    {
        
    }
    public function Login(){
        require "./Model/LoginModel.php";
        if(!isset($_SESSION["login"])) $_SESSION["login"] = 0;
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
            header("location: Home");
            exit();
        }
        if($_SESSION["login"]==0){
            require "./View/login.php";
            $_SESSION["login"]+=1;
            exit();
        }
        $loginReturn = $loginModel->login();
        if($mess==1){
            if($loginReturn==1){
                $mess0 = "Đăng nhập thành công!";
                $password = $_POST["password"];
                require "./View/login.php";
                $_SESSION["logged"] = 1;
                $_SESSION["account"] = base64_encode($username);
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
    public function RegisterAPI(){
        require "./Model/LoginModel.php";
        $register = new LoginModel();
        $result = $register->checkRegister();
        // echo "run";
        if($result==1){
            $res = $register->register();
            if($res==0){
                echo "0:Tài khoản đã tồn tại";
                exit();
            }
            else
            echo "1:Đăng ký thành công!";
            $_SESSION["account"] = base64_encode($_POST["username"]);
            $_SESSION["logged"] = 1;
            exit();
        }
        else{
            echo '0:'.$result;
        }
    }
}
$view = new LoginController();
if($action == "quen-mat-khau"){
    $view->QuenMatKhau();
}
elseif($action=="RegisterAPI"){
    $view->RegisterAPI();
}
else{
    $view->Login();
}
?>