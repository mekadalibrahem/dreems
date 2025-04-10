<?php 

namespace App\Core\Helper;


class Session {
    

    public static function  save($key , $value){
        $_SESSION[$key] = $value;
    }

    public static function delete($key){
        
    }
}

