<?php
namespace alina\project\App;

class Controller
{
    private $template_maker;
    
    protected function __construct(){
        $this->template_maker = new Template();
    }
    
    protected function generateView($view, $data = []){
        return $this->template_maker->renderView($view, $data);
    }
    
}