<?php
/*
$routes = [
        '/' => 'DeshboardController'
];
*/
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$routes = new RouteCollection();

$routes->add('Deshboard', new Route('/', ['controller'=>'DeshboardController']));

$routes->add('contato/lista/page', new Route('/contato/lista/pagina/{page}',['controller'=>'ContatoController@list']));
$routes->add('contato/lista', new Route('/contato/lista',['controller'=>'ContatoController@list']));
$routes->add('contato/novo', new Route('/contato/novo',['controller'=>'ContatoController@new']));
$routes->add('contato/save', new Route('/contato/save',['controller'=>'ContatoController@save']));
$routes->add('contato/edita', new Route('/contato/editar/{id}',['controller'=>'ContatoController@edit']));
$routes->add('contato/update', new Route('/contato/update/{id}',['controller'=>'ContatoController@update']));
$routes->add('contato/deleta', new Route('/contato/deletar/{id}',['controller'=>'ContatoController@delete']));

$routes->add('contato/detalhe', new Route('/api/contato/detalhe',['controller'=>'ApiContatoController@contatoDetail']));

return $routes;
