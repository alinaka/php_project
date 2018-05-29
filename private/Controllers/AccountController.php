<?php 

namespace alina\project\Controllers;
use alina\project\App\Controller;
use alina\project\Models\AuthModel;


class AccountController extends Controller
{
    private $model;

    function __construct(){
        $this->model = new AuthModel();
    }

    function authAction(){
        session_start();
        if (isset($_COOKIE['login'])) {
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $_COOKIE['login'];
        }
        if ($_SESSION['auth']) {
            echo "Вы уже авторизованы";
        } else {
            $view = 'auth_view.php';
            $title = "Авторизоваться";
            $this->generateView($view, [
                    'page_title' => $title,
                    ]);
        }
    }

    function postAction(){
        session_start();
        $data = $this->model->check_data();
        //авторизация
        if (count($data)==2 || count($data)==3){
            if (!$this->model->is_data_in_file($data, '../private/Models/data.txt')){
                echo 'Неверный логин';
                return;
            }
            if (!$this->model->check_password($data, '../private/Models/data.txt')){
                echo 'Неверный пароль';
                return;
            }
            if($data['remember']){
                setcookie('login', $data['login'], time() + 3600 * 24 * 180);
                setcookie('pwd', password_hash($data['password'], PASSWORD_DEFAULT), time()+3600 * 24 * 180);
            }
            $_SESSION['login'] = $data['login'];
            $_SESSION['auth'] = true;
            echo "success";
        } else if (count($data) == 4){
            echo "это регистрация";
            $data = $this->model->check_data();
        
            if ($this->model->is_data_in_file($data, '../private/Models/data.txt')){
                //TO DO добавить проверку e-mail на уникальность и 
                //проверять валидность пароля только после проверки 
                //желаемого логина на существование
                echo 'Пользователь с таким логином уже зарегистрирован';
                return;
            }

            if (!$this->model->add_user($data, '../private/Models/data.txt')){
                echo 'Пользователь не прошел регистрацию';
                return;
            }
            echo 'Пользователь прошел регистрацию';
        }      
    }

    function registrationAction(){
        session_start();
        if (isset($_COOKIE['login'])) {
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $_COOKIE['login'];
        }
        if ($_SESSION['auth']) {
            echo "Вы уже авторизованы";
        } else {
            $view = 'reg_view.php';
            $title = 'Зарегистрироваться';
            
            $this->generateView($view, [
                             'page_title' => $title,
                                ]);
        }
    }

    function logoutAction(){
        session_start();
        unset($_SESSION['auth']);
        setcookie('login', '', time() - 1);
        setcookie('pwd', '', time() - 1);
        header('Location: /');
        exit();
    }
}
?>
