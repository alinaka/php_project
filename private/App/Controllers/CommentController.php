<?php

namespace alina\project\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Framework\Controller;
use Framework\Session;
use alina\project\Models\CommentModel;

class CommentController extends Controller {

    private $model;
    private $post;
    private $session;
    private $last_update;

    public function __construct(ServerRequestInterface $request) {
        parent::__construct();
        $this->model = new CommentModel();
        $this->post = $request->getParsedBody();
        $this->session = new Session();
        $this->session->start();
    }

    public function addAction() {
        $comment_data = [
            'comment_text' => $this->post['comment_text'],
            'user_id' => 1,
            'task_id' => $this->post['task_id']
        ];
        return new HtmlResponse($this->model->addComment($comment_data));
    }

    public function deleteAction() {
        if (isset($_COOKIE['login'])) {
            $this->session->set('login', $_COOKIE['login']);
        }
        if ($this->session->has('login')) {
            $id = $this->post['comment_id'];
            return new HtmlResponse($this->model->delete($id));
        } else {
            return new HtmlResponse('', 200, [
                'Location' => '/'
            ]);
        }
    }

}
