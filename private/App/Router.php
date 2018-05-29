<?php
namespace alina\project\App;

class Router 
{
	static function run($controller_namespace){
		$controller = 'Index';
		$action = 'index';
		$get = null;

		$routes = explode('/', $_SERVER['REQUEST_URI']);

		if (!empty($routes[1])) {
			$controller = $routes[1];
		}
		if (!empty($routes[2])) {
			$action = $routes[2];
		}
		if (!empty($routes[3])) {
			$get = $routes[3];
		}

		$controller = $controller_namespace.
					ucfirst(strtolower($controller)) . 
					'Controller';
		$action = strtolower($action) . 'Action';
		
		if(class_exists($controller)){
			$controller = new $controller();
		} else {
			var_dump("Класс не задан");
		}
		if (method_exists($controller, $action)){
			$controller->$action($get);
		} else {
			var_dump("Метод не найден");
		}
	}

}