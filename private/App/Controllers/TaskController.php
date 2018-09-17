<?php

namespace alina\project\Controllers;

use Framework\Session;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Framework\Controller;
use alina\project\Models\TaskModel;

class TaskController extends Controller {

    private $model;
    private $session;
    private $post;

    public function __construct(ServerRequestInterface $request) {
        parent::__construct();
        $this->model = new TaskModel();
        $this->session = new Session();
        $this->session->start();
        $this->post = $request->getParsedBody();
    }

    public function showAction(ServerRequestInterface $request) {
        if ($this->session->has('login')) {
            $view = 'task.html.twig';
            $title = 'Задача';
            $id = $request->getAttribute('id');
            $task = $this->model->getTaskById($id);
            $entries = $this->model->getEntriesById($id);
            $comments = $this->model->getCommentsById($id);
            return new HtmlResponse($this->generateView($view, [
                        'page_title' => $title,
                        'task' => $task,
                        'entries'=>$entries,
                        'login' => $this->session->get('login'),
                        'comments' => $comments
            ]));
        } else {
            return new HtmlResponse('', 200, [
                'Location' => '/'
            ]);
        }
    }

    public function addAction() {
        if ($this->session->has('login')) {
            if (count($this->post) > 0) {
                $task_data = [
                    'title' => $this->post['title'],
                    'description' => $this->post['description'],
                    'date_start_plan' => $this->post['date_start_plan'],
                    'date_end_plan' => $this->post['date_end_plan'],
                    'time_plan' => $this->post['time_plan'],
                    'author_id' => 1,
                    'project_id' => 1
                ];
                return new HtmlResponse($this->model->add($task_data));
            } else {
                $view = 'task_сreate.html.twig';
                $title = 'Добавление задачи';
                return new HtmlResponse($this->generateView($view, [
                            'page_title' => $title,
                            'login' => $this->session->get('login'),
                ]));
            }
        } else {
            return new HtmlResponse('', 200, [
                'Location' => '/'
            ]);
        }
    }

    public function editAction(ServerRequestInterface $request) {
        if ($this->session->has('login')) {
            if (count($this->post) > 0) {
                $task_data = [
                    'task_id' => $this->post['task_id'],
                    'title' => $this->post['title'],
                    'description' => $this->post['description'],
                    'date_start_plan' => $this->post['date_start_plan'],
                    'date_end_plan' => $this->post['date_end_plan'],
                    'time_plan' => $this->post['time_plan'],
                    'status_id'=>$this->post['status_id']
                ];
                return new HtmlResponse($this->model->save($task_data));
            } else {
                $id = $request->getAttribute('id');
                $task = $this->model->getTaskById($id);
                $view = 'task_edit.html.twig';
                $title = 'Редактирование задачи';
                return new HtmlResponse($this->generateView($view, [
                            'page_title' => $title,
                            'task' => $task,
                            'login' => $this->session->get('login'),
                ]));
            }
        } else {
            return new HtmlResponse('', 200, [
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
            return new HtmlResponse($this->generateView($view, [
                        'page_title' => $title,
                        'data' => $current_tasks,
                        'finished_tasks' => $finished_tasks,
                        'login' => $this->session->get('login'),
            ]));
        } else {
            return new HtmlResponse('', 200, [
                'Location' => '/'
            ]);
        }
    }
    
    public function finishAction(ServerRequestInterface $request){
        if (isset($_COOKIE['login'])) {
            $this->session->set('login', $_COOKIE['login']);
        }
        if ($this->session->has('login')) {
            $id = $request->getAttribute('id');
            $this->model->finish($id);
            return new HtmlResponse('', 200, [
                'Location' => '/task'
            ]);
        } else {
            return new HtmlResponse('', 200, [
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
