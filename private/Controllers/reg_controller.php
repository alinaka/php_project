<?php
function regAction(){
    $view = 'reg_view.php';
    $title = 'Зарегистрироваться';
    
    generateResponse($view, [
                     'page_title' => $title,
    ]);
}

function reg_postAction(){
    reg_user();
}

?>