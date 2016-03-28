rune.controller('MpdController',['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', function($scope, $http, $rootScope, runeCurrent, Rune){

	$http.get('http://localhost/RuneAPI/api/index.php/mpd')
                .then(function(data){
                    $scope.dataMpd = data.data.message;
                    console.log($scope.dataMpd);
    });

}]);