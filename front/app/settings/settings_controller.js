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

        $scope.change_settings = function (){
            $obj = {
                'airplay' : $scope.airplay.enable,
                'airplay_name' : $scope.airplay.name,
                'spotify' : $scope.spotify.enable,
                'spotify_user' : $scope.spotify.username,
                'spotify_pass' : $scope.spotify.password,
                'dlna' : $scope.upnp.enable,
                'dlna_name' : $scope.upnp.name,
                'udevil' : $scope.usb.enable,
                'coverart' : $scope.album.enable,
                'lastfm' : $scope.lastfm.enable,
                'lastfm_user' : $scope.lastfm.username,
                'lastfm_pass' : $scope.lastfm.password
            };
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
                    $scope.album.enable = features.coverart == 1 ? true : false;
                    $scope.lastfm.enable = features.lastfm == 1 ? true : false;
                    $scope.lastfm.username = features.lastfm_username;
                    $scope.lastfm.password = features.lastfm_password;
                });
        };

        $scope.get_settings();
    }]
);