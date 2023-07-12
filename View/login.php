<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập FakeBook</title>
    <link rel="icon" href="./Data/Photo/icon.ico">
    <link rel="stylesheet" href="./View/css/login.css">
</head>
<body>
    <div class="content">
        <div class="logo_content">
            <div class="logo">FAKEBOOK</div>
            <div class="text_under_logo">
                <p>Fakebook giúp bạn kết nối và chia sẻ với mọi người trong cuộc sống của bạn.</p>
            </div>
        </div>
        <div class="login_content">
            <div class="login_form">
                <form id="login_form" method="post" action="" onsubmit="submitFormLogin(e)">
                    <input class="inp" type="text" placeholder="Tài khoản" name="username" value="<?=$username?>">
                    <?php
                    echo "<p style = 'text-align: center;margin:0'>{$mess1}</p>";
                    ?>
                    <input class="inp" type="password" placeholder="Mật khẩu" name="password" value="<?=$password?>">
                    <?php
                    echo "<p style = 'text-align: center;margin:0'>{$mess2}</p>"
                    ?>
                    <input type="submit" value="Đăng nhập" style="background-color: #1877f2;border: none;color: white" class="bt_login" name="login">
                    <?php
                    echo "<p style = 'text-align: center;margin:0'>{$mess0}</p>";
                    ?>
                    <a class="quenmatkhau" href="Login/quen-mat-khau">Quên mật khẩu?</a>
                </form>
            </div>
            <button class="bt_register_bt1">Tạo tài khoản mới</button>
        </div>
    </div>
    <div class="content_register">
        <div class="background_register"></div>
        <div class="form_register">
            <button class="bt_close" >X</button>
            <h2 style="text-align: center; color: white">Đăng ký</h2>
            <form class="register_form" action="" method="post" onsubmit="submitFormRegister(event)">
                <input type="text" placeholder="Tài khoản" name="username" class="username_input">
                <input type="password" placeholder="Mật khẩu" name="password" class="password_input">
                <input type="password" placeholder="Nhập lại mật khẩu" name="repassword" class="repassword_input">
                <br>
                <input type="submit" value="Đăng ký" name="register" class="bt_register_bt2">
            </form>
            <p class="mess" style="text-align: center; margin-top:5px"></p>
        </div>
    </div>
</body>
<script src="./View/js/login.js"></script>
</html>