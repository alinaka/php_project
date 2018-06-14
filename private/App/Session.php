<?php
namespace alina\project\App;

class Session
{
    public function set_session_var($key, $val){
        $_SESSION[$key] = $val;
    }
    
    public function get_session_var($key){
        return $_SESSION[$key];
    }
    
    public function remove_session_var($key){
        unset($_SESSION[$key]);
    }
    
    public function is_session_var($key){
        return isset($_SESSION[$key]);
    }
    
    public function stop_session(){
        $_SESSION = array();
    }
}



