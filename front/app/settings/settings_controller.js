/**
 * Created by LocoMan on 25/02/2016.
 */
rune.controller('SettingsController',
    ['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', function($scope, $http, $rootScope, runeCurrent, Rune){
        $scope.airplay = {};
        $scope.airplay.enable = false;

        // airplay enable
        $scope.airplay_enable = function (){
            $obj = JSON.stringify({"airplay":$scope.airplay.enable});
            console.log($obj);
            $http.put($rootScope.root + '/api/settings', $obj)
                .then(function(response){
                    console.log(response);
                });
        };







    }]
);