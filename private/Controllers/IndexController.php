<?php
namespace alina\project\Controllers;
use alina\project\App\Controller;

class IndexController extends Controller
{

	function indexAction(){
	    $view = 'index_view.php';
	    $title = 'Главная страница';
	    $this->generateView($view, [
	                        'page_title' => $title,
	    ]);
	}
}