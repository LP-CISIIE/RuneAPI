<?php

namespace api\controller;

class settingsController
{
    public static function settings($app)
    {
        $app->response->headers->set('Content-Type', 'application/json');
        $tab = array();

        // l'url du html à récupérer
        $html = file_get_contents("http://192.168.1.14/settings/");
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
        $obj = array(
            "settings" => array(
                "hostname" => $tab[0],
                "ntp_server" => $tab[1]
            )
        );
        echo json_encode($obj);
    }
}
