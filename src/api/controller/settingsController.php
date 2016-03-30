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
        $html = new simple_html_dom();
        $html->load_file($app->rootUri . "/settings");
        $selects = $html->find('select');
        $inputs = $html->find('input');
        $boxes = $html->find('#features-management', 0);

        // connect to the database
        $redis = new \Redis();
        $redis->pconnect('127.0.0.1');

        $obj = array(
            "settings" => array(
                "environment" => array(
                    "hostname" => $redis->get('hostname'),
                    "ntp_server" => $redis->get('ntpserver'),
                    "timezone" => $redis->get('timezone')
                ),
                "kernel" => array(
//                    "linux_kernel" => $selects[1]->find('option[selected]', 0)->value,
                    "i2s_modules" => $redis->get('i2smodule'),
//                    "sound_signature" => $selects[3]->find('option[selected]', 0)->value
                ),
                "features" => array(
                    "airplay" => $redis->hGet('airplay', 'enable'),
                    "airplay_name" => $redis->hGet('airplay', 'name'),
                    "spotify" => $redis->hGet('spotify', 'enable'),
                    "spotify_username" => $redis->hGet('spotify', 'user'),
                    "spotify_password" => $redis->hGet('spotify', 'pass'),
                    "upnp_dlna" => $redis->hGet('dlna', 'enable'),
                    "upnp_dlna_name" => $redis->hGet('dlna', 'name'),
                    "usb_automount" => $redis->get('udevil'),
                    "coverart" => $redis->get('coverart'),
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

        $redis = new \Redis();
        $redis->pconnect('127.0.0.1');

        (empty($data->coverart)) ? '' : $redis->set('coverart', $data->coverart);


        $data = array(
            "features[airplay][enable]" => (empty($data->airplay)) ? 'défaut' : $data->airplay,
            "features[airplay][name]" => (empty($data->airplay_name)) ? null : $data->airplay_name,
            "features[spotify][enable]" => (empty($data->spotify)) ? 'défaut' : $data->spotify,
            "features[spotify][user]" => (empty($data->spotify_user)) ? null : $data->spotify_user,
            "features[spotify][pass]" => (empty($data->spotify_pass)) ? null : $data->spotify_pass,
            "features[dlna][enable]" => (empty($data->dlna)) ? 'défaut' : $data->dlna,
            "features[dlna][name]" => (empty($data->dlna_name)) ? null : $data->dlna_name,
            "features[udevil]" => (empty($data->udevil)) ? 'défaut' : $data->udevil,
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
        sendMpdCommand($socket, 'status');
        $song = readMpdResponse($socket);
//        var_dump(self::parsePlaylist($song));
        echo json_encode(playerController::parsePlaylist($song));
    }
}
