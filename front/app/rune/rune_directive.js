/**
 * Created by LocoMan on 26/02/2016.
 */
rune.directive('runemanager', ['$rootScope', 'Rune', function($rootScope, Rune) {
    // pour appeler les templates
    return {
        templateUrl: 'template/rune-manager.html',
        link: function(scope) {
            scope.add_rune = function(addRune){
                console.log(addRune);
                scope.runePush(new Rune(addRune));
            }

        }
    };
}]);