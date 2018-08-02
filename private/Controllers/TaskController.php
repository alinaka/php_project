<?php

namespace alina\project\Controllers;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use alina\project\App\Controller;
use alina\project\Models\TaskModel;

class TaskController extends Controller {

    private $model;
    private $session;
    private $post;

    public function __construct() {
        parent::__construct();
        $this->model = new TaskModel();
        $this->session = new Session();
        $this->session->start();
        $this->post = Request::createFromGlobals()->request;
    }

    public function showAction($id) {
        if ($this->session->has('login')) {
            $view = 'task.html.twig';
            $title = 'Задача';
            $task = $this->model->getTaskById($id);
            $entries = $this->model->getEntriesById($id);
            $comments = $this->model->getCommentsById($id);
            return new Response($this->generateView($view, [
                        'page_title' => $title,
                        'task' => $task,
                        'entries'=>$entries,
                        'login' => $this->session->get('login'),
                        'comments' => $comments
            ]));
        } else {
            return new Response('', 200, [
                'Location' => '/'
            ]);
        }
    }

    public function addAction() {
        if ($this->session->has('login')) {
            if (count($this->post) > 0) {
                $task_data = [
                    'title' => $this->post->get('title'),
                    'description' => $this->post->get('description'),
                    'date_start_plan' => $this->post->get('date_start_plan'),
                    'date_end_plan' => $this->post->get('date_end_plan'),
                    'time_plan' => $this->post->get('time_plan'),
                    'author_id' => 1,
                    'project_id' => 1
                ];
                return new Response($this->model->add($task_data));
            } else {
                $view = 'task_сreate.html.twig';
                $title = 'Добавление задачи';
                return new Response($this->generateView($view, [
                            'page_title' => $title,
                            'login' => $this->session->get('login'),
                ]));
            }
        } else {
            return new Response('', 200, [
                'Location' => '/'
            ]);
        }
    }

    public function editAction($id) {
        if ($this->session->has('login')) {
            if (count($this->post) > 0) {
                $task_data = [
                    'task_id' => $this->post->get('task_id'),
                    'title' => $this->post->get('title'),
                    'description' => $this->post->get('description'),
                    'date_start_plan' => $this->post->get('date_start_plan'),
                    'date_end_plan' => $this->post->get('date_end_plan'),
                    'time_plan' => $this->post->get('time_plan'),
                    'status_id'=>$this->post->get('status_id')
                ];
                return new Response($this->model->save($task_data));
            } else {
                $task = $this->model->getTaskById($id);
                $view = 'task_edit.html.twig';
                $title = 'Редактирование задачи';
                return new Response($this->generateView($view, [
                            'page_title' => $title,
                            'task' => $task,
                            'login' => $this->session->get('login'),
                ]));
            }
        } else {
            return new Response('', 200, [
                'Location' => '/'
            ]);
        }
    }

    public function indexAction() {
        if (isset($_COOKIE['login'])) {
            $this->session->set('login', $_COOKIE['login']);
        }
        if ($this->session->has('login')) {
            $current_tasks = $this->model->getCurrentTasks();
            $finished_tasks = $this->model->getFinishedTasks();
            $view = 'tasks.html.twig';
            $title = 'Личная страница';
            return new Response($this->generateView($view, [
                        'page_title' => $title,
                        'data' => $current_tasks,
                        'finished_tasks' => $finished_tasks,
                        'login' => $this->session->get('login'),
            ]));
        } else {
            return new Response('', 200, [
                'Location' => '/'
            ]);
        }
    }
    
    public function finishAction($id){
        if (isset($_COOKIE['login'])) {
            $this->session->set('login', $_COOKIE['login']);
        }
        if ($this->session->has('login')) {
            $this->model->finish($id);
            return new Response('', 200, [
                'Location' => '/task'
            ]);
        } else {
            return new Response('', 200, [
                'Location' => '/'
            ]);
        }
    }
    

    /* public function fileAction() {
      $uploaddir = '../uploads/';
      $uploadfile = $uploaddir . basename($_FILES['doc']['name']);

      echo '<pre>';
      if (move_uploaded_file($_FILES['doc']['tmp_name'], $uploadfile)) {
      echo "Файл корректен и был успешно загружен.\n";
      } else {
      echo "Возможная атака с помощью файловой загрузки!\n";
      }

      echo 'Некоторая отладочная информация:';
      print_r($_FILES);

      print "</pre>";
      } */
}
