/**
 * Created by LocoMan on 25/02/2016.
 */
rune.service('Rune', ['$http', '$rootScope', function($http, $rootScope){
    var Rune = function(data){
        this.id = data.id;
        this.ip = data.ip;
        this.label = data.label;
    };

    return Rune;
}]);