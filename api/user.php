<?php 

require __DIR__ . '/../vendor/autoload.php';

use Base_php\App\Controllers\UserController;

$method = strtolower($_SERVER['REQUEST_METHOD']);

$controller = new UserController();

switch($method){
    case 'post':
        $controller->register();
        break;
    case 'get':
        $controller->select();
        break;
}