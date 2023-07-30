<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment</title>
    <link rel="stylesheet" href="./View/css/post.css">
    <link rel="stylesheet" href="./View/css/comment.css">
    <script>
        var idUser = <?=$idUser?>;
        var idPost = <?=$idPost?>;
        var checkLike = <?=$checkLike?>;
    </script>
</head>
<body>
    <div class="background" style="opacity: 0.4; height: 100%;"></div>
    <div class="content">
        <button class="closeBt">X</button>
        <div class="post">
            <div class="user_of_post">
                <div class="small_avatar">
                    <a href=""><img src="<?=$srcAvatarPhoto?>" alt=""></a>
                </div>
                <div class="name_and_date">
                <span style="font-size: 15px; font-weight: bold;"><?=$userName?></span><br>
                <span><?=$passed?></span>
                </div>
            </div>
            <div class="post_content">
                <div class="text">
                    <p><?=$text?></p>
                </div>
                <div class="list_media">
                    <?=$media?>
                </div>
            </div>
            <div class="info_of_post">
                <span><span class="countLike_<?=$idPost?>"><?=$countLike?></span> like</span>
                <span class="comment"><?=$countComment?> binh luan</span>
                <span class="share"><?=$countShare?> chia se</span>
            </div>
            <div class="action_with_post">
                <button class="action_bt" style="background-color: <?=$liked?>;">like</button><button class="action_bt">binh luan</button><button class="action_bt">chia se</button>
            </div>
        </div>
        <div class="listComment">
            
        </div>
        <form action="" class="formComment">
            <div class="small_avatar">
                <a href=""><img src="<?=$srcAvatarPhoto?>" alt=""></a>
            </div>
            <input type="text" class="inputText" placeholder="Viet binh luan">
            <input type="submit" value=">" class="submit">
        </form>
    </div>
    <script src="./View/js/comment.js"></script>
</body>
</html>