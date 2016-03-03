/**
 * Created by LocoMan on 25/02/2016.
 */
rune.controller('RuneController',
    ['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', function($scope, $http, $rootScope, runeCurrent, Rune){

        $rootScope.runes = [];
        $scope.runes = $rootScope.runes;
        $scope.$watch('runeCurrent.rune', function (newValue) {
            if (newValue != 0 && newValue != undefined) {
                $rootScope.root = runeCurrent.rune.ip
            }
        });

        // get runeInfo
        $scope.rune_info = function (){
            $http.get($rootScope.root + '/api/runeInfo')
                .then(function(response){
                    //console.log(response);
                    response.data.runeInfo.forEach(function(rune){
                        //console.log(rune);
                        $rootScope.runes.push(new Rune(rune));
                        //console.log($scope.runes);
                        console.log($scope.runes);
                    });
                });
        };

        $scope.runePush = function(newRune){
            console.log(JSON.stringify(newRune));
            $http.post($rootScope.root + '/api/runeInfo', JSON.stringify(newRune))
                .then(function(response){
                    console.log(response);
                })
        };

        $scope.rune_info();
    }]);