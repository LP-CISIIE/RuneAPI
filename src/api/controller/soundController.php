<?php

namespace api\controller;

class soundController
{
    public static function volume($app, $vol)
    {
    	$file = file_get_contents($app->rootUri.'/command/?cmd=setvol%200'.$vol);
    	$array = array('volume' => $vol,
    					"HTTP" => 200,
               			"Object" => "volume",
               			"message" => "Done");
    	echo json_encode($array);
    }
}