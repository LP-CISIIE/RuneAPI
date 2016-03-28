rune.controller('MpdController',['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', function($scope, $http, $rootScope, runeCurrent, Rune){

	$http.get($rootScope.root + '/mpd')
                .then(function(data){
                    $scope.dataMpd = data.data.message;
    });

    $scope.validate = function () {
    	console.log("test");

		$('#modal2').openModal();
		$http({
 			method: 'POST',
 			url: 'http://localhost/RuneAPI/api/index.php/mpd',
 			headers: {
   			'Content-Type': undefined
 			},
 			data: {
				"mixer_type": document.getElementById('VolumeControle').value,
				"user": document.getElementById('DaemonUser').value,
				"log_level" : document.getElementById('LogLevel').value,
				"state_file" : document.getElementById('StateFile').value,
				"ffmpeg" : document.getElementById('FFmpeg').value,
				"gapless_mp3_playback" : document.getElementById('Gapless').value,
				"dsd_usb" : document.getElementById('DSDSupport').value,
				"volume_normalization" : document.getElementById('VolumeNormalization').value,
				"audio_buffer_size" : document.getElementById('AudioBufferSuze').value,
				"buffer_before_play" : document.getElementById('Buffer').value,
				"auto_update" : document.getElementById('AutoUpdate').value
			}
		}).then(function(data){
			console.log(data);			
			$('#modal2').closeModal();
			$('#modal1').openModal();
		});
    }

}]);