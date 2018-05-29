<?php
namespace alina\project\Models;

class AuthModel
{
    function check_data(){
        $post = $_POST;
        //валидация на JS
        //проверка на пустой post
        //return false если что пошло не так
        return $post;
    }

    function is_data_in_file($data, $filename){
        $str = file_get_contents($filename);
        $from_file = explode("\n", $str);
        
        foreach ($from_file as $val){
            $item = explode(",", $val);
            if ($data['login'] === $item[0]) {
                return true;
            }
        }
        return false;
    }

    function add_user($data, $filename){
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $str = "";
        foreach ($data as $val){
            $str .= $val . ",";
        }
        $str[strlen($str) - 1] = "\n";
        return file_put_contents($filename, $str, FILE_APPEND);
    }

    function check_password($data, $filename){
        $pwd = $data['password'];
        $str = file_get_contents($filename);
        $from_file = explode("\n", $str);
        
        foreach ($from_file as $val){
            $item = explode(",", $val);
            if (password_verify($pwd, $item[2])) {
                return true;
            }
        }
        return false;
    }
}