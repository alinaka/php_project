<?php
namespace alina\project\Controllers;
use alina\project\App\Controller;
use alina\project\Models\TaskModel;

class UserController extends Controller
{
    private $model;
    
    function __construct(){
        $this->model = new TaskModel();
    }
    function indexAction(){
        session_start();
        $data = $this->model->get_data();
        if (isset($_COOKIE['login'])) {
            $_SESSION['auth'] = true;
            $_SESSION['login'] = $_COOKIE['login'];
        }
        if ($_SESSION['auth']){
            $view = 'user_view.php';
            $title = 'Личная страница';
            $this->generateView($view, [
                        'page_title' => $title,
                        'data' => $data,
            ]);
        } else {
            header('Location: /');
            exit();
        }
        
    }
}
