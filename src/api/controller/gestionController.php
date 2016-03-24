<?php

namespace api\controller;

class gestionController
{
    public static function change($app, $pos, $temps)
    {

    	$app->response->headers->set('Content-Type', 'application/json');
        $html = file_get_contents($app->rootUri . 'command/?cmd=seek%20'.$pos.'%20'.$temps);

        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "SetTimerMusic",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "SetTimerMusic",
                "message" => $html
            ));
        }

    }
}

?>