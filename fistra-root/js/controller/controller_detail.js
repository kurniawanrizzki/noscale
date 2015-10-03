angular.module('DetailController',['ShowServices','TxServices'])

//controller untuk detailed Agen
.controller('detailAgenCtrl',function($scope,$stateParams,$ionicModal,$cordovaSocialSharing,Agen){
	$scope.agen = null;
	//Agen By Id
	Agen.getByIdAgen($stateParams.agenId).then(function(result){
		$scope.agen = result;
	},function(error){
		console.log("ERROR PADA detailAgenCtrl--> "+error);
	});

	//All agen rute
	Agen.allAgenRute($stateParams.agenId).then(function(result){
		$scope.ruteDetail = result;
		//console.log($scope.ruteDetail);
	},function(error){
		console.log("ERROR PADA detailAgenCtrl--> "+error);
	});

	//sms telepon function
	$scope.kirimSMS = function(notelepon,body){
		var d = new Date();
		var n = d.getHours();

		if(n > 1 && n <  12){
			$cordovaSocialSharing.shareViaSMS("Selamat Pagi Agen "+body+" . . . ", notelepon);
		}else if(n >= 12 && n<16){
			$cordovaSocialSharing.shareViaSMS("Selamat Siang Agen "+body+" . . . ", notelepon);
		}else if(n >=16 && n<21){
			$cordovaSocialSharing.shareViaSMS("Selamat Sore Agen "+body+" . . . ", notelepon);
		}else{
			$cordovaSocialSharing.shareViaSMS("Selamat Malam Agen "+body+" . . . ", notelepon);
		}
	};
});