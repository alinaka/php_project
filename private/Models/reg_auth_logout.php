<?php

function check_data(){
    $post = $_POST;
    //валидация на JS
    //return false если что пошло не так
    return $post;
}

function reg_user(){
    $data = check_data() ? check_data() : false;
    
    if (is_data_in_file($data, '../private/Models/data.txt')){
        echo 'user exists';
        return;
    }
    if (!add_user($data, '../private/Models/data.txt')){
        echo 'not add';
        return;
    }
    echo 'add';
}

function is_data_in_file($data, $filename){
    $str = file_get_contents($filename);
    $from_file = explode(";", $str);
    
    foreach ($from_file as $val){
        $item = explode(",", $val);
        if ($data['login'] === $item[2]) {
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
    $str[strlen($str) - 1] = ";";
    return file_put_contents($filename, $str, FILE_APPEND);
}

function auth_user(){
    $data = check_data();
    if (!is_data_in_file($data, '../private/Models/data.txt')){
        echo 'логин';
        //ошибка в логине
        return;
    }
    if (!check_password($data, '../private/Models/data.txt')){
        echo 'пароль';
        //ошибка в пароле
        return;
    }
    session_start();
    $_SESSION['login'] = $data['login'];
    if($data['remember'] == 'on'){
        setcookie('login', $data['login'], time() + 3600 * 24 * 180);
        setcookie('pwd', password_hash($data['password'], PASSWORD_DEFAULT), time()+3600 * 24 * 180);
    }
}

function check_password($data, $filename){
    $pwd = $data['password'];
    $str = file_get_contents($filename);
    $from_file = explode(";", $str);
    
    foreach ($from_file as $val){
        $item = explode(",", $val);
        if (password_verify($pwd, $item[5])) {
            return true;
        }
    }
    return false;
    
}

function logout(){
    session_start();
    unset($_SESSION['login']);
    setcookie('login', '', time() - 1);
    setcookie('pwd', '', time() - 1);
}