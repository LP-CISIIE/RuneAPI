/**
 * Created by LocoMan on 25/02/2016.
 */
rune.controller('SettingsController',
    ['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', function($scope, $http, $rootScope, runeCurrent, Rune){

        // airplay enable
        $scope.airplay_enable = function (){
            $http.put($rootScope.root + '/api/settings')
                .then(function(response){
                    console.log(response);
                });
        };







    }]
);