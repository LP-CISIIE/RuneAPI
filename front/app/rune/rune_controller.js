/**
 * Created by LocoMan on 25/02/2016.
 */
rune.controller('RuneController',
    ['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', function($scope, $http, $rootScope, runeCurrent, Rune){

        $scope.$watch('runeCurrent.rune', function (newValue) {
            if (newValue != 0 && newValue != undefined) {
                $rootScope.root = runeCurrent.rune.ip
            }
        });

        /* TEST EN DUR */
        $scope.runes = [];
        var rune1 = {};
        rune1.id = 0;
        rune1.ip = '192.168.1.14';
        rune1.label = 'Salon';

        $scope.runes.push(new Rune(rune1));
        /* FIN TEST */
    }]);