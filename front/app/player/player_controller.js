rune.controller('PlayerController',
    ['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){
        $scope.playing = "";

        // start music
        $scope.player_start = function (){
            $http.get($rootScope.root + '/player/play')
                .then(function(response){
                    console.log(response);
                });

            $scope.playing = true;
        };

        // stop music
        $scope.player_pause = function (){
            $http.get($rootScope.root + '/player/pause')
                .then(function(response){
                    console.log(response);
                });

            $scope.playing = false;
        };

        // previous music
        $scope.player_previous = function (){
            $http.get($rootScope.root + '/player/previous')
                .then(function(response){
                    console.log(response);
                })
        };

        // next music
        $scope.player_next = function (){
            $http.get($rootScope.root + '/player/next')
                .then(function(response){
                    console.log(response);
                })
        };

        // volume music
        $scope.player_volume = function (){
            $http.get($rootScope.root + '/volume/' + $scope.volume)
                .then(function(response){
                    console.log(response);
                })
        };

        // get current track info
        $scope.current_track = function () {
            $http.get($rootScope.root + '/song')
                .then(function(response){
                    console.log(response);
                })
        };

        // get player infos (playing or not, time elapsed...)
        $rootScope.player_status = function () {
            $http.get($rootScope.root + '/playerStatus')
                .then(function(response){
                    console.log(response);
                    $scope.playing = response.data.infos[0].state;
                    console.log($scope.playing);
                })
        };

        // to know if player is playing
        $rootScope.player_status();
    }]
);
