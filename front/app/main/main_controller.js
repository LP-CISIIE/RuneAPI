/**
 * Created by LocoMan on 26/02/2016.
 */
rune.controller('MainController',
    ['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){

        $rootScope.root = "http://192.168.1.14:83";
        $scope.show = 1;
        $scope.show_player = true;
        $scope.show_manager = false;
        $scope.show_settings = false;
        $scope.show_credits = false;
        $scope.show_mpd = false;

        $rootScope.runes =[];
        $scope.rune_select = $rootScope.rune;
        
        $scope.change_rune = function(rune) {
            console.log("CHANGEMENT DE RUNE POUR : " + rune);
        };
/*
        console.log($rootScope.runes); // :/
        $scope.$watch('$rootScope.rune', function () {
            $scope.runes = $rootScope.runes;
            $scope.rune_select = $scope.runes[0];
        });

*/

    }]);