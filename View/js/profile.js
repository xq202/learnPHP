var listPost = document.querySelector(".listPost");
var http = new XMLHttpRequest();
checkLoad = true;
var checkScroll = false;
function loadpost(){
    x = 0;
    http.open("GET",`Api/PostAPI?id=${id}&index=${index}`,true);
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