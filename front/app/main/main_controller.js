/**
 * Created by LocoMan on 26/02/2016.
 */
rune.controller('MainController',
    ['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', function($scope, $http, $rootScope, runeCurrent, Rune){

        $rootScope.root = "http://192.168.1.14:83";
        $scope.show = 1;
        $scope.show_player = true;
        $scope.show_control = true;
        $scope.show_manager = false;
        $scope.show_settings = false;
        $scope.show_credits = false;
        $scope.show_mpd = false;

        $rootScope.runes =[];
        $scope.rune_select = $rootScope.rune;
        
        $scope.change_rune = function(rune) {
            $rune = new Rune(JSON.parse(rune));
            console.log("CHANGEMENT DE RUNE POUR : " + $rune);
            runeCurrent.rune = $rune;
            $rootScope.root = $rune.ip2;
            console.log($rune.ip2);
            $rootScope.player_status();
        };
/*
        console.log($rootScope.runes); // :/
        $scope.$watch('$rootScope.rune', function () {
            $scope.runes = $rootScope.runes;
            $scope.rune_select = $scope.runes[0];
        });

*/

    }]);