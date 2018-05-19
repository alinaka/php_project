<?php 
function authAction(){
        session_start();
        
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
