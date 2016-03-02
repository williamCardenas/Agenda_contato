<?php
// bootstrap.php
require_once "vendor/autoload.php";
/*
$pdo = new PDO('mysql:host=localhost;dbname=agenda_app', 'root', '');
*/
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection(array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'agenda_app',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => ''
));

$capsule->bootEloquent();
