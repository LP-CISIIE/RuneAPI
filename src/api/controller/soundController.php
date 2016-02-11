<?php

namespace api\controller;

class soundController
{
    public static function volume($app, $vol)
    {
    	header('Content-Type: application/json');
    	header("HTTP/1.0 200 OK");
    	$file = file_get_contents($app->rootUri.'/command/?cmd=setvol%200'.$vol);
    	$array = array('volume' => $vol );
    	echo json_encode($array);
    }
}