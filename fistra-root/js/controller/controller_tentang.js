angular.module('tentangController',['ShowServices','TxServices'])

//controller setting
.controller('tentangCtrl',function($scope,$ionicPopup,Agen,TxData){
	$scope.settings=[{text:'Kosongkan Riwayat',flag:false}];

	$scope.pushSettingsChange = function() {
    	if($scope.settings[0].flag== true){
    		Agen.getPencarian().then(function(result){
    			if(result.length != 0){
    				var confirmPopup = $ionicPopup.confirm({
			  			title:'Peringatan',
			  			template:"<div align='center'>Apakah Anda Yakin Akan Mengosongkan Data Riwayat?</div>",
			  			buttons:[
			  			{
			  				text:'Tidak',onTap:function(e){
			  					$scope.settings[0].flag = false;
			  				}	
			  			},
			  			{
			  				text:'<b>Ya</b>',type:'button-dark',onTap:function(e){
			  					if(e){
			  						TxData.removeAllPencarian();
			  						TxData.removeAllSpesifikasi();
			  						TxData.removeAllOpsiMap();
			  						TxData.removeAllLokasiPerangkat();
			  						$scope.settings[0].flag = false;
			  					}
			  				}
			  			}]
					});
    			}else{
    				$scope.settings[0].flag = false;
    				$ionicPopup.alert({
				      title: 'Peringatan',
				      content: "<div align='center'>Data Kosong</div>"
				    });
    			}

			});
    	}
  	};
});
