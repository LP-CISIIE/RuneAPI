/**
 * Created by LocoMan on 25/02/2016.
 */
rune.controller('PlaylistController',
    ['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){
        $scope.playlist = {};
        $scope.playlist.repeat = false;
        $scope.playlist.random = false;
        $scope.playlist.sound = false;

        $scope.playlist_get = function(){
            tracks = [];
            $scope.tracks = [];
            $http.get($rootScope.root + '/playlist/playlist')
                .then(function(response){

                    response.data.infos.forEach(function(infos){
                        tracks.push(infos);
                    });
                    $scope.tracks = tracks;
                })
        };

        // repeat
        $scope.playlist_repeat = function (){
            $obj = JSON.stringify({"playlist":$scope.playlist.repeat});
            console.log($obj);
            if($obj== true){
                $scope.playlist_repeatOn();
            }
            else{
                $scope.playlist_repeatOff();
            }
        };

        // repeat ON
        $scope.playlist_repeatOn = function (){
            $http.get($rootScope.root + '/playlist/repeatOn')
                .then(function(response){
                    console.log(response);
                })
        };

        // repeat OFF
        $scope.playlist_repeatOff = function (){
            $http.get($rootScope.root + '/playlist/repeatOff')
                .then(function(response){
                    console.log(response);
                })
        };

        // random
        $scope.playlist_random = function (){
            $obj = JSON.stringify({"playlist":$scope.playlist.random});
            console.log($obj);
            if($obj== true){
                $scope.playlist_randomOn();
            }
            else{
                $scope.playlist_randomOff();
            }
        };
        // random on
        $scope.playlist_randomOn = function (){
            $http.get($rootScope.root + '/playlist/randomOn')
                .then(function(response){
                    console.log(response);
                })
        };

        // random off
        $scope.playlist_randomOff = function (){
            $http.get($rootScope.root + '/playlist/randomOff')
                .then(function(response){
                    console.log(response);
                })
        };

        // sound repeat
        $scope.playlist_soundRepeat = function (){
            $obj = JSON.stringify({"playlist":$scope.playlist.sound});
            console.log($obj);
            if($obj== true){
                $scope.playlist_soundRepeatOn();
            }
            else{
                $scope.playlist_soundRepeatOff();
            }
        };

        // sound repeat on
        $scope.playlist_soundRepeatOn = function (){
            $http.get($rootScope.root + '/playlist/soundRepeatOn')
                .then(function(response){
                    console.log(response);
                })
        };

        // sound repeat off
        $scope.playlist_soundRepeatOff = function (){
            $http.get($rootScope.root + '/playlist/soundRepeatOff')
                .then(function(response){
                    console.log(response);
                })
        };

        // play song on click
        $scope.playOnClick = function (id){
            console.log(id);
            $http.get($rootScope.root + '/player/playOnClick/'+id)
                .then(function(response){
                    console.log(response);
                });
            $rootScope.player_status();
        };

        //appel de fonction
        $scope.playlist_get();
    }]
);