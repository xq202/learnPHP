<?php
class LoginController{
    public function __construct()
    {
        
    }
    public function Login(){
        require "./Model/LoginModel.php";
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
            $_SESSION["id"] = base64_encode($res);
            $_SESSION["logged"] = 1;
            exit();
        }
        else{
            echo '0:'.$result;
        }
    }
}
$view = new LoginController();
// echo $action;
if($action == "quen-mat-khau"){
    $view->QuenMatKhau();
}
elseif($action=="registerapi"){
    $view->RegisterAPI();
}
else{
    $view->Login();
}
?>