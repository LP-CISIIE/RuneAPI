/**
 * Created by LocoMan on 25/02/2016.
 */
rune.controller('RuneController',
    ['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', function($scope, $http, $rootScope, runeCurrent, Rune){

        $scope.runes = [];
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
                        console.log(rune);
                        $scope.runes.push(new Rune(rune));
                        console.log($scope.runes);
                    });
                });
        };

        $scope.rune_info();
    }]);