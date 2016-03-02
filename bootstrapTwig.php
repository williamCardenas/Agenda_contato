<?php
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(__DIR__.'/app/View');
$twig = new Twig_Environment($loader, array(
    //'cache' => __DIR__.'/cache',
    'cache' => false
));
$twig->addGlobal('url', $request->getBaseUrl());
