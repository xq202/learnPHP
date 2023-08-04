<base href="/learnPHP/">
<link rel="stylesheet" href="./View/css/post.css">
<?php
    if(base64_decode($_SESSION['id'])!=$id){
        $hiddenPost = 'display:none;';
    }
    else{
        $hiddenPost = '';
    }
?>
<div class="addPost" style="<?=$hiddenPost?>">
    <div class="small_avatar">
        <a href=""><img src="<?=$srcAvatarPhoto?>" alt=""></a>
    </div>
    <div class="input_text">
        <input type="submit" value="Bạn đang nghĩ gì?" readonly>
    </div>
</div>
<div class="new_post">
    <p>bai viet moi hon</p>
</div>
<div class="listPost">
    
</div>