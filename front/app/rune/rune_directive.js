/**
 * Created by LocoMan on 26/02/2016.
 */
rune.directive('runemanager', ['$rootScope', 'Rune', 'runeCurrent', '$http', function($rootScope, Rune, runeCurrent, $http) {
    // pour appeler les templates
    return {
        templateUrl: 'template/rune-manager.html',
        link: function(scope) {
            scope.add_rune = function(addRune){
                console.log(addRune);
                $http.get('http://' + addRune.ip).then(function(response){
                    console.log(response);
                    if(response.data == "ça marche"){
                        console.log('rune added');
                        scope.runes.push(new Rune(addRune));
                        scope.runePush();

                        $rootScope.runes = scope.runes;

                        scope.addRune.label = "";
                        scope.addRune.ip = "";
                    }
                    else{
                        alert('Communication impossible avec l\'API. Vérifiez l\'IP et le port 83');
                    }
                }, function(error){
                    alert('Communication impossible avec le rune. Vérifiez l\'IP et le port 83');
                    console.log(error);
                });

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