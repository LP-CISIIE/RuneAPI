<?php

namespace api\controller;

class playerController
{
    public static function player($app, $action)
    {
        switch ($action) {
            case 'play' : self::play($app); break;
            case 'stop' : self::stop($app); break;
            case 'next' : self::next($app); break;
            case 'previous' : self::previous($app); break;
            default : echo 'it works'; break;
        }
    }

    public static function play($app)
    {
//        $app->response->headers->set('Content-Type', 'application/json');

        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=play');
        echo $html.'yolo';

        if($html == "OK "){
            echo json_encode(array(
                "Object" => "play",
                "message" => "Done"
            ));
        }else{
            echo json_encode(array(
                "Object" => "play",
                "message" => "Error"
            ));
        }
    }

    public static function stop($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=stop');
    }

    public static function next($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=next');
    }

    public static function previous($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=previous');
    }
}
