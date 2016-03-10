<?php

namespace api\controller;
include_once("simple_html_dom.php");

class settingsController
{
    public static function settings($app)
    {
        function getState($state) {
            $value = 0;
            if($state->getAttribute('class') == "boxed-group"){
                $value = "1";
            }else{
                $value = '0';
            };
            return $value;
        }

        $html = new simple_html_dom();
        $html->load_file('http://192.168.1.14/settings');
        $selects = $html->find('select');
        $inputs = $html->find('input');
        $boxes = $html->find('#features-management', 0);
        $airplay = getState($boxes->find('#airplayBox', 0));
        $spotify = getState($boxes->find('#spotifyBox', 0));
        $dlna = getState($boxes->find('#dlnaBox', 0));
        $lastfm = getState($boxes->find('#lastfmBox', 0));

        $obj = array(
            "settings" => array(
                "environment" => array(
                    "hostname" => $inputs[0]->getAttribute('value'),
                    "ntp_server" => $inputs[1]->getAttribute('value'),
                    "timezone" => $selects[0]->find('option[selected]', 0)->value
                ),
                "kernel" => array(
                    "linux_kernel" => $selects[1]->find('option[selected]', 0)->value,
                    "i2s_modules" => "unknown",
                    "sound_signature" => $selects[3]->find('option[selected]', 0)->value
                ),
                "features" => array(
                    "airplay" => $airplay,
                    "airplay_name" => $inputs[3]->getAttribute('value'),
                    "spotify" => $spotify,
                    "spotify_username" => $inputs[5]->getAttribute('value'),
                    "spotify_password" => $inputs[6]->getAttribute('value'),
                    "upnp_dlna" => $dlna,
                    "upnp_dlna_name" => $inputs[8]->getAttribute('value'),
                    "usb_automount" => "unknown",
                    "display_album_cover" => "unknown",
                    "last_fm" => $lastfm,
                    "lastfm_username" => $inputs[12]->getAttribute('value'),
                    "lastfm_password" => $inputs[13]->getAttribute('value'),
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

        $data = array(
            "features[airplay][enable]" => "1",
            "features[airplay][name]" => "555555555",
            "features[spotify][enable]" => "1",
            "features[spotify][user]" => "dqfz",
            "features[spotify][pass]" => "8968",
            "features[dlna][enable]" => "1",
            "features[dlna][name]" => "8758",
            "features[udevil]"  => "1",
            "features[coverart]" => "1",
            "features[lastfm][enable]" => "1",
            "features[lastfm][user]" => "ujhgfd",
            "features[lastfm][pass]" => "4444",
            "features[submit]" => "1"
        );

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
            )
        );

        $context  = stream_context_create($opts);
        $result = file_get_contents($app->rootUri . "/settings/", false, $context);

        if ($result === FALSE) { /* Handle error */ }
        var_dump($result);
//        $response = trim($html);
//        if($response == 'OK'){
//            $app->response->setStatus(200);
//            echo json_encode(array(
//                "HTTP" => 200,
//                "Object" => "volume",
//                "message" => "Done"
//            ));
//        }else{
//            $app->response->setStatus(500);
//            echo json_encode(array(
//                "HTTP" => 500,
//                "Object" => "volume",
//                "message" => $html
//            ));
//        }
    }
}
