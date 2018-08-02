<?php
namespace alina\project\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use alina\project\App\Controller;
use alina\project\Models\ReportModel;

class ReportController extends Controller
{
    private $model;
    private $session;
    private $post;
    
    public function __construct(){
        parent::__construct();
        $this->model = new ReportModel();
        $this->session = new Session();
        $this->session->start();
        $this->post = Request::createFromGlobals()->request;
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
        $from = $this->post->get('from');
        $to = $this->post->get('to');
        if($this->post->get('report_on') == 'general'){    
            $tasks = $this->model->getAllTime($from, $to);           
        } else {
            $id = $this->post->get('report_on');
            $tasks = $this->model->getTimeOnTask($id, $from, $to);
        }
        return new JsonResponse($tasks);
    }
}
