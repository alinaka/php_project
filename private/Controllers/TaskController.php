<?php
namespace alina\project\Controllers;
use alina\project\App\Controller;
use alina\project\Models\TaskModel;

class TaskController extends Controller
{
    private $model;
    
    function __construct(){
        $this->model = new TaskModel();
    }

    function showAction($get){
        session_start();
        if (isset($_SESSION['auth'])){
            $data = $this->model->get_data();
            $view = 'task_view.php';
            $title = 'Задача';
            // $get = $get;
            $id = $get;
            $task = $this->model->get_data_by_id($data, $id);
            $this->generateView($view, [
                        'page_title' => $title,
                        'task' => $task]);
        } else {
            header('Location: /');
            exit();
        }
    }
}