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

	$app->put('/mpd/:output', function($output) use ($app) {
		mdpController::setOutput($app, $output);
	})->name('setOutput');

    $app->get('/settings', function() use ($app) {
        settingsController::settings($app);
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

    $app->get('/network/edit/:net', function($net) use ($app) {
        networkController::setNetwork($net,$app);
    })->name('setNetwork');

    $app->post('/runeInfo', function() use ($app){
        //$texte = $app->request->getBody();
        $texte = array(
            "id" => 3,
            "ip" => "192.136.0.3",
            "nom" => "chambre"
        );
        postRuneInfo($texte);
    });

    $app->get('/runeInfo', function() use ($app){
        header("Content-Type: application/json");
        if(file_exists('runeInfo.json')){
            $runeInfo = file_get_contents('runeInfo.json');
            echo $runeInfo;
        }
    });

    $app->run();
}


//fonction d'ecriture dans le fichier runeInfo
function postRuneInfo($texte){
    $file = fopen("runeInfo.json", "r+");
    $runeInfo = file_get_contents("runeInfo.json");
    $decode = json_decode($runeInfo);

    // on efface le contenu existant
    $ecrire = fopen('runeInfo.json',"w");
    ftruncate($ecrire,0);
    //creation du json a ecrire
    array_push($decode->runeInfo, $texte);
    //re encodage en json et ajout dans le fichier
    $str = json_encode($decode);
    fputs($file, $str);
    fclose($file);
}