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
    if(i==0){
        bt[i].addEventListener('click',function(){
            // alert('click');
            var http = new XMLHttpRequest();
            http.open('GET',`Api/likeapi?idUser=${idUser}&idPost=${idPost}`)
            http.onload = function(){
                let res = http.responseText;
                var likeBt = document.querySelector('.countLike_'+idPost);
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
            http.send();
            // alert(`Api/likeapi?idUser=${idUser}&idPost=${idUser}`);
        })
    }
}