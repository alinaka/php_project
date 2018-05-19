<?php
function taskAction(){
    session_start();
    include '../private/Models/tasks_model.php';
    if (isset($_SESSION['login'])){
        $view = 'task_view.php';
        $title = 'Задача';
        $get = $_GET;
        $id = $get['id'];
        $task = get_data_by_id($data, $id);
    } else {
        echo "не открыта сессия";
        $view = 'index_view.php';
        $title = 'Главная страница';
    }
    generateResponse($view, [
                    'page_title' => $title,
                    'task' => $task]);
}