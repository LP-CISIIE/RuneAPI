<?php
	namespace api\controller;

	class sourceController{
		
		public static function getSource($app){
			$app->response->headers->set('Content-Type', 'application/json');

	        $html = file_get_contents($app->rootUri . '/sources');
	        $response = trim($html);

	        if($response == 'OK'){
	            $app->response->setStatus(200);
	            echo json_encode(array(
	                "HTTP" => 200,
	                "Object" => "sources",
	                "message" => "Done"
	            ));
	        }else{
	            $app->response->setStatus(500);
	            echo json_encode(array(
	                "HTTP" => 500,
	                "Object" => "sources",
	                "message" => $html
	            ));
	        }
		}
	}
?>