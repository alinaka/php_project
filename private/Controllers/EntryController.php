<?php
namespace alina\project\Controllers;
use alina\project\App\Controller;
use alina\project\Models\EntryModel;
use alina\project\App\Session;
use alina\project\App\Request;
use alina\project\App\Response;

class EntryController extends Controller
{
    private $model;
    private $session;
    private $request;
    
    public function __construct(){
        parent::__construct();
        session_start();
        $this->model = new EntryModel();
        $this->session = new Session();
        $this->request = new Request();
    }
  
    public function registerAction($get){
        if ($this->session->is_session_var('login')){
            if(count($_POST) > 0){
                $post = $this->request->post();
                $task_data = [
                    'task_id' => $post['task_id'],
                    'date_entry' => $post['date_entry'],
                    'time_entry' => $post['time_entry']
                ];
                return new Response($this->model->entry($task_data));
            } else {
                $id = $get;
                $view = 'entry.html.twig';
                $title = 'Регистрация времени';
                return new Response($this->generateView($view, [
                        'task_id'=>$id,
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
}