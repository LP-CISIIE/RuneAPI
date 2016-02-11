<?php

namespace api\controller;

class soundController
{
    public static function volume($app, $vol)
    {
        $app->response->headers->set('Content-Type', 'application/json');

        $html = file_get_contents($app->rootUri . '/command/?cmd=setvol%200' . $vol);
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "volume",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "play",
                "message" => $html
            ));
        }

    }
}