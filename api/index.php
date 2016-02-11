<?php

require '../vendor/autoload.php';
use api\controller\settingsController;



$app = new Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
));

$app->contentType('text/html; charset=utf-8');


$app->get('/', function() use ($app) {
	echo "ça marche";
});


$app->get('/settings', function() use ($app) {

    settingsController::settings($app);
})->name('annoncesId');


$app->run();