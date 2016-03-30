<?php
/**
 * Created by PhpStorm.
 * User: LocoMan
 * Date: 31/03/2016
 * Time: 00:45
 */

namespace api\controller;


class debugController
{
    public static function debug($app)
    {
        // connect to the database
        $redis = new \Redis();
        $redis->pconnect('127.0.0.1');

        $data= $redis->get('debugdata');
        echo json_encode($data);
    }
}