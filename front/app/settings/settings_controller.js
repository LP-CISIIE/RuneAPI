/**
 * Created by LocoMan on 25/02/2016.
 */
rune.controller('SettingsController',
    ['$scope', '$http', '$rootScope', 'runeCurrent', 'Rune', function($scope, $http, $rootScope, runeCurrent, Rune){
        $scope.airplay = {};
        $scope.airplay.enable = false;
        $scope.airplay.name = "";
        $scope.spotify = {};
        $scope.spotify.enable = false;
        $scope.spotify.username = "";
        $scope.spotify.password = "";
        $scope.upnp = {};
        $scope.upnp.enable = false;
        $scope.upnp.name = "";
        $scope.usb = {};
        $scope.usb.enable = false;
        $scope.album = {};
        $scope.album.enable = false;
        $scope.lastfm = {};
        $scope.lastfm.enable = false;
        $scope.lastfm.username = "";
        $scope.lastfm.password = "";

        // airplay enable
        $scope.airplay_enable = function (){
            $obj = JSON.stringify({"airplay":$scope.airplay.enable});
            console.log($obj);
            $http.put($rootScope.root + '/settings', $obj)
                .then(function(response){
                    console.log(response);
                });
        };

        // airplay name
        $scope.airplay_name = function (){
            $obj = JSON.stringify({"airplay_name":$scope.airplay.name});
            console.log($obj);
            $http.put($rootScope.root + '/settings', $obj)
                .then(function(response){
                    console.log(response);
                });
        };

        // spotify enable
        $scope.spotify_enable = function (){
            $obj = JSON.stringify({"spotify":$scope.spotify.enable});
            console.log($obj);
            $http.put($rootScope.root + '/settings', $obj)
                .then(function(response){
                    console.log(response);
                });
        };

        // spotify account
        $scope.spotify_account = function (){
            $obj = JSON.stringify({"spotify_username":$scope.spotify.username, "spotify_password":$scope.spotify.password});
            console.log($obj);
            $http.put($rootScope.root + '/settings', $obj)
                .then(function(response){
                    console.log(response);
                });
        };

        // UPnP DLNA enable
        $scope.upnp_enable = function (){
            $obj = JSON.stringify({"upnp_dlna":$scope.upnp.enable});
            console.log($obj);
            $http.put($rootScope.root + '/settings', $obj)
                .then(function(response){
                    console.log(response);
                });
        };

        // UPnP name
        $scope.upnp_name = function (){
            $obj = JSON.stringify({"upnp_dlna_name":$scope.upnp.name});
            console.log($obj);
            $http.put($rootScope.root + '/settings', $obj)
                .then(function(response){
                    console.log(response);
                });
        };

        // usb automount enable
        $scope.usb_enable = function (){
            $obj = JSON.stringify({"usb_automount":$scope.usb.enable});
            console.log($obj);
            $http.put($rootScope.root + '/settings', $obj)
                .then(function(response){
                    console.log(response);
                });
        };

        // display_album_cover
        $scope.album_enable = function (){
            $obj = JSON.stringify({"display_album_cover":$scope.album.enable});
            console.log($obj);
            $http.put($rootScope.root + '/settings', $obj)
                .then(function(response){
                    console.log(response);
                });
        };

        // lastfm enable
        $scope.lastfm_enable = function (){
            $obj = JSON.stringify({"last_fm":$scope.lastfm.enable});
            console.log($obj);
            $http.put($rootScope.root + '/settings', $obj)
                .then(function(response){
                    console.log(response);
                });
        };

        // lastfm account
        $scope.lastfm_account = function (){
            $obj = JSON.stringify({"lastfm_username":$scope.lastfm.username, "lastfm_password":$scope.lastfm.password});
            console.log($obj);
            $http.put($rootScope.root + '/settings', $obj)
                .then(function(response){
                    console.log(response);
                });
        };

        $scope.get_settings = function (){
            $http.get($rootScope.root + '/settings')
                .then(function(response){
                    console.log(response.data.settings.features);
                    features = response.data.settings.features;
                    $scope.airplay.enable = features.airplay == 1 ? true : false;
                    $scope.airplay.name = features.airplay_name;
                    $scope.spotify.enable = features.spotify == 1 ? true : false;
                    $scope.spotify.username = features.spotify_username;
                    $scope.spotify.password = features.spotify_password;
                    $scope.upnp.enable = features.upnp_dlna == 1 ? true : false;
                    $scope.upnp.name = features.upnp_dlna_name;
                    $scope.usb.enable = false;
                    $scope.album.enable = false;
                    $scope.lastfm.enable = features.lastfm == 1 ? true : false;
                    $scope.lastfm.username = features.lastfm_username;
                    $scope.lastfm.password = features.lastfm_password;
                });
        };

        $scope.get_settings();
    }]
);