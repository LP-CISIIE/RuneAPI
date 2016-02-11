<?php
/**
 * Created by PhpStorm.
 * User: LocoMan
 * Date: 11/02/2016
 * Time: 16:14
 */

namespace api\controller;


class playlistController
{
    public static function playlist($app, $action)
    {
        switch($action) {
            case 'repeatOn' :
                self::repeatOn($app);
                break;
            case 'repeatOff' :
                self::repeatOff($app);
                break;
            case 'playlist' :
                self::getPlaylist($app);
                break;
            case 'randomOn' :
                self::randomOn($app);
                break;
            case 'randomOff' :
                self::randomOff($app);
                break;
            default:
                echo "It works";
                break;
        }
    }

    public static function repeatOff($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=repeat%200");
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "repeat on",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "repeat off",
                "message" => $html
            ));
        }
    }

    public static function repeatOn($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=repeat%201");
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "repeat off",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "repeat off",
                "message" => $html
            ));
        }
    }

    public static function getPlaylist($app)
    {
        $values = array();
        echo $html = file_get_contents($app->rootUri . "/db/?cmd=playlist");
        var_dump($content = preg_match("#le*:#", $html));

//        $dom = new \DOMDocument();
//        var_dump($dom->item(0));
//        $dom->loadHTML($html);
//        $xpath = new \DOMXpath($dom);


    }

    public static function randomOff($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=random%200");
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "random on",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "random on",
                "message" => $html
            ));
        }
    }

    public static function randomOn($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=random%201");
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "random off",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "random off",
                "message" => $html
            ));
        }
    }
}