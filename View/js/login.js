var bt_close = document.querySelector('.bt_close');
var bt_register = document.querySelector(".bt_register_bt1");
bt_close.onclick = () => {
  document.querySelector('.content_register').style.display = 'none';
}
bt_register.onclick = () => {
  var content = document.querySelector('.content_register');
  content.style.display = 'block';
  content.style.animation = "DamDan 0.6s 1";
}
// var bt_login = document.querySelector(".bt_login");
// bt_login.onclick = function(){
//   if(bt_login.disabled){
//     return;
//   }
//   else{
//     bt_login.disabled = true;
//     setTimeout(function(){
//       bt_login.disabled = false;
//     },2000)
//   }
// }
var loginForm = document.getElementById("login_form");
loginForm.addEventListener("submit",function(e){
  // e.preventDefault();
  bt_login = document.querySelector(".bt_login");
  bt_login.disabled = true;
  setTimeout(function(){
    bt_login.disabled = false;
  },2000)
})
function submitFormRegister(event) {
  event.preventDefault();
  
  let registerForm = document.querySelector('.register_form');
  let formData = new FormData(registerForm);
  let req = new XMLHttpRequest();
  
  var user = document.querySelector(".username_input").value;
  var pass = document.querySelector(".password_input").value;
  var repass = document.querySelector(".repassword_input").value;
  
  formData.append("username", user);
  formData.append("password", pass);
  formData.append("repassword", repass);
  
  req.open("POST", "Api/RegisterAPI", true);
  
  req.onload = function() {
    if (req.status == 200) {
      // alert(req.responseText);
      var arr = req.responseText.split(":");
      document.querySelector(".mess").innerText = arr[1];
      if(arr[0]=='1'){
        setTimeout(function(){
          window.location.href = "/learnPHP/Home";
        },2000);
      }
    } else {
      alert(req.onerror());
    }
  }
  req.send(formData);
}