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
        $data = $app->request->post();
        $rune = array(
            "id" => $data['id'],
            "ip" => $data['ip'],
            "label" => $data['label']
        );
        postRuneInfo($rune);
    });

    $app->get('/runeInfo', function() use ($app){
        header("Content-Type: application/json");
        if(file_exists('runeInfo.json')){
            $app->response->setStatus(200);
            $runeInfo = file_get_contents('runeInfo.json');
            echo $runeInfo;
        }else{
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "runeInfo",
                "message" => "There is no information to display"
            ));
        }
    });

    $app->run();
}


//fonction d'ecriture dans le fichier runeInfo
function postRuneInfo($rune)
{
    $file = fopen("runeInfo.json", "w+");

    // if file is not empty
    if ($file && filesize("runeInfo.json") != 0) {

        $data = fread($file, filesize("runeInfo.json"));
        $decode = json_decode($data);
        // on efface le contenu existant
        $ecrire = fopen('runeInfo.json', "w");
        ftruncate($ecrire, 0);
    }else{
        // if file is empty
        $decode = (object)array('runeInfo' => array());
    }

    //creation du json a ecrire
    array_push($decode->runeInfo, $rune);
    echo(json_encode($decode));
    //re encodage en json et ajout dans le fichier
    $str = json_encode($decode);
    fputs($file, $str);
    fclose($file);
}