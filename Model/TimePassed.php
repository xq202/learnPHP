<?php
namespace Model;
use DateTime;
class TimePassed{
    public function timePost($targetTime){
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $currentTime = new DateTime('now');
        $targetTime = new DateTime($targetTime);
        $time = $currentTime->diff($targetTime);
        $listTime = [$time->d.' ngay',$time->h.' gio',$time->i.' phut',$time->s.' giay'];
        $passed = null;
        if($time->days>7){
            $passed = $targetTime->format('d').' thang '.$targetTime->format('m').', '.$targetTime->format('Y');
        }
        else
        foreach($listTime as $t){
            if($t[0]!=0){
                $passed = $t;
                break;
            }
        }
        return $passed;
    }
    public function timeComment(){

    }
}