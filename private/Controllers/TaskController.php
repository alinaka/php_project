<?php
namespace alina\project\Controllers;
use alina\project\App\Controller;
use alina\project\Models\TaskModel;
use alina\project\App\Session;
use alina\project\App\Request;
use alina\project\App\Response;

class TaskController extends Controller
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

    public function showAction($get){
        if ($this->session->is_session_var('login')){
            $view = 'task.twig';
            $title = 'Задача';
            $id = $get;
            $task = $this->model->getTaskById($id);
            return new Response($this->generateView($view, [
                        'page_title' => $title,
                        'task' => $task,
                        'login'=>$this->session->get_session_var('login'),
            ]));
        } else {
            return new Response('', [
                'Location'=>'/'
            ]);
        }
    }

    public function addAction(){
        if ($this->session->is_session_var('login')){
            if(count($_POST) > 0){
                $post = $this->request->post();
                $task_data = [
                    'title' => $post['title'],
                    'description' => $post['description'],
                    'date_start_plan' => $post['date_start_plan'],
                    'date_end_plan' => $post['date_end_plan'],
                    'time_plan' => $post['time_plan'],
                    'author_id'=> 1
                ];
                return new Response ($this->model->addTask($task_data));
            } else {
                $view = 'task_сreate.twig';
                $title = 'Добавление задачи';
                return new Response($this->generateView($view, [
                        'page_title' => $title,
                        'login'=>$this->session->get_session_var('login'),
                    ]));
            }
        } else {
            return new Response('', [
                'Location'=>'/'
            ]);
        }
    }

    public function editAction($get){
        if ($this->session->is_session_var('login')){
            if(count($_POST) > 0){
                $post = $this->request->post();
                $task_data = [
                    'id' => $post['task_id'],
                    'title' => $post['title'],
                    'description' => $post['description'],
                    'date_start_plan' => $post['date_start_plan'],
                    'date_end_plan' => $post['date_end_plan'],
                    'time_plan' => $post['time_plan'],
                    'author_id'=> 1
                ];
                return new Response($this->model->updateTask($task_data));
            } else {
                $id = $get;
                $task = $this->model->getTaskById($id);
                $view = 'task_edit.twig';
                $title = 'Редактирование задачи';
                return new Response($this->generateView($view, [
                        'page_title' => $title,
                        'task' => $task,
                        'login'=>$this->session->get_session_var('login'),
                ]));
            }
        } else {
            return new Response('', [
                'Location'=>'/'
            ]);
        }
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