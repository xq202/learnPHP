<?php
session_start();
$baseURL = "/learnPHP/";
$urls = array();
if(!isset($_GET["url"])){
    require "./Controllers/HomeController.php";
    exit();
}
$str = $_GET["url"];
$urls = explode("/", $str);
$controller = (isset($urls[0])) ? $urls[0] : "";
$controller = ucfirst(strtolower($controller));
$action = (isset($urls[1])) ? strtolower($urls[1]) : "";
echo "<base href=\"{$baseURL}\">";
require './Controllers/'.$controller.'Controller.php';