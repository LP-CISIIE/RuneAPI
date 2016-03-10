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

        switch($scope.show)
        {
            case 1 : $scope.show_player = true; $scope.show_manager = false; $scope.show_settings = false; break;
            case 2 : $scope.show_player = false; $scope.show_manager = true; $scope.show_settings = false; break;
            case 3 : $scope.show_player = true; $scope.show_manager = false; $scope.show_settings = true; break;
        }

        console.log($rootScope.runes);
        $scope.$watch('$rootScope.rune', function () {
            $scope.runes = $rootScope.runes;
            $scope.rune_select = $scope.runes[0];
        });

    }]);