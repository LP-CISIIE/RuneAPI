rune.controller('PlayerController',
    ['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){
        $rootScope.root = "..";
        // start music
        $scope.player_start = function (){
            $http.get($rootScope.root + '/api/player/play')
                .then(function(response){
                    console.log(response);
                })
        };

        // stop music
        $scope.player_pause = function (){
            $http.get($rootScope.root + '/api/player/pause')
                .then(function(response){
                    console.log(response);
                })
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



    }]
);
