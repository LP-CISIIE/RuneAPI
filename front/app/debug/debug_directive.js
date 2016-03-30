rune.directive('debug', ['$rootScope', function($rootScope) {
    // pour appeler les templates
    return {
        templateUrl: 'template/debug.html',
        link: function(scope) {

        }
    };
}]);