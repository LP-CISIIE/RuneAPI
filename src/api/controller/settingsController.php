<?php

namespace api\controller;

class settingsController
{
    public static function settings($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $tab = array();

        // l'url du html à récupérer
        $html = file_get_contents($app->rootUri . "/settings/");
        // on créé un élément DOM
        $dom = new \DOMDocument();
        // on rempli le DOM avec le HTML précèdemment récupéré
        $dom->loadHTML($html);

        // on créé un objet Xpath avec le DOM, Xpath permet de jouer plus facilement avec les nodes
        $xpath = new \DOMXpath($dom);

        // retourne la value de l'input ou false si la requête ne trouve pas de resultat
        function get_input_value($query){
            $value = false;
            if($query){
                foreach ($query as $tag) {
                    $value = (trim($tag->getAttribute('value')));
                }
            }
            return $value;
        }

        // on récupère la valeur du noeuds qui correspondent à 'input dont l'id = "hostname"
        array_push($tab, get_input_value($xpath->query('//input[@id="hostname"]')));
        array_push($tab, get_input_value($xpath->query('//input[@id="ntpserver"]')));
        array_push($tab, get_input_value($xpath->query('//select[1]/option[@selected=\'selected\']')));
        array_push($tab, get_input_value($xpath->query('//select[2]/option[@selected=\'selected\']')));
        array_push($tab, get_input_value($xpath->query('//select[3]/option[@selected=\'selected\']')));
        array_push($tab, get_input_value($xpath->query('//select[4]/option[@selected=\'selected\']')));
        array_push($tab, get_input_value($xpath->query('//select[5]/option[@selected=\'selected\']')));
        array_push($tab, get_input_value($xpath->query('//input[@type="checkbox" and @id="airplay"]')));

        $obj = array(
            "settings" => array(
                "environment" => array(
                    "hostname" => $tab[0],
                    "ntp_server" => $tab[1],
                    "timezone" => $tab[2]
                ),
                "kernel" => array(
                    "linux_kernel" => $tab[3],
                    "i2s_modules" => $tab[4],
                    "sound_signature" => $tab[5]
                ),
                "features" => array(
                    "airplay" => "$tab[6]",
                    "airplay_name" => "$tab[7]",
                    "spotify" => "",
                    "upnp_dlna" => "",
                    "upnp_dlna_name" => "",
                    "usb_automount" => "",
                    "display_album_cover" => "",
                    "last_fm" => ""
                ),
                "compatibility_fix" => array(
                    "cmedia_fix" => ""
                )
            )
        );
        echo json_encode($obj);
    }
}
