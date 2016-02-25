<?php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

include './route.php';

$request = Request::createFromGlobals();
$response = new Response();

$path = $request->getPathInfo();

if (isset($routes[$path])) {
    $arr = explode('@',$routes[$path]);
    $class = "App\Controller\\".$arr[0];
    $method = !empty($arr[1])?$arr[1]:'index';

    $instanceController = new $class;
    $instanceController->$method();
    
} else {
    $response->setStatusCode(404);
    $response->setContent('Not Found');
}

$response->send();
