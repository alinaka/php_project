<?php
namespace alina\project\Controllers;
use alina\project\App\Controller;
use alina\project\App\Session;
use alina\project\App\Request;
use alina\project\App\Response;
use alina\project\Models\ReportModel;

class ReportController extends Controller
{
    private $model;
    private $session;
    private $request;
    
    public function __construct(){
        parent::__construct();
        session_start();
        $this->model = new ReportModel();
        $this->session = new Session();
        $this->request = new Request();
    }
    
    public function indexAction(){
        $view = 'report.html.twig';
        $title = 'Отчеты о времени';
        $tasks = $this->model->getTasksLists();
        return new Response($this->generateView($view,[
                'page_title'=>$title,
                'tasks'=>$tasks,
        ]));
    }
    
    public function getDataAction(){
        $post = $this->request->post();
        $from = $post['from'];
        $to = $post['to'];
        if($post['report_on'] == 'general'){    
            $tasks = json_encode($this->model->getAllTime($from, $to));
            return new Response($tasks);
        } else {
            $id = $post['report_on'];
            $tasks = json_encode($this->model->getTimeOnTask($id, $from, $to));
            return new Response($tasks);
        }
    }
}
