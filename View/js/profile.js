var listPost = document.querySelector(".listPost");
var http = new XMLHttpRequest();
checkLoad = true;
window.addEventListener("scroll", function(){
    if(checkLoad && window.innerHeight + window.scrollY >= document.body.scrollHeight){
        x = 0;
        http.onload = function(){
            if(http.status === 200){
                // alert('load');
                var listData = JSON.parse(http.responseText);
                x = listData.length;
                listData.forEach(element => {
                    listPost.innerHTML += element;
                });
            }
        }
        http.open("GET",`Api/PostAPI?id=${id}&index=${index}`,true);
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
});
var splitUrl = url.split("/");
var luaChon = document.querySelectorAll(".lua_chon");
var listLuaChon = ['bai-viet','gioi-thieu','ban-be','anh','video'];
// alert('/learnPHP/'+listLuaChon[0]+'/'+splitUrl[splitUrl.length-1]);
for(let i=0;i<5;i++){
    luaChon[i].addEventListener('click', function(){
        window.location.replace('/learnPHP/profile/'+listLuaChon[i]+'/'+splitUrl[splitUrl.length-1])
    })
}