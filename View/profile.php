<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$name?> | Fakebook</title>
    <link rel="icon" href="./Data/Photo/icon.ico">
    <link rel="stylesheet" href="./View/css/profile.css">
    <script>
        var id = <?=$id?>;
    </script>
</head>
<body>
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
                        <li>bai viet</li>
                        <li>gioi thieu</li>
                        <li>ban be</li>
                        <li>anh</li>
                        <li>video</li>
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
<script src="./View/js/profile.js"></script>
</html>