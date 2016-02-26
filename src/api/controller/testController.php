<?php
/**
 * Created by PhpStorm.
 * User: LocoMan
 * Date: 25/02/2016
 * Time: 17:26
 */

namespace api\controller;


class testController
{
    public static function test($app)
    {
        $html = file_get_contents($app->rootUri . '/');
        echo $html;
    }
}