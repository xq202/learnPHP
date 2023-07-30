var listPost = document.querySelector(".listPost");
var http = new XMLHttpRequest();
checkLoad = true;
var checkScroll = false;
function loadpost(){
    x = 0;
    http.open("GET",`Api/PostAPI?id=${id}&index=${index}`,true);
    http.onload = function(){
        if(http.status === 200){
            // alert(idUser);
            var listData = JSON.parse(http.responseText);
            x = listData.length;
            var listIdPost = []
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
                        <span class="comment">${dataPost.countComment} binh luan</span>
                        <span class="share">${dataPost.countShare} chia se</span>
                    </div>
                    <div class="action_with_post">
                        <button class="action_bt" style="background-color: ${liked}">like</button><button class="action_bt">binh luan</button><button class="action_bt">chia se</button>
                    </div>
                </div>
                `;
            listIdPost.push(dataPost.idPost);
            })
        }
        var bt = document.querySelectorAll(".action_bt");
        for(let i=0;i<bt.length;i++){
            bt[i].onclick = function(){
                if(idUser==""){
                    alert('vui long dang nhap');
                    window.location.href = '/learnPHP/Login';
                    return;
                }
            }
            //button like
            if(i%3==0){
                bt[i].addEventListener('click',function(){
                    // alert('click');
                    var http1 = new XMLHttpRequest();
                    http1.open('GET',`Api/likeapi?idUser=${idUser}&idPost=${listIdPost[i/3]}`)
                    http1.onload = function(){
                        let res = http1.responseText;
                        var likeBt = document.querySelector('.countLike_'+listIdPost[i/3]);
                        let s = likeBt.innerText;
                        s = parseInt(s);
                        if(res==1){
                            s+=1;
                            bt[i].style = "background-color: aqua;";
                        }
                        else{
                            s-=1;
                            bt[i].style = "background-color: buttonface;";
                        }
                        likeBt.innerText = s;
                    }
                    http1.send();
                    // alert(`Api/likeapi?idUser=${idUser}&idPost=${listIdPost[i/3]}`);
                })
            }
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
    if(x<20) checkLoad = false;
    else{
        index+=x;
    }
    if(index>=100){
        listPost.innerHTML = "";
        this.document.querySelector(".new_post").display = "block";
    }
}
loadpost();
// alert('hello');
window.addEventListener("scroll", function(){
    if(checkLoad && window.innerHeight + window.scrollY >= document.body.scrollHeight){
        loadpost();
    }
});
var splitUrl = url.split("/");
var luaChon = document.querySelectorAll(".lua_chon");
var listLuaChon = ['bai-viet','gioi-thieu','ban-be','anh','video'];
// alert('/learnPHP/'+listLuaChon[0]+'/'+splitUrl[splitUrl.length-1]);
for(let i=0;i<5;i++){
    luaChon[i].addEventListener('click', function(){
        window.location.replace('/learnPHP/profile/'+listLuaChon[i]+'/'+splitUrl[splitUrl.length-1]);
        localStorage.setItem('click','2');
    })
}