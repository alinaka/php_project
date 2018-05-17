<?php
function taskAction(){
    include '../private/Models/tasks_model.php';
    $view = 'task_view.php';
    $title = 'Задача';
    $get = $_GET;
    $id = $get['id'];
    $task = get_data_by_id($data, $id);
    generateResponse($view, [
                    'page_title' => $title,
                    'task' => $task]);
}