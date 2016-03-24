<?php
/**
 * Created by PhpStorm.
 * User: LocoMan
 * Date: 10/03/2016
 * Time: 16:14
 */

namespace api\controller;


class runeController
{
    public static function runes($app)
    {
        header("Content-Type: application/json");
        if(file_exists('runes.json')){
            $app->response->setStatus(200);
            $runes = file_get_contents('runes.json');
            echo $runes;
        }else{
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "runes",
                "message" => "There is no information to display"
            ));
        }
    }

    //fonction d'ecriture dans le fichier runeInfo
    public static function runesUpdate($app)
    {
        $runesArray = $app->request->getBody();
        // open and delete content
        $file = fopen("runes.json", "w+");
        // write array to file
        $obj = (object) array('runes' => array());
        foreach(json_decode($runesArray) as $rune){
            array_push($obj->runes, $rune);
        }

        echo json_encode($obj);
        fputs($file, json_encode($obj));
        fclose($file);
    }
}