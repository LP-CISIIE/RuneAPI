rune.controller('MpdController',['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', function($scope, $http, $rootScope, runeCurrent, Rune){

	$http.get($rootScope.root + '/mpd')
                .then(function(data){
                    $scope.dataMpd = data.data.message;
                    console.log($scope.dataMpd);
    });

}]);