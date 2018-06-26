<?php
namespace alina\project\Controllers;
use alina\project\App\Controller;
use alina\project\Models\TaskModel;
use alina\project\App\Session;
use alina\project\App\Request;
use alina\project\App\Response;

class ProjectController extends Controller
{
    private $model;
    private $session;
    private $request;
    private $template_maker;
    
    public function __construct(){
        parent::__construct();
        session_start();
        $this->model = new TaskModel();
        $this->session = new Session();
        $this->request = new Request();
    }

    
    public function indexAction(){
        if (isset($_COOKIE['login'])) {
            $this->session->set_session_var('login', $_COOKIE['login']);
        }
        if ($this->session->is_session_var('login')){
            $data = $this->model->getAllTasks();
            $view = 'tasks.twig';
            $title = 'Личная страница';
            return new Response($this->generateView($view, [
                        'page_title' => $title,
                        'data' => $data,
                        'login'=>$this->session->get_session_var('login'),
            ]));
        } else {
            return new Response('', [
                'Location'=>'/'
            ]);
        }
        
    }
}