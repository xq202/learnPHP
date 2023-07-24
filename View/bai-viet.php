<style>
    .small_avatar img{
        width: 40px;
        height: 40px;
        border-radius: 40px;
        border: 2px solid while;
    }
    .addPost{
        display: flex;
    }
    .input_text input{
        height: 40px;
        width: 400px;
        margin-left: 20px;
        border-radius: 10px;
        transform-style: none;
        text-align: start;
        
    }
</style>
<div class="addPost">
    <div class="small_avatar">
        <a href=""><img src="<?=$srcAvatarPhoto?>" alt=""></a>
    </div>
    <div class="input_text">
        <input type="submit" value="Bạn đang nghĩ gì?" disabled="true">
    </div>
</div>