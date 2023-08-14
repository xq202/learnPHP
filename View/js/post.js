document.querySelector('.addPost .input_text').onclick = function(){
    document.body.style.overflow = 'hidden';
    document.querySelector('.backgroundAddPost').style.display = 'block';
    document.querySelector('.addPostContent').style.display = 'block';   
}
document.querySelector('.backgroundAddPost').onclick = function(){
    document.querySelector('.backgroundAddPost').style.display = 'none';
    document.querySelector('.addPostContent').style.display = 'none';
    document.body.style.overflow = 'auto';
}
var addFile = document.querySelector('#addFile');
var addPostForm = document.querySelector('.addPostForm');
var listFile = [];
addFile.addEventListener('change', function(e){
    let files = addFile.files;
    for(let i=0;i<files.length;i++){
        if(files[i]){
            listFile.push(files[i]);
            let reader = new FileReader();
            reader.onload = function(r){
                document.querySelector('.viewPhoto').src = r.target.result;
            }
            reader.readAsDataURL(files[i]);
        }
    }
})
addPostForm.addEventListener('submit', function(event){
    event.preventDefault();
    listFile.forEach(i=>{
        alert(i.name);
    });
});