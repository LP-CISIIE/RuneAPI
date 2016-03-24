<?php

namespace api\controller;
include_once("simple_html_dom.php");
require_once('/var/www/app/libs/runeaudio.php');
use api\controller\playerController;
//include('/srv/http/app/config/config.php');
ini_set('display_error', 1);
ini_set('error_reporting', E_ALL | E_STRICT);


class settingsController
{
    public static function settings($app)
    {
        function getState($state)
        {
            $value = 0;
            if ($state->getAttribute('class') == "boxed-group") {
                $value = "1";
            } else {
                $value = '0';
            };
            return $value;
        }

        $html = new simple_html_dom();
        $html->load_file('http://192.168.1.14/settings');
        $selects = $html->find('select');
        $inputs = $html->find('input');
        $boxes = $html->find('#features-management', 0);

        // connect to the database
        $redis = new \Redis();
        $redis->pconnect('127.0.0.1');

        $obj = array(
            "settings" => array(
                "environment" => array(
                    "hostname" => $inputs[0]->getAttribute('value'),
                    "ntp_server" => $inputs[1]->getAttribute('value'),
                    "timezone" => $selects[0]->find('option[selected]', 0)->value
                ),
                "kernel" => array(
                    "linux_kernel" => $selects[1]->find('option[selected]', 0)->value,
                    "i2s_modules" => "bonjour",
                    "sound_signature" => $selects[3]->find('option[selected]', 0)->value
                ),
                "features" => array(
                    "airplay" => $redis->hGet('airplay', 'enable'),
                    "airplay_name" => $redis->hGet('airplay', 'name'),
                    "spotify" => $redis->hGet('spotify', 'enable'),
                    "spotify_username" => $redis->hGet('spotify', 'user'),
                    "spotify_password" => $redis->hGet('spotify', 'pass'),
                    "upnp_dlna" => $redis->hGet('dlna', 'enable'),
                    "upnp_dlna_name" => $redis->hGet('dlna', 'name'),
                    "usb_automount" => "unknown",
                    "display_album_cover" => "unknown",
                    "lastfm" => $redis->hGet('lastfm', 'enable'),
                    "lastfm_username" => $redis->hGet('lastfm', 'user'),
                    "lastfm_password" => $redis->hGet('lastfm', 'pass'),
                ),
                "compatibility_fix" => array(
                    "cmedia_fix" => "unknown"
                )
            )
        );
        echo json_encode($obj);
    }

    public static function settingsUpdate($app)
    {
//        $app->response->headers->set('Content-Type', 'application/json');
        $data = json_decode($app->request->getBody());
        var_dump($data);

        $data = array(
            "features[airplay][enable]" => (empty($data->airplay)) ? 'défaut' : $data->airplay,
            "features[airplay][name]" => (empty($data->airplay_name)) ? null : $data->airplay_name,
            "features[spotify][enable]" => (empty($data->spotify)) ? 'défaut' : $data->spotify,
            "features[spotify][user]" => (empty($data->spotify_user)) ? null : $data->spotify_user,
            "features[spotify][pass]" => (empty($data->spotify_pass)) ? null : $data->spotify_pass,
            "features[dlna][enable]" => (empty($data->dlna)) ? 'défaut' : $data->dlna,
            "features[dlna][name]" => (empty($data->dlna_name)) ? null : $data->dlna_name,
            "features[udevil]" => (empty($data->udevil)) ? 'défaut' : $data->udevil,
            "features[coverart]" => (empty($data->coverart)) ? 'défaut' : $data->coverart,
            "features[lastfm][enable]" => (empty($data->lastfm)) ? 'défaut' : $data->lastfm,
            "features[lastfm][user]" => (empty($data->lastfm_user)) ? null : $data->lastfm_user,
            "features[lastfm][pass]" => (empty($data->lastfm_pass)) ? null : $data->lastfm_pass,
//            "features[submit]" => "1"
        );

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
            )
        );

        $context = stream_context_create($opts);
        $result = file_get_contents($app->rootUri . "/settings/", false, $context);
    }

    public static function settingsTest($app)
    {
        $socket = openMpdSocket('/run/mpd.sock');
//        $status = sysCmd("mpc status | grep '\[' | cut -d '[' -f 2 | cut -d ']' -f 1");
//        $sock = openSpopSocket('127.0.0.1', '80', 1);
//        $song = getTrackInfo($socket, '1');
        sendMpdCommand($socket, 'status');
        $song = readMpdResponse($socket);
//        var_dump(self::parsePlaylist($song));
        echo json_encode(playerController::parsePlaylist($song));

//        $curTrack = getTrackInfo($socket, 2);
//        var_dump($curTrack);
//        ui_status($mpd, $status);

    }

//    public static function parsePlaylist($resp)
//    {
//        if (is_null($resp)) {
//            return null;
//        } else {
//            $dirCounter=-1;
//            $plistArray = array();
//            $plistLine = strtok($resp, "\n");
//            // $plistFile = "";
//            $plCounter = -1;
//            $browseMode = TRUE;
//            while ($plistLine) {
//                if($plistLine == "OK")
//                    break;
//                // list ( $element, $value ) = explode(": ",$plistLine);
//                if (!strpos($plistLine, '@eaDir')) list ($element, $value) = explode(': ', $plistLine, 2);
//                if ($element === 'file' OR $element === 'playlist') {
//                    $plCounter++;
//                    $browseMode = FALSE;
//                    // $plistFile = $value;
//                    $plistArray[$plCounter][$element] = $value;
//                    $plistArray[$plCounter]['fileext'] = parseFileStr($value, '.');
//                } elseif ($element === 'directory') {
//                    $plCounter++;
//                    // record directory index for further processing
//                    $dirCounter++;
//                    // $plistFile = $value;
//                    $plistArray[$plCounter]['directory'] = $value;
//                } else if ($browseMode) {
//                    if ($element === 'Album') {
//                        $plCounter++;
//                        $plistArray[$plCounter]['album'] = $value;
//                    } else if ($element === 'Artist') {
//                        $plCounter++;
//                        $plistArray[$plCounter]['artist'] = $value;
//                    } else if ($element === 'Genre') {
//                        $plCounter++;
//                        $plistArray[$plCounter]['genre'] = $value;
//                    }
//                } else {
//                    $plistArray[$plCounter][$element] = $value;
////                    $plistArray[$plCounter]['Time2'] = songTime($plistArray[$plCounter]['Time']);
//                }
//                $plistLine = strtok("\n");
//            }
//        }
//        return $plistArray;
//    }
//playlist
}
