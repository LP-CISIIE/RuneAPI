<?php
/**
 * Created by PhpStorm.
 * User: LocoMan
 * Date: 11/02/2016
 * Time: 16:14
 */

namespace api\controller;

require_once('/var/www/app/libs/runeaudio.php');

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
            case 'randomOn' :
                self::randomOn($app);
                break;
            case 'randomOff' :
                self::randomOff($app);
                break;
            case 'soundRepeatOn' :
                self::soundRepeatOn($app);
                break;
            case 'soundRepeatOff' :
                self::soundRepeatOff($app);
                break;
            case 'filepath' :
                self::getFilePath($app);
                break;
            default:
                echo "It works";
                break;
        }
    }

    public static function getFilePath($app){
        $html = file_get_contents($app->rootUri . "/db/?cmd=filepath");
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "get file path",
                "message" => $response
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "get file path",
                "message" => $html
            ));
        }
    }

    public static function soundRepeatOn($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=single%201");
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "sound repeat on",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "repeat off",
                "message" => $html
            ));
        }
    }

    public static function soundRepeatOff($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=single%201");
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "sound repeat on",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "repeat off",
                "message" => $html
            ));
        }
    }


    public static function repeatOff($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=repeat%200");
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "repeat on",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "repeat off",
                "message" => $html
            ));
        }
    }

    public static function repeatOn($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=repeat%201");
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "repeat off",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "repeat off",
                "message" => $html
            ));
        }
    }

    public static function getPlaylist($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $socket = openMpdSocket('/run/mpd.sock');
        sendMpdCommand($socket, 'playlistinfo');
        $infos = readMpdResponse($socket);
        $obj = array("infos" => self::parsePlaylist($infos));
        echo json_encode($obj);
    }

    public static function randomOff($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=random%200");
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "random on",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "random on",
                "message" => $html
            ));
        }
    }

    public static function randomOn($app)
    {
        $html = file_get_contents($app->rootUri . "/command/?cmd=random%201");
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "random off",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "random off",
                "message" => $html
            ));
        }
    }

    public static function playlist_add($app, $url)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=add'.$url);
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "=== Add ".$url. " ===",
                "message" => "Done".$html
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "=== Error adding ".$url. " ===",
                "message" => $html
            ));
        }
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