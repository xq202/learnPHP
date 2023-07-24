<?php
echo base64_decode($_SESSION["id"]);
?>
<form action="" method="post">
    <input type="submit" value="logout" name="logout">
</form>
<?php
if(isset($_POST["logout"])){
    session_destroy();
    header("location: Login");
}