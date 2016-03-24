<?php
	namespace api\controller;

	class mpdController
	{
		public static function getMpd($app){
			$app->response->headers->set('Content-Type', 'application/json');
	        
	        // l'url du html à récupérer
	        $html = file_get_contents($app->rootUri . "mpd/");
	        // on créé un élément DOM
	        $dom = new \DOMDocument();
	        // on rempli le DOM avec le HTML précèdemment récupéré
	        libxml_use_internal_errors(true);
	        $dom->loadHTML($html);
	        libxml_clear_errors();

	        // on créé un objet Xpath avec le DOM, Xpath permet de jouer plus facilement avec les nodes
	        $xpath = new \DOMXpath($dom);

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

	        //Audio output interface
	        $tab["AudioOutput"] = getSelectValue('//select[@id="audio-output-interface"]/*', $xpath);
	        $tab["AudioOutput"]["select"] = getSelectValue('//select[@id="audio-output-interface"]/option[@selected=\'selected\']', $xpath);
	        
	        //Volume controle
	        $tab["VolumeControle"] = getSelectValue('//select[@id="mixer-type"]/*', $xpath);
	        $tab["VolumeControle"]["select"] = getSelectValue('//select[@id="mixer-type"]/option[@selected=\'selected\']', $xpath);

	        //Port
	        $tab["Port"] = get_input_value($xpath->query('//input[@id="port"]'));

	        //Daemon user : group
	        $tab["DaemonUser"] = getSelectValue('//select[@name="conf[user]"]/*', $xpath);
	        $tab["DaemonUser"]["select"] = getSelectValue('//select[@name="conf[user]"]/option[@selected=\'selected\']', $xpath);

	        //Log level
	        $tab["LogLevel"] = getSelectValue('//select[@name="conf[log_level]"]/*', $xpath);
	        $tab["LogLevel"]["select"] = getSelectValue('//select[@name="conf[log_level]"]/option[@selected=\'selected\']', $xpath);

	        //State file
	        $tab["StateFile"] = getSelectValue('//select[@name="conf[state_file]"]/*', $xpath);
	        $tab["StateFile"]["select"] = getSelectValue('//select[@name="conf[state_file]"]/option[@selected=\'selected\']', $xpath);

	        //FFmpeg decoder plugin
	        $tab["FFmpeg"] = getSelectValue('//select[@name="conf[ffmpeg]"]/*', $xpath);
	        $tab["FFmpeg"]["select"] = getSelectValue('//select[@name="conf[ffmpeg]"]/option[@selected=\'selected\']', $xpath);

	        //Gapless mp3 playback
	        $tab["Gapless"] = getSelectValue('//select[@name="conf[gapless_mp3_playback]"]/*', $xpath);
	        $tab["Gapless"]["select"] = getSelectValue('//select[@name="conf[gapless_mp3_playback]"]/option[@selected=\'selected\']', $xpath);

	        //DSD support
	        $tab["DSDSupport"] = getSelectValue('//select[@name="conf[dsd_usb]"]/*', $xpath);
	        $tab["DSDSupport"]["select"] = getSelectValue('//select[@name="conf[dsd_usb]"]/option[@selected=\'selected\']', $xpath);

	        //Volume normalization
	        $tab["VolumeNormalization"] = getSelectValue('//select[@name="conf[volume_normalization]"]/*', $xpath);
	        $tab["VolumeNormalization"]["select"] = getSelectValue('//select[@name="conf[volume_normalization]"]/option[@selected=\'selected\']', $xpath);

	        //Audio buffer size
	        $tab["AudioBufferSize"] = get_input_value($xpath->query('//input[@id="audio-buffer-size"]'));

	        //Buffer before play
	        $tab["Buffer"] = getSelectValue('//select[@name="conf[buffer_before_play]"]/*', $xpath);
	        $tab["Buffer"]["select"] = getSelectValue('//select[@name="conf[buffer_before_play]"]/option[@selected=\'selected\']', $xpath);

	        //Auto update
	        $tab["AutoUpdate"] = getSelectValue('//select[@name="conf[auto_update]"]/*', $xpath);
	        $tab["AutoUpdate"]["select"] = getSelectValue('//select[@name="conf[auto_update]"]/option[@selected=\'selected\']', $xpath);

	        $app->response->setStatus(200);
            echo json_encode(array(
                "HTTP" => 200,
                "message" => $tab
            ));
		}

		public function setOutput($app){
			$data = json_decode($app->request->getBody());
	        $postdata = http_build_query(
			    array(
			        "conf[mixer_type]" => $data->mixer_type,
		            "conf[user]" => $data->user,
		            "conf[log_level]" => $data->log_level,
		            "conf[state_file]" => $data->state_file,
		            "conf[ffmpeg]" => $data->ffmpeg,
		            "conf[gapless_mp3_playback]" => $data->gapless_mp3_playback,
		            "conf[dsd_usb]" => $data->dsd_usb,
		            "conf[volume_normalization]"  => $data->volume_normalization,
		            "conf[audio_buffer_size]" => $data->audio_buffer_size,
		            "conf[buffer_before_play]" => $data->buffer_before_play,
		            "conf[auto_update]" => $data->auto_update,
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

        	$result = file_get_contents($app->rootUri . "mpd/", false, $context);
		}
	}
?>