<?php

namespace alina\project\Models;

use alina\project\App\DB;
use alina\project\App\QueryBuilder;

require_once('server_response.php');

class AccountModel {

    private $db;
    private $tablename = "User";
    private $builder;

    public function __construct() {
        $this->db = DB::getInstance();
        $this->builder = new QueryBuilder();
    }

    public function is_registered($login) {
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
            return AUTH_FAIL_LOGIN;
        }
        if (!$this->check_password($auth_data)) {
            return AUTH_FAIL_PWD;
        }
        return 'Auth_success';
    }

    public function add($reg_data) {
        if ($this->is_registered($reg_data['login']) == false) {
            $sql = $this->builder
                    ->insert($this->tablename, $reg_data)
                    ->getSql();
            if ($this->db->executePreparedQuery($sql, $reg_data)) {
                $response = [
                    'msg'=>REG_SUCCESS,
                    'modal'=>true,
                    'path'=>'/task'
                ];
                return json_encode($response);
            } else {
                return DB_FAIL;
            }
        } else {
            return USER_EXISTS;
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
            return AVATAR_SUCCESS;
        } else {
            return DB_FAIL;
        }
    }
}
