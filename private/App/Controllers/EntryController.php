<?php

namespace alina\project\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Framework\Session;
use Framework\Controller;
use alina\project\Models\EntryModel;
use alina\project\Models\TaskModel;

class EntryController extends Controller {

    private $model;
    private $session;
    private $post;

    public function __construct(ServerRequestInterface $request) {
        parent::__construct();
        $this->model = new EntryModel();
        $this->session = new Session();
        $this->session->start();
        $this->post = $request->getParsedBody();
    }

    public function registerAction(ServerRequestInterface $request) {
        if ($this->session->has('login')) {
            if (count($this->post) > 0) {
                $task_data = [
                    'task_id' => $this->post['task_id'],
                    'date_entry' => $this->post['date_entry'],
                    'time_entry' => $this->post['time_entry']
                ];
                return new HtmlResponse($this->model->entry($task_data));
            } else {
                $task_model = new TaskModel();
                $id = $request->getAttribute('id');
                $task = $task_model->getTaskById($id);
                $view = 'entry.html.twig';
                $title = 'Регистрация времени';
                return new HtmlResponse($this->generateView($view, [
                            'page_title' => $title,
                            'task' => $task,
                            'login' => $this->session->get_session_var('login'),
                ]));
            }
        } else {
            return new HtmlResponse('', 200, [
                'Location' => '/'
            ]);
        }
    }

    public function deleteAction() {
        if (isset($_COOKIE['login'])) {
            $this->session->set('login', $_COOKIE['login']);
        }
        if ($this->session->has('login')) {
            $id = $this->post['entry_id'];
            $task_id = $this->post['task_id'];
            return new HtmlResponse($this->model->delete($id, $task_id));
        } else {
            return new HtmlResponse('', 200, [
                'Location' => '/'
            ]);
        }
    }

    public function editAction(ServerRequestInterface $request) {
        if ($this->session->has('login')) {
            if (count($this->post) > 0) {
                $entry_data = [
                    'task_id' => $this->post['task_id'],
                    'entry_id' => $this->post['entry_id'],
                    'date_entry' => $this->post['date_entry'],
                    'time_entry' => $this->post['time_entry']
                ];
                return new HtmlResponse($this->model->save($entry_data));
            } else {
                $id = $request->getAttribute('id');
                $entry = $this->model->getEntryById($id);
                $task_model = new TaskModel();
                $task = $task_model->getTaskById($entry['task_id']);
                $view = 'entry_edit.html.twig';
                $title = 'Изменение записи';
                return new HtmlResponse($this->generateView($view, [
                            'page_title' => $title,
                            'entry' => $entry,
                            'task' => $task,
                            'login' => $this->session->get_session_var('login'),
                ]));
            }
        } else {
            return new HtmlResponse('', 200, [
                'Location' => '/'
            ]);
        }
    }

}
