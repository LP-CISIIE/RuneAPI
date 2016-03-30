/**
 * Created by LocoMan on 26/02/2016.
 */
rune.controller('MainController',
    ['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', '$localStorage', '$sessionStorage', function($scope, $http, $rootScope, runeCurrent, Rune, $localStorage, $sessionStorage){

        $rootScope.root = "http://192.168.1.27:83";
        $scope.show = 1;
        $scope.show_player = true;
        $scope.show_control = false;
        $scope.show_playlist = false;
        $scope.show_manager = false;
        $scope.show_settings = false;
        $scope.show_mpd = false;
        $scope.show_credits = false;
        $scope.responseDirs = [];
        $scope.dir = "";
        $scope.newDir = {name:""};


        // $scope.$storage = $localStorage.$default({
        //     counter: 42
        // });
        // console.log($localStorage);

        $rootScope.runes =[];
        $scope.rune_select = $rootScope.rune;
        
        $scope.change_rune = function(rune) {
            $rune = new Rune(JSON.parse(rune));
            console.log("CHANGEMENT DE RUNE POUR : " + $rune);
            runeCurrent.rune = $rune;
            
            // change the API IP
            $rootScope.root = $rune.ip2;
            // get the informations about the current rune's music player deamon
            $rootScope.player_status();
            
            // empty the filesystem interface
            $scope.newDir = {name:""};
            $scope.dir = "";
            $rootScope.getDir($scope.newDir);
        };
/*
        console.log($rootScope.runes); // :/
        $scope.$watch('$rootScope.rune', function () {
            $scope.runes = $rootScope.runes;
            $scope.rune_select = $scope.runes[0];
        });

*/

    }]);