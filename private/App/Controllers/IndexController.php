<?php

namespace alina\project\Controllers;

use Framework\Session;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Framework\Controller;

class IndexController extends Controller {

    private $session;

    public function __construct() {
        parent::__construct();
        $this->session = new Session();
        $this->session->start();
    }

    public function indexAction() {
        if ($this->session->has('login')) {
            return new HtmlResponse('', 200, [
                'Location' => '/task'
            ]);
        } else {
            $view = 'index.html.twig';
            $title = 'Главная страница';
            return new HtmlResponse($this->generateView($view, [
                        'page_title' => $title,
            ]));
        }
    }

}
