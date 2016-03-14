

<?php

	namespace api\controller;
/*
	class infosController
	{
		public static function musique($app)
		{


		function get_url_contents($url){
		        $crl = curl_init();
		        $timeout = 5;
		        curl_setopt ($crl, CURLOPT_URL,$url);
		        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, 1);
		        curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
		        sleep(1);
		        $ret = curl_exec($crl);
		        		        curl_close($crl);
		        return $ret;
		}
		sleep(2);
		$html = get_url_contents($app->rootUri);
		var_dump($html);
		/*
		$html = file_get_contents($app->rootUri );
		
	    $dom = new \DOMDocument();
		libxml_use_internal_errors(true);
	    $dom->loadHTML($html);
	    libxml_clear_errors();
	    $xpath = new \DOMXpath($dom);
	    $tab= array();

	   	//$nodes = $xpath->query("//body");
	   	$nodes = $xpath->query("//div[@class='container txtmid']")->item(0);
		//var_dump($nodes->item(0));

		var_dump($nodes);   

	*/
		
	    /*
		$app->response->setStatus(200);
	            echo json_encode(array(
	                "HTTP" => 200,
	                "Object" => "credits",
	                "message" => "Done",
	                "credits" => json_encode($tab["team"])
	            ));
		*/
		


	

		}

	}

	?>

