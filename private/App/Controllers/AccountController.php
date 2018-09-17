<?php

namespace alina\project\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Framework\Controller;
use Framework\Session;
use alina\project\Models\User;
use alina\project\Models\UserMapper;

class AccountController extends Controller {

    private $post;
    private $session;

    public function __construct(ServerRequestInterface $request) {
        parent::__construct();
        $this->post = $request->getParsedBody();
        $this->session = new Session();
        $this->session->start();
    }

    public function check_loginAction() {
        $response = array(
            'valid' => false,
            'message' => 'Поле Логин не заполнено'
        );
        $username = $this->post['login'];
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
            $user->setLogin($this->post['login'])
                    ->setHash($this->post['password']);
            if ($this->post['remember']) {
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
           return new HtmlResponse($result);
        }
    }

    public function registrationAction() {
        if (isset($_COOKIE['login'])) {
            $this->session->set('login', $_COOKIE['login']);
        }
        if ($this->session->has('login')) {
            return new HtmlResponse('', [
                'Location' => '/task'
            ]);
        } else {
            $user = new User();
            $user->setLogin($this->post['login'])
                    ->setHash(password_hash($this->post['password'], PASSWORD_DEFAULT))
                    ->setEmail($this->post['email']);
            $userMapper = new UserMapper();
            $result = $userMapper->add($user);
            $auth = json_decode($result);
            if ($auth->msg === REG_SUCCESS) {
                $this->session->set('login', $user->getLogin());
            }
            return new HtmlResponse($result);
        }
    }

    public function logoutAction() {
        $this->session->remove('login');
        setcookie('login', '', time() - 1);
        setcookie('pwd', '', time() - 1);
        return new HtmlResponse('', 200, [
            'Location' => '/'
        ]);
    }
}
