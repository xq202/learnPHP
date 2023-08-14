<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$name?> | Fakebook</title>
    <link rel="icon" href="./Data/Photo/icon.ico">
    <link rel="stylesheet" href="./View/css/profile.css">
    <script>
        var id = <?=$id?>;
        var index = 0;
        var url = '<?=$url?>';
        var idUser = "<?=base64_decode($_SESSION['id'])?>";
        var srcAvatar = '<?=$srcAvatarView?>';
    </script>
</head>
<body class="body1">
    <div class="background1">
        <div class="phan1">
            <div class="anh-bia"><a href=""><img src="<?=$srcCoverPhoto?>" alt="anh bia"></a></div>
            <div class="thong-tin-co-ban">
                <div class="anh-dai-dien"><a href=""><img src="<?=$srcAvatarPhoto?>" alt="anh dai dien"></a></div>
                <div class="ben-phai-anh-dai-dien">
                    <div class="ten-va-so-ban-be">
                        <span style="font-size: 30px; font-weight: bold;"><?=$name ?></span><br>
                        <span>x ban be</span><br>
                        <span>x ban chung</span>
                    </div>
                    <div class="tuy-chon">
                        <button class="bt-tuy-chon">ban be</button>
                        <button class="bt-nhan-tin">nhan tin</button>
                    </div>
                </div>
            </div>
            <div class="menu-trang-ca-nhan">
                    <ul>
                        <li class="lua_chon">bai viet</li>
                        <li class="lua_chon">gioi thieu</li>
                        <li class="lua_chon">ban be</li>
                        <li class="lua_chon">anh</li>
                        <li class="lua_chon">video</li>
                    </ul>
                </div>
        </div>
    </div>
    <div class="background2">
        <div class="phan2">
            <?php
            include $page;
            ?>
        </div>
    </div>
</body>
</html>
<link rel="stylesheet" href="./View/css/comment.css">
<div class="backgroundFrame"></div>
<div class="commentFrame"></div>
<script src="./View/js/comment.js"></script>
<script src="./View/js/profile.js"></script>
<script src="./View/js/post.js"></script>