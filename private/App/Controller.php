<?php
namespace alina\project\App;

class Controller
{
	public function generateView($view, 
									$data = []
									){
		if(is_array($data)){
			extract($data);
		}

		include '../private/Views/template.php'; // должна быть переменная
	}
}