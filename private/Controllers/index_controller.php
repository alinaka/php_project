<?php
function generateResponse($view, $data = []){
    if (is_array($data)){
        extract($data);
    }
    require_once '../private/Views/template.php';
}

function indexAction(){
    $view = 'index_view.php';
    $title = 'Главная страница';
    
    generateResponse($view, [
                        'page_title' => $title,
    ]);
}
?>
