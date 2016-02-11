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
            default:
                echo "It works";
                break;
        }
    }

    public static function repeatOn($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=repeat%200");
    }

    public static function repeatOff($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=repeat%201");
    }

    public static function getPlaylist($app)
    {
        $array = [];
        var_dump($html =file_get_contents($app->rootUri . "/db/?cmd=playlist"));
        var_dump(explode(':', $html));
//        $dom = new \DOMDocument();
//        var_dump($dom->item(0));
//        $dom->loadHTML($html);
//        $xpath = new \DOMXpath($dom);


    }
}