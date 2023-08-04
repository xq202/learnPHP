var listPost = document.querySelector(".listPost");
var checkLoad = true;
function openCommentFrame(idPost){
    document.querySelector('.commentFrame').style.display = "block";
    document.querySelector('.backgroundFrame').style.display = 'block';
    document.querySelector('body').style.overflow = "hidden";
    var http1 = new XMLHttpRequest();
    http1.open("GET", `Comment?idPost=${idPost}`);
    http1.onload = function(){
        document.querySelector('.commentFrame').innerHTML = http1.responseText;
        loadComment(idPost);
        setActionForm(idPost);
    }
    http1.send();
}
function closeCommentFrame(){
    document.querySelector('.commentFrame').style.display = "none";
    document.querySelector('.backgroundFrame').style.display = 'none';
    document.querySelector('body').style.overflow = "scroll";
}
//post
var http = new XMLHttpRequest();
function loadpost(){
    x = 0;
    http.open("GET",`Api/PostAPI?id=${id}&index=${index}`,true);
    http.onload = function(){
        if(http.status === 200){
            // alert(idUser);
            var listData = JSON.parse(http.responseText);
            x = listData.length;
            var listIdPost = [];
            listData.forEach(dataPost =>{
                let liked = '';
                // alert(dataPost.checkLike);
                if(dataPost.checkLike==1){
                    liked = 'aqua';
                }
                listPost.innerHTML += 
                `<div class="post">
                    <div class="user_of_post">
                        <div class="small_avatar">
                            <a href=""><img src="${dataPost.srcAvatarPhoto}" alt=""></a>
                        </div>
                        <div class="name_and_date">
                        <span style="font-size: 15px; font-weight: bold;">${dataPost.userName}</span><br>
                        <span>${dataPost.passed}</span>
                        </div>
                    </div>
                    <div class="post_content">
                        <div class="text">
                            <p>${dataPost.text}</p>
                        </div>
                        <div class="list_media">
                            ${dataPost.media}
                        </div>
                    </div>
                    <div class="info_of_post">
                        <span><span class="countLike_${dataPost.idPost}">${dataPost.countLike}</span> like</span>
                        <span class="countComment_${dataPost.idPost}">${dataPost.countComment} binh luan</span>
                        <span class="countShare_${dataPost.idPost}">${dataPost.countShare} chia se</span>
                    </div>
                    <div class="action_with_post">
                        <button class="like_${dataPost.idPost}" style="background-color: ${liked}">like</button><button class="comment_${dataPost.idPost}">binh luan</button><button class="share_${dataPost.idPost}">chia se</button>
                    </div>
                </div>
                `;
                listIdPost.push(dataPost.idPost);
            });
            listIdPost.forEach(i => {
                let btLike = document.querySelector('.like_'+i);
                btLike.onclick = function(){
                    if(idUser==""){
                        alert('vui long dang nhap');
                        window.location.href = '/learnPHP/Login';
                        return;
                    }
                    //button like
                    var http1 = new XMLHttpRequest();
                    http1.open('GET',`Api/likeapi?idUser=${idUser}&idPost=${i}`)
                    // alert(listIdPost[parseInt(i/3)]);
                    http1.onload = function(){
                        let res = http1.responseText;
                        let countLike = document.querySelector('.countLike_'+i);
                        let s = countLike.innerText;
                        s = parseInt(s);
                        if(res==1){
                            s+=1;
                            btLike.style = "background-color: aqua;";
                        }
                        else{
                            s-=1;
                            btLike.style = "background-color: buttonface;";
                        }
                        countLike.innerText = s;
                    }
                    http1.send();
                }
                var btComment = document.querySelector('.comment_'+i);
                btComment.onclick = ()=>{
                    if(idUser==""){
                        alert('vui long dang nhap');
                        window.location.href = '/learnPHP/Login';
                        return;
                    }
                    openCommentFrame(i);
                }
            });
        }
    }
    http.onprogress = function(event){
        if(event.lengthComputable){
            if(event.loaded==event.total){
                if(localStorage.getItem('click')=='2'){
                    localStorage.clear();
                    setTimeout(function(){
                        window.scrollBy({
                            top: listPost.getBoundingClientRect().top - 140,
                            behavior: "smooth",
                            left: 0
                        })
                    },50);
                }
            }
        }
    }
    http.send();
    if(x<20){
        checkLoad = false;
        // alert('end');
    }
    else{
        index+=x;
    }
    if(index>=100){
        listPost.innerHTML = "";
        this.document.querySelector(".new_post").display = "block";
    }
}
var backgroundFrame = document.querySelector('.backgroundFrame');
backgroundFrame.addEventListener('click', function(){
    closeCommentFrame();
});
window.addEventListener("scroll", function(){
    if(checkLoad && window.innerHeight + window.scrollY >= document.body.scrollHeight){
        loadpost();
    }
});
loadpost();

//cac lua chon
idx = url.indexOf('?');
var valueGet = '';
if(idx){
    valueGet = url.substring(idx);
}
var luaChon = document.querySelectorAll(".lua_chon");
var listLuaChon = ['bai-viet','gioi-thieu','ban-be','anh','video'];
for(let i=0;i<5;i++){
    luaChon[i].addEventListener('click', function(){
        window.location.replace('/learnPHP/profile/' + listLuaChon[i] + '/' + valueGet);
        localStorage.setItem('click','2');
    })
}
