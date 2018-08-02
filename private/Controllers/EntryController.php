<?php

namespace alina\project\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use alina\project\App\Controller;
use alina\project\Models\EntryModel;
use alina\project\Models\TaskModel;

class EntryController extends Controller {

    private $model;
    private $session;
    private $post;

    public function __construct() {
        parent::__construct();
        $this->model = new EntryModel();
        $this->session = new Session();
        $this->session->start();
        $this->post = Request::createFromGlobals()->request;
    }

    public function registerAction($id) {
        if ($this->session->has('login')) {
            if (count($this->post) > 0) {
                $task_data = [
                    'task_id' => $this->post->get('task_id'),
                    'date_entry' => $this->post->get('date_entry'),
                    'time_entry' => $this->post->get('time_entry')
                ];
                return new Response($this->model->entry($task_data));
            } else {
                $task_model = new TaskModel();
                $task = $task_model->getTaskById($id);
                $view = 'entry.html.twig';
                $title = 'Регистрация времени';
                return new Response($this->generateView($view, [
                            'page_title' => $title,
                            'task' => $task,
                            'login' => $this->session->get_session_var('login'),
                ]));
            }
        } else {
            return new Response('', 200, [
                'Location' => '/'
            ]);
        }
    }

    public function deleteAction() {
        if (isset($_COOKIE['login'])) {
            $this->session->set('login', $_COOKIE['login']);
        }
        if ($this->session->has('login')) {
            $id = $this->post->get('entry_id');
            $task_id = $this->post->get('task_id');
            return new Response($this->model->delete($id, $task_id));
        } else {
            return new Response('', 200, [
                'Location' => '/'
            ]);
        }
    }

    public function editAction($id) {
        if ($this->session->has('login')) {
            if (count($this->post) > 0) {
                $entry_data = [
                    'task_id' => $this->post->get('task_id'),
                    'entry_id' => $this->post->get('entry_id'),
                    'date_entry' => $this->post->get('date_entry'),
                    'time_entry' => $this->post->get('time_entry')
                ];
                return new Response($this->model->save($entry_data));
            } else {
                $entry = $this->model->getEntryById($id);
                $task_model = new TaskModel();
                $task = $task_model->getTaskById($entry['task_id']);
                $view = 'entry_edit.html.twig';
                $title = 'Изменение записи';
                return new Response($this->generateView($view, [
                            'page_title' => $title,
                            'entry' => $entry,
                            'task' => $task,
                            'login' => $this->session->get_session_var('login'),
                ]));
            }
        } else {
            return new Response('', 200, [
                'Location' => '/'
            ]);
        }
    }

}
