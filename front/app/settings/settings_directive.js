/**
 * Created by LocoMan on 26/02/2016.
 */
rune.directive('settings', ['$rootScope', 'Settings', function($rootScope, Settings) {
    // pour appeler les templates
    return {
        templateUrl: 'template/settings.html',
        link: function(scope) {

        }
    };
}]);