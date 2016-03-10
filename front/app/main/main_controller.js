/**
 * Created by LocoMan on 26/02/2016.
 */
rune.controller('MainController',
    ['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){
        $scope.show_player = true;
        $scope.show_manager = false;
        $scope.show_settings = false;

        console.log($rootScope.runes);
        $scope.$watch('$rootScope.rune', function () {
            $scope.runes = $rootScope.runes;
            $scope.rune_select = $scope.runes[0];
        });

    }]);