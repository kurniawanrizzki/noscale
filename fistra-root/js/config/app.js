// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.controllers' is found in controllers.js
angular.module('starter', ['ionic','ngMessages','ngCordova','MapController','AgenController','DetailController','RiwayatController','tentangController','DBServices','directives'])

.run(function($ionicPlatform,$ionicPopup,DB) {
  $ionicPlatform.ready(function() {
    if(window.cordova && window.cordova.plugins.Keyboard) {
          cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
        }
    if(window.StatusBar) {
        // org.apache.cordova.statusbar required
        StatusBar.styleDefault();
    }
    if(window.Connection){
      
      if(navigator.connection.type === Connection.NONE){
         $ionicPopup.confirm({
            title: "Peringatan",
            content: "Tidak Terhubung Dengan Koneksi Internet",
            buttons:[{
              text:"OK",type:'button-dark',onTap:function(e){
                navigator.app.exitApp();
              }
            }]
          });
      }
    }

    DB.init();
  
  });
})

//buat ngilangin back button
.config(function($ionicConfigProvider) {
    $ionicConfigProvider.backButton.previousTitleText(false);
    $ionicConfigProvider.backButton.text('').icon('ion-ios7-arrow-left');
})

.config(function($stateProvider,$urlRouterProvider){
  $stateProvider
  //parent menu
  .state('menu',{
    url:"/menu",
    abstract:true,
    templateUrl:"templates/Menu.html",
  })
  //child
  .state('menu.dashboard',{
    url:"/dash",
    views:{
      'menuContent':{
        templateUrl:"templates/dash.html",
        controller:'MapCtrl'
      }
    }
  })

  .state('menu.agen',{
    url:"/agen",
    views:{
      'menuContent':{
        templateUrl:"templates/agen.html",
        controller:'dataCtrl'
      }
    }
  })
  .state('menu.detail',{
    url:'/agen/:agenId',
    views:{
      'menuContent':{
        templateUrl:'templates/detail.html',
        controller:'detailAgenCtrl'
      }
    }
  })

  .state('menu.history',{
    url:"/history",
    views:{
      'menuContent':{
        templateUrl:"templates/hist.html",
        controller:'riwayatCtrl'
      }
    }
  })

  .state('menu.tentang',{
    url:"/tentang",
    views:{
      'menuContent':{
        templateUrl:"templates/tentang.html",
        controller:'tentangCtrl'
      }
    }
  });
  $urlRouterProvider.otherwise('/menu/dash');
})
