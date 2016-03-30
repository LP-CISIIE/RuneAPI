rune.controller('DebugController',['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){

    $scope.debug = "";

	$scope.team = function() {
            $http.get($rootScope.root + '/debug')
                .then(function(data){
                    console.log(data);
                    $scope.debug = JSON.parse(data.data);
                })
        };
	$scope.team();
}]);