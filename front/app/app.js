var rune = angular.module('rune', ['ui.materialize']).config(function($sceProvider) {
    // Completely disable SCE.  For demonstration purposes only!
    // Do not use in new projects.
    $sceProvider.enabled(false);
});

rune.config(function ($httpProvider) {
  $httpProvider.defaults.headers.common = {};
  $httpProvider.defaults.headers.post = {};
  $httpProvider.defaults.headers.put = {};
  $httpProvider.defaults.headers.patch = {};
});

$(function(){
    //$("#iframe").contents().find("span").hide();

});
$(function(){
    var f=$('#iframe');
    f.load(function(){
        f.contents().find('div').hide();
    });
});


