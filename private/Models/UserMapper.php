<?php
namespace alina\project\Models;
use alina\project\App\DB;
use alina\project\App\QueryBuilder;

class UserMapper
{
    private $db;
    private $tablename = "User";
    
    public function __construct(){
        $this->db = DB::getInstance();
        $this->builder = new QueryBuilder();
    }
    
    public function getByLogin($login){
        $sql = $this->builder
                ->select($this->tablename)
                ->where()
                ->equals("login")
                ->getSql();
        $params = [
            'login' => $login,
        ];
        return $this->db->fetchData($sql, $params);
    }

    public function auth(User $user) {
        $login = $user->getLogin();
        if (!$this->getByLogin($login)) {
            return AUTH_FAIL_LOGIN;
        }
        if (!$this->check_password($user)) {
            return AUTH_FAIL_PWD;
        }
        return 'Auth_success';
    }

    public function add(User $user) {
        $login = $user->getLogin();
        if ($this->getByLogin($login) == false) {
            $reg_data = [
                'login'=> $user->getLogin(),
                'hash' => $user->getHash(),
                'email' => $user->getEmail()
            ];
            $sql = $this->builder
                    ->insert($this->tablename, $reg_data)
                    ->getSql();
            if ($this->db->executePreparedQuery($sql, $reg_data)) {
                $response = json_encode([
                    'msg'=>REG_SUCCESS,
                    'modal'=>true,
                    'path'=>'/task'
                ]);
            } else {
                $response = DB_FAIL;
            }
        } else {
            $response = USER_EXISTS;
        }
        return $response;
    }

    protected function check_password(User $user) {
        $sql = $this->builder
                ->select($this->tablename, ['hash'])
                ->where()
                ->equals('login')
                ->getSql();
        $params = [
            'login' => $user->getLogin(),
        ];
        $data = $this->db->fetchData($sql, $params);
        return password_verify($user->getHash(), $data['hash']);
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
