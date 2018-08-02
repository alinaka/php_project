<?php

namespace alina\project\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use alina\project\App\Controller;
use alina\project\Models\User;
use alina\project\Models\UserMapper;

class ProfileController extends Controller {

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

    public function indexAction() {
        if ($this->session->has('login')) {
            $userdata = $this->mapper->get_userdata($this->session->get('login'));
            $view = 'account.html.twig';
            $title = 'Личная информация';
            return new Response($this->generateView($view, [
                        'page_title' => $title,
                        'login' => $this->session->get('login'),
                        'user' => $userdata
            ]));
        } else {
            header('Location: /');
            exit();
        }
    }
    
    public function downloadAvatarAction() {
        $filename = basename($_FILES['avatar']['name']);
        $uploaddir = 'uploads/';
        $uploadfile = $uploaddir . $filename;

        //echo '<pre>';
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile)) {
            $userdata = $this->mapper->get_userdata($this->session->get('login'));

            $data = [
                'avatar' => $filename,
                'user_id' => $userdata['user_id'],
            ];
            return new Response($this->mapper->saveAvatar($data));

            //echo "Файл корректен и был успешно загружен.\n";
        } else {
            //echo "Возможная атака с помощью файловой загрузки!\n";
        }

        //echo 'Некоторая отладочная информация:';
        //print_r($_FILES);
        //print "</pre>";
    }

}
