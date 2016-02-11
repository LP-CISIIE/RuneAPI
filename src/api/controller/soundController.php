<?php

namespace api\controller;

class soundController
{
    public static function volume($app, $vol)
    {

    	$file = file_get_contents($app->rootUri.'/command/?cmd=setvol%200'.$vol);
    	

    }
}