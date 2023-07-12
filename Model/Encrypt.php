<?php
class Encrypt{
    public function __construct(){

    }
    private $key = "quangtx";
    private $iv = "uipH0fgL+BZiIwjb7qVKFA==";
    public function encrypt($password){
        $pass = openssl_encrypt($password,'AES-256-CBC',$this->key,OPENSSL_RAW_DATA,base64_decode($this->iv));
        return base64_encode($pass);
    }
    public function decrypt($password){
        $pass = openssl_decrypt($password,'AES-256-CBC',$this->key,OPENSSL_RAW_DATA,base64_decode($this->iv));
        return $pass;
    }
}
// $e = new Encrypt();
// echo base64_encode($e->encrypt("admin"));
?>