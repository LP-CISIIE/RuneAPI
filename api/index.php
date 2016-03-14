<?php

require '../vendor/autoload.php';

use api\controller\settingsController;
use api\controller\playerController;
use api\controller\playlistController;
use api\controller\soundController;
use api\controller\sourcesController;
use api\controller\gestionController;
use api\controller\testController;
use api\controller\mdpController;
use api\controller\networkController;
use api\controller\runeController;
use api\controller\debugController;

$app = new Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
));
$app->contentType('text/html; charset=utf-8');
$config = parse_ini_file('config.ini');

if($config){
    $app->rootUri = 'http://'.$config['ip'];

    $app->get('/', function() use ($app, $config) {
        echo "ça marche";
    });


    $app->get('/gestion/:pos/:temps', function($pos, $temps) use ($app) {
        gestionController::change($app, $pos, $temps);
    })->name('gestion');

	$app->get('/mpd', function() use ($app) {
		mdpController::getMpd($app);
	})->name('mpd');

    $app->post('/mpd', function() use ($app) {
       mdpController::setOutput($app);
    })->name('setOutput');

    $app->get('/settings', function() use ($app) {
        settingsController::settings($app);
    })->name('annoncesId');

    $app->put('/settings', function() use ($app) {
        settingsController::settingsUpdate($app);
    })->name('annoncesId');

    $app->get('/player/:action', function($action) use ($app) {
        playerController::player($app, $action);
    })->name('player');

    $app->get('/playlist/:action', function($action) use ($app) {
        playlistController::playlist($app, $action);
    })->name('playlist');

    $app->get('/volume/:vol', function($vol) use ($app) {
        soundController::volume($app, $vol);
    })->name('volume');

    $app->get('/sources', function() use ($app) {
        sourcesController::index($app);
    })->name('sources');

    $app->put('/sources', function() use ($app) {
        sourcesController::rebuild($app);
    })->name('rebuild');

    $app->get('/test', function() use ($app) {
        testController::test($app);
    })->name('test');

    $app->get('/network', function() use ($app) {
        networkController::getNetwork($app);
    })->name('network');

    $app->post('/network', function() use ($app) {
        networkController::setNetwork($app);
    })->name('ModifNetwork');

    $app->get('/network/edit/:net', function($net) use ($app) {
        networkController::ChooseNetwork($net,$app);
    })->name('setNetwork');

    $app->get('/runes', function() use ($app){
        runeController::runes($app);
    });

    $app->put('/runes', function() use ($app){
        runeController::runesUpdate($app);
    });

    $app->get('/debug', function() use ($app){
        debugController::getLog($app);
    });


    $app->run();
}