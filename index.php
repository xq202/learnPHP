<?php
session_start();
$urls = array();
if(!isset($_GET["url"])){
    require "./Controller/HomeController.php";
    exit();
}
$str = $_GET["url"];
$urls = explode("/", $str);
$controller = (isset($urls[0])) ? $urls[0] : "";
$controller = ucfirst(strtolower($controller));
$action = (isset($urls[1])) ? strtolower($urls[1]) : "";
// echo "<base href=\"{$baseURL}\">";
$autoloadPath = __DIR__ . '/';
spl_autoload_register(function ($class) use ($autoloadPath) {
    // Chuyển tên class thành đường dẫn đến file
    $file = $autoloadPath.substr($class,strlen($class),0).str_replace('\\', '/', $class) . '.php';

    // Kiểm tra xem file có tồn tại không và require nếu có
    if (file_exists($file)) {
        require $file;
    }
    else{
        echo $file;
    }
});
require './Controller/'.$controller.'Controller.php';