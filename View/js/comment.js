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

// cai dat cac hanh dong khi nhan like
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
// dat hanh dong submit form binh luan chinh
function setActionForm(idPost){
    let formComment = document.querySelector('.formComment');
    formComment.onsubmit = function(event){
        event.preventDefault();
        let req = new XMLHttpRequest();
        let data = new FormData();
        let inputText = document.querySelector('#inputText');
        data.append('idPost',idPost);
        data.append('idUser',idUser);
        data.append('text',inputText.value);
        req.open('POST','api/addcommentapi',true);
        req.onload = function(){
            loadComment(idPost);
            setTimeout(function(){
                document.querySelector('.commentFrame').scrollTo(0,100);
            },1000);
        }
        req.send(data);
        increaseCountComment(idPost);
        document.querySelector('.listComment').innerHTML = '';
        inputText.value = '';
    }
}
//tai them comment
function loadComment(idPost){
    var listComment = document.querySelector('.listComment');
    var http2 = new XMLHttpRequest();
    http2.open("GET",`api/CommentAPI?idPost=${idPost}&index=${index}`,true);
    http2.onload = function(){
        var listUserComment = [];
        var listData = JSON.parse(http2.responseText);
        listData.forEach(element => {
            var listReply = element.listReply;
            var listReplyHtml = '';
            var listUserReplyComment = [];
            let countReply = 0;
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
                    <div class="commentContent">
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
                listUserReplyComment[reply.id] = reply.userName;
                countReply+=1;
            });
            let style = "block";
            if(countReply==0){
                style = 'none';
            }
            listComment.innerHTML += `
            <div class="comment">
                <div class="small_avatar">
                    <a href=""><img src="${element.srcAvatar}" alt=""></a>
                </div>
                <div class="right_avatar">
                    <div class="commentContent">
                        <h3>${element.userName}</h3>
                        <p>${element.text}</span></p>
                        <span class="time">${element.passed}</span>
                        <div class="actionComment">
                            <button class="likeCommentBt_${element.id}">thich</button>
                            <button class="replyCommentBt_${element.id}">tra loi</button>
                        </div>
                    </div>
                    <div class="replyContent">
                        <span class="countReply_${element.id}" style="display:${style};">${countReply} phan hoi</span>
                        <div class="listReply_${element.id}" style="display:none;">
                            ${listReplyHtml}
                        </div>
                        <form action="" class="formComment" id="formComment_${element.id}" style="position: relative; margin-top: 6px">
                            <div class="small_avatar">
                                <a href=""><img src="${srcAvatar}" alt=""></a>
                            </div>
                            <input type="text" class="inputText" id="inputText_${element.id}" placeholder="" autocomplete="off">
                            <input type="submit" value=">" class="submit">
                        </form>
                    </div>
                </div>
            </div>
            `;
            listUserReplyComment[element.id] = element.userName;
            listUserComment[element.id] = listUserReplyComment;
            listUserReplyComment = [];
            // alert(countReplyBt.innerText);
        });
        listData.forEach(element => {
            let countReplyBt = document.querySelector(`.countReply_${element.id}`);
            countReplyBt.onclick = function(){
                document.querySelector(`.listReply_${element.id}`).style.display = 'block';
                countReplyBt.style.display = 'none';
            }
        });
        for(let id1 in listUserComment){
            var idCommentRep = null;
            let formComment = document.querySelector('.content #formComment_'+id1);
            let inputText = document.querySelector('.comment #inputText_'+id1);
            for(let id2 in listUserComment[id1]){
                document.querySelector('.replyCommentBt_'+id2).onclick = function(){
                    formComment.style.display = 'flex';
                    inputText.placeholder = 'tra loi '+listUserComment[id1][id2];
                    idCommentRep = id2;
                    let countReply = document.querySelector('.countReply_'+id2);
                    countReply.style.display = 'none';
                    document.querySelector('.listReply_'+id1).style.display = 'block';
                    inputText.focus();
                }
            }
            // submit tra loi binh luan
            formComment.onsubmit = function(event){
                event.preventDefault();
                let text = inputText.value;
                if(text.trim()=='') return;
                formComment.style.display = 'none';
                let sendComment = new XMLHttpRequest();
                let data = new FormData();
                data.append('text',text);
                data.append('idUser',idUser);
                data.append('idCommentRep',idCommentRep);
                // alert('text: '+text+'. idUser: '+idUser+' idCommentRep: '+idCommentRep);
                sendComment.open("POST",`api/addreplycommentapi`,true);
                sendComment.onload = function(){
                    // alert(sendComment.responseText);
                    let listData = JSON.parse(sendComment.responseText);
                    let listReply = document.querySelector('.listReply_'+id1);
                    var listUserNameTag = listData.listUserNameTag;
                    var listTag2 = '';
                    for(let idUser in listUserNameTag){
                        listTag2 += `<a href="/learnPHP/profile?id=${idUser}">${listUserNameTag[idUser]}</a> `;
                    }
                    listReply.innerHTML += `
                    <div class="comment">
                        <div class="small_avatar">
                            <a href=""><img src="${listData.srcAvatar}" alt=""></a>
                        </div>
                        <div class="commentContent">
                            <h3>${listData.userName}</h3>
                            <p>${listTag2} ${listData.text}</p>
                            <span class="time">${listData.passed}</span>
                            <div class="actionComment">
                                <button class="likeCommentBt_${listData.id}">thich</button>
                                <button class="replyCommentBt_${listData.id}">tra loi</button>
                            </div>
                        </div>
                    </div>
                    `;
                    document.querySelector('.replyCommentBt_'+listData['id']).onclick = function(){
                        document.querySelector('.comment #inputText_'+id1).placeholder = 'tra loi '+listData.userName;
                        formComment.style.display = 'flex';
                        document.querySelector('.comment #inputText_'+id1).focus();
                        idCommentRep = listData['id'];
                    }
                }
                idCommentRep = null;
                sendComment.send(data);
                increaseCountComment(idPost)
            }
        }
        settingBt(idPost);
    }
    http2.send();
}
// tang hien thi so binh luan
function increaseCountComment(idPost){
    document.querySelector('.inputText').value = '';
    let listCountComment = document.querySelectorAll('.countComment_'+idPost);
    listCountComment.forEach(countComment=>{
        let int = countComment.innerText;
        int = parseInt(int);
        countComment.innerText = (int+1)+' binh luan';
    })
}