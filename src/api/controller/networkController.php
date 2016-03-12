<?php

	namespace api\controller;

	class networkController
	{
		public static function getNetwork($app){
			$app->response->headers->set('Content-Type', 'application/json');
		        
	        // l'url du html à récupérer
	        $html = file_get_contents($app->rootUri . "network/");
	        // on créé un élément DOM
	        $dom = new \DOMDocument();
	        // on rempli le DOM avec le HTML précèdemment récupéré
	        libxml_use_internal_errors(true);
	        $dom->loadHTML($html);
	        libxml_clear_errors();

	        // on créé un objet Xpath avec le DOM, Xpath permet de jouer plus facilement avec les nodes
	        $xpath = new \DOMXpath($dom);

	        function getFormValue($query, $xpath){
	        	$objDom = $xpath->query($query);
		        $i = 0;
		        $tmp = null;
		        while($i < $objDom->length){
		        	$network = explode("[", trim(str_replace(" " 	,"",$objDom[$i]->textContent)));
			        $tmp[$i]["nom"] = str_replace("]", "", $network[0]);			     
			        $tmp[$i]["adresse"] = str_replace("]", "", $network[1]);			       
		        	$i++;
		        }
		        return $tmp;
	        }

	        //Network interfaces
	        $tab["NetworkInterface"] = getFormValue('//form[@id="network-interface-list"]/*', $xpath);

	        $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "message" => $tab
            ));


		}

		public static function setNetwork($network, $app){
			$app->response->headers->set('Content-Type', 'application/json');
		        
	        // l'url du html à récupérer
	        $html = file_get_contents($app->rootUri . "network/edit/".$network);
	        // on créé un élément DOM
	        $dom = new \DOMDocument();
	        // on rempli le DOM avec le HTML précèdemment récupéré
	        libxml_use_internal_errors(true);
	        $dom->loadHTML($html);
	        libxml_clear_errors();
	        // on créé un objet Xpath avec le DOM, Xpath permet de jouer plus facilement avec les nodes
	        $xpath = new \DOMXpath($dom);

	        function getFormValue($query, $xpath){
	        	$objDom = $xpath->query($query);
		        $i = 0;
		        $tmp = null;
		        while($i < $objDom->length){		     
	        		$param = explode(":", trim($objDom[$i]->textContent));
		        	$tmp[$i]["name"] = $param[0];
		        	$tmp[$i]["value"] = $param[1];
			        
		        	$i++;
		        }
		        return $tmp;
	        }

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

	        //Network interfaces
	        $tab["NetworkInterface"] = getFormValue('//table[@id="nic-details"]/tbody/*', $xpath);

	        //Config interfaces
	        $tab["ConfigInterfaces"] = getSelectValue('//select[@id="dhcp"]/*', $xpath);
	        $tab["ConfigInterfaces"]["select"] = getSelectValue('//select[@id="dhcp"]/option[@selected=\'selected\']', $xpath);

	        
	        $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "message" => $tab
            ));
		}
	}

?>