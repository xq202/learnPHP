<?php 
session_start(); 
if(!isset($_SESSION["username_error"])) $_SESSION["username_error"] = 0;
if(!isset($_SESSION["password_error"])) $_SESSION["password_error"] = 0;
// echo $_SESSION["username_error"].'<br>'.$_SESSION["password_error"];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập FakeBook</title>
    <link rel="icon" href="../Data/Photo/icon.ico">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="content">
        <div class="logo_content">
            <div class="logo">FAKEBOOK</div>
            <div class="text_under_logo">
                <p>Facebook giúp bạn kết nối và chia sẻ với mọi người trong cuộc sống của bạn.</p>
            </div>
        </div>
        <div class="login_content">
            <div class="login_form">
                <form action="login.php" id="login_form" method="post">
                    <input type="text" placeholder="Tài khoản" name="username">
                    <?php
                    if($_SESSION["username_error"]==1){
                        echo "Tài khoản không tồn tại<br>";
                    }
                    ?>
                    <input type="password" placeholder="Mật khẩu" name="password">
                    <?php
                    if($_SESSION["password_error"]==1){
                        echo "Mật khẩu sai<br>";
                    }
                    ?>
                    <input type="submit" value="Đăng nhập" style="background-color: #1877f2;border: none;color: white" name="login">
                    <a class="quenmatkhau" href="quen_mat_khau.php">Quên mật khẩu?</a>
                </form>
            </div>
            <button class="bt_register">Tạo tài khoản mới</button>
        </div>
    </div>
</body>
</html>
<?php
// include("../Model/Encrypt.php");
// $encrypt = new Encrypt;
// echo base64_encode($encrypt->encrypt(""));
// $iv = random_bytes(16);
// echo base64_encode($iv);
include("../Controller/LoginController.php");
if(isset($_POST["login"])){
    $check = login($_POST["username"], $_POST["password"]);
    if($check==1){
        $_SESSION["account"] = base64_encode($_POST["username"]);
        header("location: Home.php");
    }
    elseif ($check==0) {
        $_SESSION["username_error"]=1;
        $_SESSION["password_error"]=0;
        header("location: login.php");
    }
    else{
        $_SESSION["username_error"]=0;
        $_SESSION["password_error"]=1;
        header("location: login.php");
    }
}
?>