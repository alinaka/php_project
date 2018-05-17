<?php

include '../private/Models/reg_auth_logout.php';
include '../private/Controllers/index_controller.php';
include '../private/Controllers/reg_controller.php';
include '../private/Controllers/auth_controller.php';
include '../private/Controllers/user_controller.php';
include '../private/Controllers/task_controller.php';
include '../private/Controllers/logout_controller.php';

function runController(){
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $action = trim($uri, "/") ? : 'index';
    $action = $action . "Action";
    $action();
}

runController();