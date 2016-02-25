/**
 * Created by LocoMan on 25/02/2016.
 */
rune.controller('RuneController',
    ['$scope', '$http', '$scope', '$rootScope', 'runeCurrent', function($scope, $http, $rootScope, runeCurrent){

        $scope.$watch('runeCurrent.rune', function (newValue) {
            if (newValue != 0 && newValue != undefined) {
                $rootScope.root = runeCurrent.rune.ip
            }
        });

    }]);