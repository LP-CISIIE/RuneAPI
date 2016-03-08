/**
 * Created by LocoMan on 26/02/2016.
 */
rune.directive('runemanager', ['$rootScope', 'Rune', 'runeCurrent', function($rootScope, Rune, runeCurrent) {
    // pour appeler les templates
    return {
        templateUrl: 'template/rune-manager.html',
        link: function(scope) {
            scope.add_rune = function(addRune){
                console.log(addRune);
                scope.runes.push(new Rune(addRune));
                scope.runePush();
            };
            scope.delete_rune = function(delRune){
                scope.runeDelete(delRune);
            };
            scope.select_rune = function(rune) {
                runeCurrent.rune = rune;
            };
        }
    };
}]);