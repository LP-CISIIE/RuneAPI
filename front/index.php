<?php
/**
 * Created by PhpStorm.
 * User: locoman
 * Date: 12/01/16
 * Time: 15:45
 */

require '../vendor/autoload.php';

use front\controller\indexController;

// Connection à la base avec Eloquent
$app = new Slim\Slim(array(
    'view' => new Slim\Views\Twig(),
    'templates.path' => '../src/front/templates'
));

$app->get('/', function() use ($app) {
    indexController::index($app);
})->name('index');




$app->run();