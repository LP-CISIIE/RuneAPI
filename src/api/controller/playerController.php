<?php

namespace api\controller;

class playerController
{
    public static function player($app, $action)
    {
        switch ($action) {
            case 'play' :
                self::play($app);
                break;
            case 'pause' :
                self::pause($app);
                break;
            case 'stop' :
                self::stop($app);
                break;
            case 'next' :
                self::next($app);
                break;
            case 'previous' :
                self::previous($app);
                break;
            default :
                echo 'it works';
                break;
        }
    }

    public static function play($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');

        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=play');
        $response = mb_convert_encoding($html, 'UTF-8');

        if(strcmp("OK ", $response)){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "play",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
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
        $response = mb_convert_encoding($html, 'UTF-8');

        if(strcmp("OK ", $response)){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "stop",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "stop",
                "message" => "Error"
            ));
        }

    }

    public static function pause($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=pause');
        $response = mb_convert_encoding($html, 'UTF-8');

        if(strcmp("OK ", $response)){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "pause",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "pause",
                "message" => "Error"
            ));
        }
    }

    public static function next($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=next');
        $response = mb_convert_encoding($html, 'UTF-8');

        if(strcmp("OK ", $response)){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "next",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "next",
                "message" => "Error"
            ));
        }
    }

    public static function previous($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=previous');
        $response = mb_convert_encoding($html, 'UTF-8');

        if(strcmp("OK ", $response)){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "previous",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "previous",
                "message" => "Error"
            ));
        }
    }
}
