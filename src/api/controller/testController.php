<?php
/**
 * Created by PhpStorm.
 * User: LocoMan
 * Date: 25/02/2016
 * Time: 17:26
 */

namespace api\controller;
require_once('/var/www/app/libs/runeaudio.php');

class testController
{
    public static function test($app)
    {
//        $app->response->headers->set('Content-Type', 'application/json');
//        $socket = openMpdSocket('/run/mpd.sock');
//        sendMpdCommand($socket, 'playlistinfo');
//        $infos = readMpdResponse($socket);
//        $obj = array("infos" => self::parsePlaylist($infos));
//        echo json_encode($obj);

        // connect to the database
        $redis = new \Redis();
        $redis->pconnect('127.0.0.1');
        
        $data= $redis->get('debugdata');
        var_dump($data);
    }

    public static function parsePlaylist($resp)
    {
        if (is_null($resp)) {
            return null;
        } else {
            $dirCounter=-1;
            $plistArray = array();
            $plistLine = strtok($resp, "\n");
            // $plistFile = "";
            $plCounter = -1;
            $browseMode = TRUE;
            while ($plistLine) {
                if($plistLine == "OK")
                    break;
                // list ( $element, $value ) = explode(": ",$plistLine);
                if (!strpos($plistLine, '@eaDir')) list ($element, $value) = explode(': ', $plistLine, 2);
                if ($element === 'file' OR $element === 'playlist') {
                    $plCounter++;
                    $browseMode = FALSE;
                    // $plistFile = $value;
                    $plistArray[$plCounter][$element] = $value;
                    $plistArray[$plCounter]['fileext'] = parseFileStr($value, '.');
                } elseif ($element === 'directory') {
                    $plCounter++;
                    // record directory index for further processing
                    $dirCounter++;
                    // $plistFile = $value;
                    $plistArray[$plCounter]['directory'] = $value;
                } else if ($browseMode) {
                    if ($element === 'Album') {
                        $plCounter++;
                        $plistArray[$plCounter]['album'] = $value;
                    } else if ($element === 'Artist') {
                        $plCounter++;
                        $plistArray[$plCounter]['artist'] = $value;
                    } else if ($element === 'Genre') {
                        $plCounter++;
                        $plistArray[$plCounter]['genre'] = $value;
                    }
                } else {
                    $plistArray[$plCounter][$element] = $value;
//                    $plistArray[$plCounter]['Time2'] = songTime($plistArray[$plCounter]['Time']);
                }
                $plistLine = strtok("\n");
            }
        }
        return $plistArray;
    }
}