<?php
function regAction(){
    session_start();
    
    if (isset($_SESSION['login']) ) {
        echo "Вы уже авторизованы";
    } else if (isset($_COOKIE['login'])) {
        $_SESSION['login'] = $_COOKIE['login'];
    }
    else {
        $view = 'reg_view.php';
        $title = 'Зарегистрироваться';
    
        generateResponse($view, [
                     'page_title' => $title,
    ]);
    }
}

function reg_postAction(){
    reg_user();
}

?>