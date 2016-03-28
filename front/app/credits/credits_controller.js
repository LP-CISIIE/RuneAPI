rune.controller('CreditsController',['$scope', '$http', '$rootScope', function($scope, $http, $rootScope){

	$scope.team = function() {
            $http.get('http://localhost/RuneAPI/api/index.php/credits')
                .then(function(data){
                    $scope.datas=JSON.parse(data.data.credits);
                    
                    console.log(data.data.credits);
                })
        };
	$scope.team();
}]);