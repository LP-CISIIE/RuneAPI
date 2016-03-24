<?php

namespace api\controller;

require_once('/var/www/app/libs/runeaudio.php');

class playerController
{
    public static function player($app, $action)
    {
        switch ($action) {
            case 'play' :
                self::play($app);
                break;
            case 'pause' :
                self::pause($app);
                break;
            case 'stop' :
                self::stop($app);
                break;
            case 'next' :
                self::next($app);
                break;
            case 'previous' :
                self::previous($app);
                break;
            default :
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setStatus(400);
                echo json_encode(array(
                    "HTTP" => 400,
                    "Object" => "action",
                    "message" => "Wrong or missing parameter"
                ));
                break;
        }
    }

    public static function play($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');

        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=play');
        // delete the blank space from the answer
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "play",
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

    public static function stop($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=stop');
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "stop",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "stop",
                "message" => $html
            ));
        }

    }

    public static function pause($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=pause');
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "pause",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "pause",
                "message" => $html
            ));
        }
    }

    public static function next($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=next');
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "next",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "next",
                "message" => $html
            ));
        }
    }

    public static function previous($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . '/command/?cmd=previous');
        $response = trim($html);

        if($response == 'OK'){
            $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "Object" => "pevious",
                "message" => "Done"
            ));
        }else{
            $app->response->setStatus(500);
            echo json_encode(array(
                "HTTP" => 500,
                "Object" => "previous",
                "message" => $html
            ));
        }
    }

    public static function playerStatus($app) {
        $app->response->headers->set('Content-Type', 'application/json');
        $socket = openMpdSocket('/run/mpd.sock');
        sendMpdCommand($socket, 'status');
        $infos = readMpdResponse($socket);
        $obj = array("infos" => self::parsePlaylist($infos));
        echo json_encode($obj);
    }

    public static function currentSong($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $socket = openMpdSocket('/run/mpd.sock');
        sendMpdCommand($socket, 'currentsong');
        $song = readMpdResponse($socket);
        $obj = array("song" => self::parsePlaylist($song));
        echo json_encode($obj);
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
