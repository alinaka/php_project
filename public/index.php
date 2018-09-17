<?php
use Zend\Diactoros\Response\SapiEmitter;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$urls = file_get_contents('config.json');
$app = new \Framework\Http\Router\App($urls); 

$response = $app->run();

$response = $response->withHeader('X-Developer', 'Alinakago');
### Sending
$emitter = new SapiEmitter();
$emitter->emit($response);
