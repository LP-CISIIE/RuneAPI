/**
 * Created by LocoMan on 25/02/2016.
 */
rune.controller('PlaylistController',
    ['$scope', '$http', '$scope', '$rootScope', function($scope, $http, $scope, $rootScope){
        $scope.playlist = {};
        $scope.playlist.repeat = false;
        $scope.playlist.random = false;
        $scope.playlist.sound = false;

        //get playlist
        $scope.playlist_get = function(){
            $http.get($rootScope.root + '/playlist/getPlaylist')
                .then(function(response){
                    console.log(response);
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

        // get playlist
        $scope.playlist_getPlaylist = function (){
            $http.get($rootScope.root + '/playlist/getPlaylist')
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
            $http.get($rootScope.root + '/api/playlist/soundRepeatOff')
                .then(function(response){
                    console.log(response);
                })
        };
    }]
);