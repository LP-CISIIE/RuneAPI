<?php

require '../vendor/autoload.php';
use api\controller\settingsController;
use api\controller\playerController;
use api\controller\playlistController;

$app = new Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
));
$app->contentType('text/html; charset=utf-8');
$app->rootUri = "http://192.168.1.14";

$app->get('/', function() use ($app) {
	echo "ça marche";
});

$app->get('/settings', function() use ($app) {
    settingsController::settings($app);
})->name('annoncesId');

$app->get('/player/:action', function($action) use ($app) {
    playerController::player($app, $action);
})->name('player');

$app->get('/playlist/:action', function($action) use ($app) {
    playlistController::playlist($app, $action);
})->name('playlist');

$app->run();