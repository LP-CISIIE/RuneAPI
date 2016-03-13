/**
 * Created by LocoMan on 26/02/2016.
 */
rune.controller('MainController',
    ['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){

        $scope.show = 1;
        $scope.lol = true;
        $scope.show_player = false;
        $scope.show_manager = false;
        $scope.show_settings = false;

        $rootScope.runes =[];
        $scope.rune_select = $rootScope.runes;

     $scope.change_rune = function(rune) {
        console.log("CHANGEMENT DE RUNE");
        console.log(rune);
     }
/*
        console.log($rootScope.runes); // :/
        $scope.$watch('$rootScope.rune', function () {
            $scope.runes = $rootScope.runes;
            $scope.rune_select = $scope.runes[0];
        });

*/

    }]);