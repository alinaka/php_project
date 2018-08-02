<?php

namespace alina\project\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use alina\project\App\Controller;
use alina\project\Models\CommentModel;

class CommentController extends Controller {

    private $model;
    private $post;
    private $session;
    private $last_update;

    public function __construct() {
        parent::__construct();
        $this->model = new CommentModel();
        $this->post = Request::createFromGlobals()->request;
        $this->session = new Session();
        $this->session->start();
    }

    public function addAction() {
        $comment_data = [
            'comment_text' => $this->post->get('comment_text'),
            'user_id' => 1,
            'task_id' => $this->post->get('task_id')
        ];
        return new Response($this->model->addComment($comment_data));
    }

    public function deleteAction() {
        if (isset($_COOKIE['login'])) {
            $this->session->set('login', $_COOKIE['login']);
        }
        if ($this->session->has('login')) {
            $id = $this->post->get('comment_id');
            return new Response($this->model->delete($id));
        } else {
            return new Response('', 200, [
                'Location' => '/'
            ]);
        }
    }

}
