<?php

	namespace api\controller;

	class creditsController
	{
		public static function credits($app)
		{

		
		$html = file_get_contents($app->rootUri . "credits/");
	    $dom = new \DOMDocument();
		libxml_use_internal_errors(true);
	    $dom->loadHTML($html);
	    libxml_clear_errors();
	    $xpath = new \DOMXpath($dom);
	    $tab= array();

	   	$tables = $dom->getElementsByTagName("container credits");
	   	

	   
 
		$i = 0;
 
			while($table = $tables->item($i++))
			{
			    foreach($table->attributes as $attr)
			    {
			        var_dump( $attr->name . " " . $attr->value . "<br />" );
			    }
			}


		/*

		$app->response->setStatus(200);
	            echo json_encode(array(
	                "HTTP" => 200,
	                "Object" => "credits",
	                "message" => "Done",
	                "credits" => $c
	            ));
*/
		


	

		}

	}

	?>

