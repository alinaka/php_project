<?php
namespace alina\project\App;

class Controller
{
//	public function generateView($view,$data = []){
//		if(is_array($data)){
//			extract($data);
//		}
//		include '../private/Views/template.php'; // должна быть переменная
//	}
    
    private $template_maker;
    
protected function generateView($view, $data = []){
    $this->template_maker = new Template();
    return $this->template_maker->renderView($view, $data);
}
    
}