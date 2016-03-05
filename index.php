<?php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

include './route.php';
include './bootstrap.php';

$request = Request::createFromGlobals();

include './bootstrapTwig.php';

$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);

    $arr = explode('@',$controller);
    $class = "App\Controller\\".$arr[0];
    $method = !empty($arr[1])?$arr[1]:'index';
    $instanceController = new $class($request,$twig,$matcher);
    $view = $instanceController->$method();

    $response = new Response($view,
    Response::HTTP_OK,
    array('content-type' => 'text/html'));
} catch (Routing\Exception\ResourceNotFoundException $e) {
    $response = new Response('Not Found', 404);
} catch (UnexpectedValueException $e){
    $response = new Response('Not Found', 200);
    $response->setContent(json_encode($view));
    $response->headers->set('Content-Type', 'application/json');
} catch (Exception $e) {
    var_dump($e);
    $response = new Response('An error occurred', 500);
}
$response->send();
