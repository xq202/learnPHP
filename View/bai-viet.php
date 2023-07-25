<style>
    .small_avatar img{
        width: 40px;
        height: 40px;
        border-radius: 40px;
        border: 2px solid while;
    }
    .addPost{
        display: flex;
        background-color: aliceblue;
        border-radius: 10px;
        justify-content: center;
        /* position: absolute; */
        /* top: 20px; */
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .input_text input{
        height: 40px;
        width: 500px;
        margin-left: 20px;
        border-radius: 10px;
        transform-style: none;
        text-align: start;
        border-color: gray;
        border-style: solid;
        color: gray;
    }
    .post{
        margin-top: 10px;
        display: block;
        border-radius: 10px;
        background-color: aliceblue;
        box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.5);
        /* padding-bottom: 1px; */
    }
    .user_of_post{
        display: flex;
        /* border-bottom: 1px solid gray; */
        padding-bottom: 10px;
        margin-bottom: 10px;
    }
    .user_of_post .small_avatar{
        margin-top: 5px;
        margin-left: 5px;
    }
    .name_and_date{
        margin-left: 10px;
    }
    .post_content{
        width: 99%;
        margin-left: auto;
        margin-right: auto;
    }
    .action_with_post{
        display: flex;
    }
    .action_with_post button{
        flex: 1;
        border: 1px solid gray;
        border-radius: 5pc;
    }
</style>
<div class="addPost">
    <div class="small_avatar">
        <a href=""><img src="<?=$srcAvatarPhoto?>" alt=""></a>
    </div>
    <div class="input_text">
        <input type="submit" value="Bạn đang nghĩ gì?" readonly>
    </div>
</div>
<?php
for($i=0;$i<10;$i++){ ?>
<div class="post">
    <div class="user_of_post">
        <div class="small_avatar">
            <a href=""><img src="<?=$srcAvatarPhoto?>" alt=""></a>
        </div>
        <div class="name_and_date">
        <span style="font-size: 15px; font-weight: bold;"><?=$name ?></span><br>
        <span>1 ngay</span>
        </div>
    </div>
    <div class="post_content">
        <div class="text">
            hello
        </div>
        <div class="media"></div>
    </div>
    <div class="action_with_post">
        <button>like</button><button>binh luan</button><button>chia se</button>
    </div>
</div>
<?php }?>