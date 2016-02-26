rune.controller('PlayerController',
    ['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){
        $rootScope.root = "..";
        $scope.playing = false;

        // start music
        $scope.player_start = function (){
            $http.get($rootScope.root + '/api/player/play')
                .then(function(response){
                    console.log(response);
                })

            $scope.playing = true;
        };

        // stop music
        $scope.player_pause = function (){
            $http.get($rootScope.root + '/api/player/pause')
                .then(function(response){
                    console.log(response);
                })

            $scope.playing = false;
        };

        // previous music
        $scope.player_previous = function (){
            $http.get($rootScope.root + '/api/player/previous')
                .then(function(response){
                    console.log(response);
                })
        };

        // next music
        $scope.player_next = function (){
            $http.get($rootScope.root + '/api/player/next')
                .then(function(response){
                    console.log(response);
                })
        };

        // volume music
        $scope.player_volume = function (){
            $http.get($rootScope.root + '/api/volume/' + $scope.volume)
                .then(function(response){
                    console.log(response);
                })
        };

    }]
);
