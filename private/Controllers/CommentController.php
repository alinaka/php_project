<?php

namespace alina\project\Controllers;

use alina\project\App\Controller;
use Symfony\Component\HttpFoundation\Request;
use alina\project\App\Response;
use alina\project\App\Session;
use alina\project\Models\CommentModel;

class CommentController extends Controller {

    private $model;
    private $post;
    private $session;
    private $last_update;

    public function __construct() {
        parent::__construct();
        session_start();
        $this->model = new CommentModel();
        $this->post = Request::createFromGlobals()->request;
        $this->session = new Session();
    }

    public function addAction() {
        $comment_data = [
            'comment_text' => $this->post->get('comment_text'),
            'user_id' => 1,
            'task_id' => $this->post->get('task_id')
        ];
        return new Response($this->model->addComment($comment_data));
    }

    public function updateAction($new_time) {
        $comments = $this->model->getNewComments($this->last_update);

//        if ($comments){
        $dateObj = date_create_from_format('Y.m.j-G:i:s', $new_time);
        $this->last_update = $dateObj->format('Y-m-j G:i:s');
        var_dump($this->last_update);
//        }
        $response = json_encode($comments);
        return new Response($response);
    }

    public function deleteAction($get) {
        if (isset($_COOKIE['login'])) {
            $this->session->set_session_var('login', $_COOKIE['login']);
        }
        if ($this->session->is_session_var('login')) {
            $this->model->delete($get);
            return new Response('', [
                'Location' => '/'
            ]);
        } else {
            return new Response('', [
                'Location' => '/'
            ]);
        }
    }

}
