var listPost = document.querySelector(".listPost");
var http = new XMLHttpRequest();
http.onload = function(){
    if(http.status === 200){
        // alert('load');
        var listData = JSON.parse(http.responseText);
        var list = "";
        listData.forEach(element => {
            listPost.innerHTML += element;
        });
    }
}
http.open("GET",`Api/PostAPI?id=${id}`,true);
http.send();