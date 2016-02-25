/**
 * Created by LocoMan on 25/02/2016.
 */
rune.controller('PlaylistController',
    ['$scope', '$http', '$scope', '$rootScope', function($scope, $http, $scope, $rootScope){

        // repeat ON
        $scope.playlist_repeatOn = function (){
            $http.get($rootScope.root + '/api/playlist/repeatOn')
                .then(function(response){
                    console.log(response);
                })
        };

        // repeat OFF
        $scope.playlist_repeatOff = function (){
            $http.get($rootScope.root + '/api/playlist/repeatOff')
                .then(function(response){
                    console.log(response);
                })
        };

        // get playlist
        $scope.playlist_getPlaylist = function (){
            $http.get($rootScope.root + '/api/playlist/getPlaylist')
                .then(function(response){
                    console.log(response);
                })
        };

        // random on
        $scope.playlist_randomOn = function (){
            $http.get($rootScope.root + '/api/playlist/randomOn')
                .then(function(response){
                    console.log(response);
                })
        };

        // random off
        $scope.playlist_randomOff = function (){
            $http.get($rootScope.root + '/api/playlist/randomOff')
                .then(function(response){
                    console.log(response);
                })
        };

        // sound repeat on
        $scope.playlist_soundRepeatOn = function (){
            $http.get($rootScope.root + '/api/playlist/soundRepeatOn')
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