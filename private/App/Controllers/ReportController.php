<?php
namespace alina\project\Controllers;

use Framework\Session;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Framework\Controller;
use alina\project\Models\ReportModel;

class ReportController extends Controller
{
    private $model;
    private $session;
    private $post;
    
    public function __construct(ServerRequestInterface $request){
        parent::__construct();
        $this->model = new ReportModel();
        $this->session = new Session();
        $this->session->start();
        $this->post = $request->getParsedBody();
    }
    
    public function indexAction(){
        $view = 'report.html.twig';
        $title = 'Отчеты о времени';
        $tasks = $this->model->getTasksLists();
        return new HtmlResponse($this->generateView($view,[
                'page_title'=>$title,
                'tasks'=>$tasks,
        ]));
    }
    
    public function getDataAction(){
        $from = $this->post['from'];
        $to = $this->post['to'];
        if($this->post['report_on'] == 'general'){    
            $tasks = $this->model->getAllTime($from, $to);           
        } else {
            $id = $this->post['report_on'];
            $tasks = $this->model->getTimeOnTask($id, $from, $to);
        }
        return new JsonResponse($tasks);
    }
}
