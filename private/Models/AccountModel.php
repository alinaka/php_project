<?php
namespace alina\project\Models;
use alina\project\App\DB;

class AccountModel
{
    private $db;
    private $tablename = "User";

    public function __construct(){
        $this->db = new DB();
    }

    protected function is_user_registered($login){
        $sql = "SELECT login FROM $this->tablename 
            WHERE login=:login";
        $params = [
            'login' => $login,
        ];
        return $this->db->fetchData($sql, $params);
    }

    public function auth_user($auth_data){
        if (!$this->is_user_registered($auth_data['login'])){
            return 'wrong login';
        }
        if (!$this->check_password($auth_data)){
            return 'wrong pwd';
        }
        return 'success';
    }

    public function add_user($reg_data){
        if($this->is_user_registered($reg_data['login']) == false){
            $sql = "INSERT INTO $this->tablename(login, hash, email, avatar) 
                VALUES (:login, :hash, :email, :avatar)";
            return $this->db->executePreparedQuery($sql, $reg_data);
        }
        return 'пользователь существует';
    }

    protected function check_password($auth_data){
        $sql = "SELECT hash FROM $this->tablename 
            WHERE login=:login";
        $params = [
            'login' => $auth_data['login'],
        ];
        $data = $this->db->fetchData($sql, $params);
        return password_verify($auth_data['password'], $data['hash']);
    }
}