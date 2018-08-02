<?php

namespace alina\project\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;
use alina\project\App\Controller;

class IndexController extends Controller {

    private $session;

    public function __construct() {
        parent::__construct();
        $this->session = new Session();
        $this->session->start();
    }

    public function indexAction() {
        if ($this->session->has('login')) {
            return new Response('', 200, [
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
