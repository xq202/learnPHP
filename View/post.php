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
<div class="backgroundAddPost"></div>
<div class="addPostContent">
    <div class="addPostTitle">Tao bai viet</div>
    <div class="addPostBody">
        <form class="addPostForm">
            <input type="text" placeholder="ban dang nghi gi" class="inputTextAddPost">
            <input type="file"  id="addFile" style="display: none;">
            <label for="addFile" class="addFile">anh, video</label>
            <video src="" alt="" class="view" width="50%" height="50%" controls></video>
            <input type="submit" value="dang" id="addPostBt">
            <label for="addPostBt" class="addPostBt"></label>
        </form>
    </div>
</div>