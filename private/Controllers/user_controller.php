<?php
function userAction(){
    session_start();
    include '../private/Models/tasks_model.php';
    $data = get_data($data);
    
    if (isset($_SESSION['login'])){  
        echo "открыта сессия";
        $view = 'user_view.php';
        $title = 'Личная страница';
   } else {
        echo "не открыта сессия";
        $view = 'index_view.php';
        $title = 'Главная страница';
    }
    generateResponse($view, [
                    'page_title' => $title,
                    'data' => $data,
    ]);
}
