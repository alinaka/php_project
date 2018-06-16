<?php
namespace alina\project\Controllers;
use alina\project\App\Controller;
use alina\project\App\Template;
use alina\project\App\Session;

class IndexController extends Controller
{
//    private $template_maker;
//    
//    function construct __(){
//        $this->template_maker = new Template();
//    }
    private $session;
    
    public function __construct(){
        session_start();
        $this->session = new Session();
    }
	
    public function indexAction(){  
            if ($this->session->is_session_var('login')){
                header('Location: /task');
                exit();
            }
            else {
                $view = 'index.twig';
                $title = 'Главная страница';
                echo $this->generateView($view, [
                                    'page_title' => $title,
                ]);
            }
	}
}