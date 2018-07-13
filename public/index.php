<?php
require_once __DIR__ . '/../vendor/autoload.php';
//use alina\project\App\Router;

//Router::run("alina\project\Controllers\\");

$urls = file_get_contents('../config.json');
$app = new \alina\project\App\App($urls);
$app->run();

?>