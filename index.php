<?php
// print_r($_GET);
// $__home__ = $_SERVER["DOCUMENT_ROOT"].'/learnPHP';
// echo $__home__;
// foreach($_SERVER as $a=>$b){
//     echo $a.': '.$b.'<br>';
// }

session_start();
$urls = array();
$str = $_GET["url"];
$urls = explode("/", $str);
// print_r($urls);
// echo "<br>";
$controller = (isset($urls[0])) ? $urls[0] : "";
$controller = ucfirst($controller);
$action = (isset($urls[1])) ? $urls[1] : "";
require './Controllers/'.$controller.'Controller.php';