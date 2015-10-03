angular.module('telkomakses.starter', ['ionic','ngCordova','angularCircularNavigation','angular-md5','ngNotificationsBar', 'ngSanitize','telkomakses.controllers','directives','telkomakses.services'])

.run(function($rootScope, $ionicPlatform, $ionicHistory) {
  $ionicPlatform.ready(function() {
    if(window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if(window.StatusBar) {
      StatusBar.styleDefault();
    }
  });

  $ionicPlatform.registerBackButtonAction(function(e){
    if ($rootScope.backButtonPressedOnceToExit) {
      ionic.Platform.exitApp();
    }

    else if ($ionicHistory.backView()) {
      $ionicHistory.goBack();
    }
    else {
      $rootScope.backButtonPressedOnceToExit = true;
      window.plugins.toast.showShortCenter(
        "Press back button again to exit",function(a){},function(b){}
      );
      setTimeout(function(){
        $rootScope.backButtonPressedOnceToExit = false;
      },2000);
    }
    e.preventDefault();
    return false;
  },101);
})



.config(function($stateProvider,$urlRouterProvider){
  $stateProvider
  
  .state('login', {
    url: '/login',
    templateUrl: 'src/v_login_bar.html',
    controller:'login'
  })

  .state('beranda',{
    url:'/beranda',
    templateUrl:'src/v_beranda_bar.html',
    controller:'beranda',
    onEnter:function($state,Services){
      if(!Services.isLoggedIn()){
        $state.go('login');
      }
    }
  })

  .state('data',{
    url:'/data',
    templateUrl:'src/v_data_bar.html',
    controller:'data',
    onEnter:function($state,Services){
      if(!Services.isLoggedIn()){
        $state.go('login');
      }
    }
  })

  $urlRouterProvider.otherwise('/login');
})
