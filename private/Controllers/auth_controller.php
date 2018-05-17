<?php 
function authAction(){
    session_start();
    include '../private/Models/tasks_model.php';
    $data = get_data($data);
    
    if (isset($_SESSION['login']) ) {
        
    echo "Вы уже авторизованы";
    } else if (isset($_COOKIE['login'])) {
        $_SESSION['login'] = $_COOKIE['login'];
    }
    else {
        $view = 'auth_view.php';
        $title = 'Авторизоваться';
        generateResponse($view, [
               'page_title' => $title,
        ]);
    }
};

function auth_postAction(){
    auth_user();
}
