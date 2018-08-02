<?php

namespace alina\project\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use alina\project\App\Controller;
use alina\project\Models\User;
use alina\project\Models\UserMapper;

class AccountController extends Controller {

    private $model;
    private $post;
    private $session;

    public function __construct() {
        parent::__construct();
        $this->mapper = new UserMapper();
        $this->post = Request::createFromGlobals()->request;
        $this->session = new Session();
        $this->session->start();
    }

    public function check_loginAction() {
        $response = array(
            'valid' => false,
            'message' => 'Поле Логин не заполнено'
        );
        $username = $this->post->get('login');
        if ($username) {
            $user = $this->mapper->getByLogin($username);

            if ($user) {
                // User name is registered on another account
                $response = array('valid' => false, 'message' => 'Пользователь с таким логином уже существует');
            } else {
                // User name is available
                $response = array('valid' => true);
            }
        }
        return new JsonResponse($response);
    }

    public function authAction() {
        if (isset($_COOKIE['login'])) {
            $this->session->set('login', $_COOKIE['login']);
        }
        if ($this->session->has('login')) {
            header('Location: /task');
            exit();
        } else {
            $user = new User();
            $user->setLogin($this->post->get('login'))
                    ->setHash($this->post->get('password'));
            if ($this->post->get('remember')) {
                setcookie('login', $user->getLogin(), time() + 3600 * 24 * 180);
                //токен
                setcookie('pwd', password_hash($user->getHash(), PASSWORD_DEFAULT), time() + 3600 * 24 * 180);
            }
            $userMapper = new UserMapper();
            $result = $userMapper->auth($user);
            if ($result === 'Auth_success') {
                $this->session->set('login', $user->getLogin());
                $result = json_encode([
                    'path' => "/task"
                ]);
            }
            return new Response($result);
        }
    }

    public function registrationAction() {
        if (isset($_COOKIE['login'])) {
            $this->session->set('login', $_COOKIE['login']);
        }
        if ($this->session->has('login')) {
            return new Response('', [
                'Location' => '/task'
            ]);
        } else {
            $user = new User();
            $user->setLogin($this->post->get('login'))
                    ->setHash(password_hash($this->post->get('password'), PASSWORD_DEFAULT))
                    ->setEmail($this->post->get('email'));
            $userMapper = new UserMapper();
            $result = $userMapper->add($user);
            $auth = json_decode($result);
            if ($auth->msg === REG_SUCCESS) {
                $this->session->set('login', $user->getLogin());
            }
            return new Response($result);
        }
    }

    public function logoutAction() {
        $this->session->remove('login');
        setcookie('login', '', time() - 1);
        setcookie('pwd', '', time() - 1);
        return new Response('', 200, [
            'Location' => '/'
        ]);
    }
}
