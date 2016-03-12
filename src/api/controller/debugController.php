<?php

	namespace api\controller;

	class debugController
	{
		public static function getLog($app){
			$app->response->headers->set('Content-Type', 'application/json');
		        
	        // l'url du html à récupérer
	        $html = file_get_contents($app->rootUri . "debug/");
	        // on créé un élément DOM
	        $dom = new \DOMDocument();
	        // on rempli le DOM avec le HTML précèdemment récupéré
	        libxml_use_internal_errors(true);
	        $dom->loadHTML($html);
	        libxml_clear_errors();

	        // on créé un objet Xpath avec le DOM, Xpath permet de jouer plus facilement avec les nodes
	        $xpath = new \DOMXpath($dom);

	        function getPreValue($query, $xpath){
	        	$objDom = $xpath->query($query);
		        $i = 0;
		        $tmp = null;
		        while($i < $objDom->length){
		        	$tmp[$i] = $objDom[$i]->textContent;  
		        	$i++;
		        }
		        return $tmp;
	        }




	        //echo($html);
	        $tab["Log"] = getPreValue('//pre[@id="clipboard_pre"]/*', $xpath);
	       	
	       	$app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "message" => $tab
            ));
	    }

	}
?>