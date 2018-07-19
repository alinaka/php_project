<?php

namespace alina\project\Controllers;

use alina\project\App\Controller;
use Symfony\Component\HttpFoundation\Request;
use alina\project\App\Response;
use alina\project\App\Session;
use alina\project\Models\AccountModel;

class AccountController extends Controller {

    private $model;
    private $post;
    private $session;

    public function __construct() {
        parent::__construct();
        session_start();
        $this->model = new AccountModel();
        $this->post = Request::createFromGlobals()->request;
        $this->session = new Session();
    }

    public function indexAction() {
        if ($this->session->is_session_var('login')) {
            $userdata = $this->model->get_userdata($this->session->get_session_var('login'));
            $view = 'account.html.twig';
            $title = 'Личная информация';
            return new Response($this->generateView($view, [
                        'page_title' => $title,
                        'login' => $this->session->get_session_var('login'),
                        'user' => $userdata
            ]));
        } else {
            header('Location: /');
            exit();
        }
    }

    public function check_loginAction() {
        $response = array(
            'valid' => false,
            'message' => 'Поле Логин не заполнено'
        );
        $username = $this->post->get('login');
        if ($username) {
            $user = $this->model->is_registered($username);

            if ($user) {
                // User name is registered on another account
                $response = array('valid' => false, 'message' => 'Пользователь с таким логином уже существует');
            } else {
                // User name is available
                $response = array('valid' => true);
            }
        }
        return new Response(json_encode($response)) ;
    }

    public function authAction() {
        if (isset($_COOKIE['login'])) {
            $this->session->set_session_var('login', $_COOKIE['login']);
        }
        if ($this->session->is_session_var('login')) {
            header('Location: /task');
            exit();
        } else {
            $auth_data = [
                'login' => $this->post->get('login'),
                'password' => $this->post->get('password'),
            ];
            if ($this->post->get('remember')) {
                setcookie('login', $auth_data['login'], time() + 3600 * 24 * 180);
                setcookie('pwd', password_hash($auth_data['password'], PASSWORD_DEFAULT), time() + 3600 * 24 * 180);
            }
            $result = $this->model->auth($auth_data);
            if ($result === 'Auth_success') {
                $this->session->set_session_var('login', $auth_data['login']);
                $result = json_encode([
                    'path' => "/task"
                ]);
            }
            return new Response($result);
        }
    }

    public function registrationAction() {
        if (isset($_COOKIE['login'])) {
            $this->session->set_session_var('login', $_COOKIE['login']);
        }
        if ($this->session->is_session_var('login')) {
            return new Response('', [
                'Location' => '/task'
            ]);
        } else {
            $reg_data = [
                'login' => $this->post->get('login'),
                'hash' => password_hash($this->post->get('password'), PASSWORD_DEFAULT),
                'email' => $this->post->get('email')
            ];
            $result = $this->model->add($reg_data);
            $auth = json_decode($result);
            if ($auth->msg === REG_SUCCESS) {
                $this->session->set_session_var('login', $reg_data['login']);
            }
            return new Response($result);
        }
    }

    public function logoutAction() {
        $this->session->remove_session_var('login');
        setcookie('login', '', time() - 1);
        setcookie('pwd', '', time() - 1);
        return new Response('', [
            'Location' => '/'
        ]);
    }

    public function downloadAvatarAction() {
        $filename = basename($_FILES['avatar']['name']);
        $uploaddir = 'uploads/';
        $uploadfile = $uploaddir . $filename;

        //echo '<pre>';
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile)) {
            $userdata = $this->model->get_userdata($this->session->get_session_var('login'));

            $data = [
                'avatar' => $filename,
                'user_id' => $userdata['user_id'],
            ];
            return new Response($this->model->saveAvatar($data));

            //echo "Файл корректен и был успешно загружен.\n";
        } else {
            //echo "Возможная атака с помощью файловой загрузки!\n";
        }

        //echo 'Некоторая отладочная информация:';
        //print_r($_FILES);
        //print "</pre>";
    }

}
