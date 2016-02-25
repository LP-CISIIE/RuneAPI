rune.service('Player', ['$http', '$rootScope', function($http, $rootScope){
    var Player = function(data){
        this.id = data.id;
    };

    return Player;
}]);