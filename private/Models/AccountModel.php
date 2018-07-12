<?php

namespace alina\project\Models;

use alina\project\App\DB;
use alina\project\App\QueryBuilder;

class AccountModel {

    private $db;
    private $tablename = "User";
    private $builder;

    public function __construct() {
        $this->db = new DB();
        $this->builder = new QueryBuilder();
    }

    protected function is_registered($login) {
        $sql = $this->builder
                ->select($this->tablename, ['login'])
                ->where()
                ->equals('login')
                ->getSql();
        $params = [
            'login' => $login,
        ];
        return $this->db->fetchData($sql, $params);
    }

    public function auth($auth_data) {
        if (!$this->is_registered($auth_data['login'])) {
            return 'Auth_fail_login';
        }
        if (!$this->check_password($auth_data)) {
            return 'Auth_fail_pwd';
        }
        return 'Auth_success';
    }

    public function add($reg_data) {
        if ($this->is_registered($reg_data['login']) == false) {
            $sql = $this->builder
                    ->insert($this->tablename, $reg_data)
                    ->getSql();
            if ($this->db->executePreparedQuery($sql, $reg_data)) {
                return "Reg_success";
            } else {
                return "Reg_fail";
            }
        } else {
            return "Reg_fail_user_exists";
        }
    }

    protected function check_password($auth_data) {
        $sql = $this->builder
                ->select($this->tablename, ['hash'])
                ->where()
                ->equals('login')
                ->getSql();
        $params = [
            'login' => $auth_data['login'],
        ];
        $data = $this->db->fetchData($sql, $params);
        return password_verify($auth_data['password'], $data['hash']);
    }

    public function get_userdata($login){
        $sql = $this->builder
                ->select("$this->tablename")
                ->join("Profile", "$this->tablename.user_id", "Profile.user_id")
                ->addAnd()
                ->equals('login')
                ->getSql();
        $params = [
            'login' => $login,
        ];
        return $this->db->fetchData($sql, $params);
    }
    
    public function saveAvatar($data){
        $sql = "UPDATE Profile SET avatar=:avatar WHERE user_id=:user_id";
        if ($this->db->executePreparedQuery($sql, $data)) {
            return "Avatar_success";
        } else {
            return "Avatar_fail";
        }
    }
}
