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


			$tab["team"]=array();
			$names = $xpath->query("//strong");
			$spans = $xpath->query("//span");

			$equipe = array();
			for ($i=0; $i < 8 ; $i++) {
				$equipe["nom"] = str_replace(",","", $names->item($i+1)->nodeValue);
				$equipe["role"] = str_replace(",","", $spans->item($i)->nodeValue) ;

				array_push($tab["team"],$equipe	);
			}

			$app->response->setStatus(200);
				echo json_encode(array(
					"HTTP" => 200,
					"Object" => "credits",
					"message" => "Done",
					"credits" => json_encode($tab["team"])
				));
		}

	}

	?>

