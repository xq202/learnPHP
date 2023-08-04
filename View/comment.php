<link rel="stylesheet" href="./View/css/post.css">
<link rel="stylesheet" href="./View/css/comment.css">
<div class="backgroundComment" style="height: 100%;">
<div class="content">
    <button class="closeBt" onclick="closeCommentFrame()">X</button>
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
            <span class="countComment_<?=$idPost?>"><?=$countComment?> binh luan</span>
            <span class="countShare_<?=$idPost?>"><?=$countShare?> chia se</span>
        </div>
        <div class="action_with_post">
            <button class="like_<?=$idPost?>" style="background-color: <?=$liked?>;">like</button><button class="comment_<?=$idPost?>">binh luan</button><button class="share_<?=$idPost?>">chia se</button>
        </div>
    </div>
    <div class="listComment">
        
    </div>
</div>
    <form class="formComment">
        <div class="small_avatar">
            <a href=""><img src="<?=$srcAvatarPhotoView?>" alt=""></a>
        </div>
        <input type="text" class="inputText" id="inputText" placeholder="Viet binh luan" autocomplete="off">
        <input type="submit" value=">" class="submit">
    </form>
</div>
<!-- <script src="./View/js/comment.js"></script> -->