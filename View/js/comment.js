function closeCommentFrame(){
    document.querySelector('.commentFrame').style.display = "none";
    document.querySelector('.backgroundFrame').style.display = 'none';
    document.querySelector('.body1').style.overflow = "scroll";
}
function openCommentFrame(){
    document.querySelector('.commentFrame').style.display = "block";
    document.querySelector('.backgroundFrame').style.display = 'block';
    document.querySelector('.body1').style.overflow = "hidden";
    var http1 = new XMLHttpRequest();
    http1.open("GET", `Comment?idUser=${idUser}&idPost=${idPost}`);
    http1.onload = function(){
        document.querySelector('.commentFrame').innerHTML = http1.responseText;
        loadComment(idPost);
    }
    http1.send();
}
function ok(){
    alert('ok');
}


function settingBt(idPost){
    var listLikeBt = document.querySelectorAll('.like_'+idPost);
    likeBt = listLikeBt[1];
    likeBt.onclick = function(){
        var http3 = new XMLHttpRequest();
        http3.open('GET',`Api/likeapi?idUser=${idUser}&idPost=${idPost}`);
        http3.onload = function(){
            let res = http3.responseText;
            var countLike = document.querySelectorAll('.countLike_'+idPost);
            var s = countLike[0].innerText;
            s = parseInt(s);
            if(res==1){
                s+=1;
                likeBt.style = "background-color: aqua;";
                listLikeBt[0].style = "background-color: aqua;";
            }
            else{
                s-=1;
                likeBt.style = "background-color: buttonface;";
                listLikeBt[0].style = "background-color: buttonface;";
            }
            countLike[1].innerText = s;
            countLike[0].innerText = s;
        }
        http3.send();
    }
}
function loadComment(idPost){
    var listComment = document.querySelector('.listComment');
    var http2 = new XMLHttpRequest();
    http2.open("GET",`api/CommentAPI?idPost=${idPost}&index=0`,true);
    http2.onload = function(){
        var listData = JSON.parse(http2.responseText);
        listData.forEach(element => {
            var listReply = element.listReply;
            var listReplyHtml = '';
            listReply.forEach(reply=>{
                var listUserNameTag = reply.listUserNameTag;
                var listTag2 = '';
                for(let idUser in listUserNameTag){
                    listTag2 += `<a href="/learnPHP/profile?id=${idUser}">${listUserNameTag[idUser]}</a> `;
                }
                listReplyHtml += `
                <div class="comment">
                    <div class="small_avatar">
                        <a href=""><img src="${reply.srcAvatar}" alt=""></a>
                    </div>
                    <div class="contentComment">
                        <h3>${reply.userName}</h3>
                        <p>${listTag2} ${reply.text}</p>
                        <span class="time">${reply.passed}</span>
                        <div class="actionComment">
                            <button class="likeCommentBt_${reply.id}">thich</button>
                            <button class="replyCommentBt_${reply.id}">tra loi</button>
                        </div>
                    </div>
                </div>
                `
            });
            listComment.innerHTML += `
            <div class="comment">
                <div class="small_avatar">
                    <a href=""><img src="${element.srcAvatar}" alt=""></a>
                </div>
                <div class="right_avatar">
                    <div class="contentComment">
                        <h3>${element.userName}</h3>
                        <p>${element.text}</span></p>
                        <span class="time">${element.passed}</span>
                        <div class="actionComment">
                            <button class="likeCommentBt_${element.id}">thich</button>
                            <button class="replyCommentBt_${element.id}">tra loi</button>
                        </div>
                    </div>
                    <div class="listReply">
                        ${listReplyHtml}
                        <form action="" class="formComment" style="position: relative; margin-top: 6px">
                            <div class="small_avatar">
                                <a href=""><img src="${element.srcAvatar}" alt=""></a>
                            </div>
                            <input type="text" class="inputText" placeholder="Tra loi ${element.userName}">
                            <input type="submit" value=">" class="submit">
                        </form>
                    </div>
                </div>
            </div>
            `
        });
        settingBt(idPost);
    }
    http2.send();
}