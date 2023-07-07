<?php
session_start();
echo base64_decode($_SESSION["account"]);
?>