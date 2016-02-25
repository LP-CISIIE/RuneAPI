/**
 * Created by LocoMan on 25/02/2016.
 */
rune.service('Playlist', ['$http', '$rootScope', function($http, $rootScope){
    var Playlist = function(data){
        this.id = data.id;
    };

    return Playlist;
}]);