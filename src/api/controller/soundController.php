<?php

namespace api\controller;

class soundController
{
    public static function volume($app, $vol)
    {
    	//$app->response->headers->set('Content-Type', 'application/json');
    	$array = array();
    	$file = file_get_contents($app->rootUri.'/command/?cmd=setvol%200'.$vol);
    	
    	//si 400 ou 500
    	if (!isset($http_response_header[0]) || preg_match("#[4-5][0-9]{2}#", $http_response_header[0])) {
        	array_push($array,array('volume' => $vol,
        							'Code'=> $http_response_header[0]

        		) );
    	} else {
    	array_push($array,array('volume' => $vol,
    							'code' => $http_response_header[0]
    		) );

    	}

    	
    	echo json_encode($array);
    	
    }
}