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
            $http.get($rootScope.root + '/runes')
                .then(function(response){
                    response.data.runes.forEach(function(rune){
                        $rootScope.runes.push(new Rune(rune));
                    });
                });
        };

        $scope.runePush = function(){
            console.log(JSON.stringify($rootScope.runes));
            //$http.put($rootScope.root + '/runes', JSON.stringify($rootScope.runes))
            //    .then(function(response){
            //        console.log(response);
            //    });

            $http({
                url: $rootScope.root + '/runes',
                dataType: 'json',
                method: 'PUT',
                data: JSON.stringify($rootScope.runes),
                headers: {
                    "Content-Type": "application/json"
                }

            }).success(function(response){
                $scope.response = response;
            }).error(function(error){
                $scope.error = error;
            });

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