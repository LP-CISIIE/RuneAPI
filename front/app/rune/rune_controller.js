/**
 * Created by LocoMan on 25/02/2016.
 */
rune.controller('RuneController',
    ['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', function($scope, $http, $rootScope, runeCurrent, Rune){

        
        $scope.runes = $rootScope.runes;
        $scope.$watch('runeCurrent.rune', function (newValue) {
            if (newValue != 0 && newValue != undefined) {
                $rootScope.root = runeCurrent.rune.ip
            }
        });

        // get runeInfo
        $scope.rune_info = function (){
            $http.get($rootScope.root + '/api/runes')
                .then(function(response){
                    console.log(response);
                    response.data.runes.forEach(function(rune){
                        $rootScope.runes.push(new Rune(rune));
                    });
                    console.log($scope.runes);
                });
        };

        $scope.runePush = function(){
            console.log(JSON.stringify($rootScope.runes));
            $http.post($rootScope.root + '/api/runes', JSON.stringify($rootScope.runes))
                .then(function(response){
                    console.log(response);
                })

        };

        $scope.runeDelete = function(ip){
            $rootScope.runes.forEach(function(rune){
                if(rune.ip == ip.ip){
                    $rootScope.runes.splice($rootScope.runes.indexOf(rune), 1);
                }
            });
            $scope.runePush();
        };

        $scope.rune_info();
    }]);