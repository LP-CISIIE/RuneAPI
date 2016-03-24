/**
 * Created by LocoMan on 25/02/2016.
 */
rune.service('Settings', ['$http', '$rootScope', function($http, $rootScope){
    var Setting = function(data){
        this.ip = "truc";
    };

    return Setting;
}]);