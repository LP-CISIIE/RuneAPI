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

    public function DeleteSource($app){
        $data = json_decode($app->request->getBody());
        $postdata = http_build_query(
            array(
                "action" => "delete",
                "mount[id]" => $data->id
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
    }

    public static function EditSource($app,$id){

        $app->response->headers->set('Content-Type', 'application/json');
        
        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . "/sources/edit/".$id);
        // on créé un élément DOM
        $dom = new \DOMDocument();
        // on rempli le DOM avec le HTML précèdemment récupéré
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        // on créé un objet Xpath avec le DOM, Xpath permet de jouer plus facilement avec les nodes
        $xpath = new \DOMXpath($dom);

        //var_dump($html);

        function getSelectValue($query, $xpath){
            $objDom = $xpath->query($query);
            $i = 0;
            $tmp = null;

            while($i < $objDom->length){

                if( $objDom->length > 1){
                    $tmp[$i] = $objDom[$i]->textContent;
                }else{
                    $tmp = $objDom[$i]->textContent;
                }
                $i++;
            }
            return $tmp;
        }
        //var_dump($html);
        function get_input_value($query){
            $value = false;
            if($query){
                foreach ($query as $tag){
                    $value = (trim($tag->getAttribute('value')));
                }
            }
            return $value;
        }

        $tab = array();

        //NAS name
        $tab["nas-name"] = get_input_value($xpath->query('//input[@id="nas-name"]'));

        //FileShare protocol
        $tab["mount-type"] = getSelectValue('//select[@id="mount-type"]/*', $xpath);
        $tab["mount-type"]["select"] = getSelectValue('//select[@id="mount-type"]/option[@selected=\'selected\']', $xpath);

        //IP adress
        $tab["nas-ip"] = get_input_value($xpath->query('//input[@id="nas-ip"]'));

        //Remote directory
        $tab["nas-dir"] = get_input_value($xpath->query('//input[@id="nas-dir"]'));

        //Guest access
        if(get_input_value($xpath->query('//input[@id="nas-guest" and @checked]')) === false){
            $tab["nas-guest"] = "no";

            //Login
            $tab["nas-usr"] = get_input_value($xpath->query('//input[@id="nas-usr"]'));

            //Password
            $tab["nas-pasw"] = get_input_value($xpath->query('//input[@id="nas-pasw"]'));
        }else{            
            $tab["nas-guest"] = "yes";
        }


        //Charset
        $tab["log-level"] = getSelectValue('//select[@id="log-level"]/*', $xpath);
        $tab["log-level"]["select"] = getSelectValue('//select[@id="log-level"]/option[@selected=\'selected\']', $xpath);
            
        //Rsize
        $tab["nas-rsize"] = get_input_value($xpath->query('//input[@id="nas-rsize"]'));

        //Wsize
        $tab["nas-wsize"] = get_input_value($xpath->query('//input[@id="nas-wsize"]'));

        //Mount flag
        $tab["options"] = get_input_value($xpath->query('//input[@id="options"]'));

        $app->response->setStatus(200);
        echo json_encode(array(
            "HTTP" => 200,
            "message" => $tab
        ));
    }

    public static function AddSource($app){
        $data = json_decode($app->request->getBody());
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

        $result = file_get_contents($app->rootUri . "/sources/", false, $context);
    }

}