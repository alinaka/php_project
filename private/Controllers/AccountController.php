<?php 

namespace alina\project\Controllers;
use alina\project\App\Controller;
use alina\project\Models\AccountModel;
use alina\project\App\Request;
use alina\project\App\Session;

class AccountController extends Controller
{
    private $model;
    private $reguest;
    private $session;

    public function __construct(){
        session_start();
        $this->model = new AccountModel();
        $this->request = new Request();
        $this->session = new Session();
    }
    
    public function indexAction(){
        if ($this->session->is_session_var('login')) {
            $view = 'account_view.php';
            $title = 'Личная информация';
            $this->generateView($view, [
                        'page_title' => $title,
            ]);
        } else {
            header('Location: /');
            exit();
        }
    }

    public function authAction(){
        if (isset($_COOKIE['login'])) {
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $_COOKIE['login'];
        }
        if ($this->session->is_session_var('login')) {
            header('Location: /task');
            exit();
        } else {
            $post = $this->request->post();
            $auth_data = [
                'login'=>$post['login'],
                'password'=>$post['password'],
            ];
            echo $this->model->auth_user($auth_data);

            if($post['remember']){
                setcookie('login', $data['login'], time() + 3600 * 24 * 180);
                setcookie('pwd', password_hash($data['password'], PASSWORD_DEFAULT), time()+3600 * 24 * 180);
            }
            $this->session->set_session_var('login', $auth_data['login'] );
        }
    }

    public function registrationAction(){
        if (isset($_COOKIE['login'])) {
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $_COOKIE['login'];
        }
        if ($this->session->is_session_var('login')) {
            header('Location: /task');
            exit();
        } else {
            $post = $this->request->post();
            $reg_data = [
                'login'=>$post['login'],
                'hash'=>password_hash($post['password'], PASSWORD_DEFAULT),
                'email'=>$post['email'],
                'avatar'=>'avatar.jpg',
            ];
            echo $this->model->add_user($reg_data);
        }
    }

    public function logoutAction(){
        $this->session->remove_session_var('login');
        setcookie('login', '', time() - 1);
        setcookie('pwd', '', time() - 1);
        header('Location: /');
        exit();
    }
}
?>
