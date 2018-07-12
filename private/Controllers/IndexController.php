<?php

namespace alina\project\Controllers;

use alina\project\App\Controller;
use alina\project\App\Session;
use alina\project\App\Response;

class IndexController extends Controller {

    private $session;

    public function __construct() {
        parent::__construct();
        session_start();
        $this->session = new Session();
    }

    public function indexAction() {
        if ($this->session->is_session_var('login')) {
            return new Response('', [
                'Location' => '/task'
            ]);
        } else {
            $view = 'index.html.twig';
            $title = 'Главная страница';
            return new Response($this->generateView($view, [
                        'page_title' => $title,
            ]));
        }
    }

}
