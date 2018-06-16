<?php
namespace alina\project\Controllers;
use alina\project\App\Controller;
use alina\project\Models\TaskModel;
use alina\project\App\Session;

class TaskController extends Controller
{
    private $model;
    private $session;
    
    public function __construct(){
        session_start();
        $this->model = new TaskModel();
        $this->session = new Session();
    }

    public function showAction($get){
        if ($this->session->is_session_var('login')){
            $data = $this->model->getAllTasks();
            $view = 'task.twig';
            $title = 'Задача';
            $id = $get;
            $task = $this->model->getTaskById($id);
            echo $this->generateView($view, [
                        'page_title' => $title,
                        'task' => $task,
                        'login'=>$this->session->get_session_var('login'),
                ]);
        } else {
            header('Location: /');
            exit();
        }
    }

    public function addAction(){
        if ($this->session->is_session_var('login')){
            if(count($_POST) > 0){
                $post = $_POST;
  
                $task_data = [
                    'title' => $post['title'],
                    'description' => $post['description'],
                    'date_start_plan' => $post['date_start_plan'],
                    'date_end_plan' => $post['date_end_plan'],
                    'time_plan' => $post['time_plan'],
                    'author_id'=> 1
                ];
                echo $this->model->addTask($task_data);
            } else {
                $view = 'task_сreate.twig';
                $title = 'Добавление задачи';
                $header = 'Новая задача';
                echo $this->generateView($view, [
                        'page_title' => $title,
                        'header' => $header,
                        'login'=>$this->session->get_session_var('login'),
                    ]);
            }
        } else {
            header('Location: /');
            exit();
        }
    }

    public function editAction(){
        if ($this->session->is_session_var('login')){
            if(count($_POST) > 0){

            } else {
                $view = 'task_сreate.twig';
                $title = 'Добавление задачи';
                $header = 'Редактирование задачи';
                echo $this->generateView($view, [
                        'page_title' => $title,
                        'header' => $header,
                        'login'=>$this->session->get_session_var('login'),
                ]);
            }
        } else {
            header('Location: /');
            exit();
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
            echo $this->generateView($view, [
                        'page_title' => $title,
                        'data' => $data,
                        'login'=>$this->session->get_session_var('login'),
            ]);
        } else {
            header('Location: /');
            exit();
        }
        
    }
}