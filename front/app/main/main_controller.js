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

/*
        console.log($rootScope.runes); // :/
        $scope.$watch('$rootScope.rune', function () {
            $scope.runes = $rootScope.runes;
            $scope.rune_select = $scope.runes[0];
        });

*/

    }]);