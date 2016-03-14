<?php
/**
 * Created by PhpStorm.
 * User: LocoMan
 * Date: 23/02/2016
 * Time: 23:34
 */

namespace api\controller;

class sourcesController
{
    public static function index($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $tab = array();

        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . "/sources/");
        // on supprime les saloperies du html mal formé
        $html2 = str_replace("&nbsp13", "13", $html);
        $html3 = str_replace("&nbsp", "", $html2);

        // on créé un élément DOM
        $dom = new \DOMDocument();
        // on rempli le DOM avec le HTML précèdemment récupéré
        $dom->loadHTML($html3);
        $div = $dom->getElementById('usb-mount-list')->getElementsByTagName('a');
        foreach ($div as $item) {
            $usb = $item->nodeValue;
            array_push($tab, $usb);
        }

        $obj = array(
            "usb_sources" => $tab
        );
        echo json_encode($obj);
    }

    public static function rebuild($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');

        $postdata = http_build_query(
            array(
                'updatemdp' => '1'
            )
        );

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );

        $context  = stream_context_create($opts);
        $result = file_get_contents($app->rootUri . "/sources/", false, $context);

        $obj = array(
            "rebuild_mpd_library" => "done"
        );
        echo json_encode($obj);
    }

    public static function AddSource($app){
            $data = json_decode($app->request->getBody());
            var_dump($data);
            $postdata = http_build_query(
                array(
                    "mount[name]" => $data->name,
                    "mount[id]" => $data->id,
                    "action" => "add",
                    "mount[type]" => $data->type,
                    "mount[address]" => $data->address,
                    "mount[remotedir]" => $data->remotedir,
                    "nas-guest" => $data->nas,
                    "mount[username]" => $data->username,
                    "mount[password]" => $data->password,
                    "mount[charset]"  => $data->charset,
                    "mount[rsize]" => $data->rsize,
                    "mount[wsize]" => $data->wsize,
                    "mount[options]" => $data->options,
                    "mount[error]" => $data->error,
                    "save" => "save"
                )
            );

            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );

            $context  = stream_context_create($opts);

            $result = file_get_contents($app->rootUri . "sources/", false, $context);
        }

}