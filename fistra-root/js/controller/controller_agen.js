angular.module('AgenController',['ShowServices','TxServices'])

//controller untuk data Agen
.controller('dataCtrl',function($scope,$ionicSideMenuDelegate,$cordovaGeolocation,Agen,$timeout,TxData,$state,$ionicModal,$ionicPopup,$ionicPlatform,$ionicLoading){
	//services google map
	geocoder = new google.maps.Geocoder();
	//end services google map

	//varibale agen
	$scope.ruteAgen = [];
	$scope.agens = [];
	$scope.agenBus=[];
	$scope.agenTravel=[];
	$scope.jenis_agens = [];
	$scope.jenis_agen = [];
	//end variable agen

	//Service Agen
	Agen.allAgen().then(function(result){
		$scope.agens = result;
	});
	//end service agen

	//Service Agen Bus
	Agen.allAgenBus().then(function(result){
		$scope.agenBus = result;
	});
	//end service agen
	
	//Service Agen Travel
	Agen.allAgenTravel().then(function(result){
		$scope.agenTravel = result;
	});
	//end service agen

	//get rute all
	Agen.getRuteAll().then(function(result){
		$scope.ruteAgen = angular.copy(result);
		for(i=0;i<result.length;i++){
			if($scope.ruteAgen[i].flag_awal == 0){
				$scope.ruteAgen[i].flag_awal = false;
			}
		}
		return $scope.ruteAgen;
	});
	//end get rute all

	//jenis agen
	Agen.getJenisAgen().then(function(result){
		$scope.jenis_agens = result;
		$scope.jenis_agen = result[0];
	});
	//end service jenis agen

	//toggle for menu
	$scope.toggleLeft = function() {
    $ionicSideMenuDelegate.toggleLeft();
 	}
 	//end toggle for menu

 	//Configuration modal
	$ionicModal.fromTemplateUrl('templates/form.html',function(dialog){
		$scope.dialog = dialog;
	},{
		scope: $scope,
		animation:'slide-in-up'
	});
	//end configuration modal
	
	//show search box
	$scope.showSearchBox = function(cari){
		$scope.cariAksi = cari;
		console.log(cari);
	};
	//end close search box

	//clear cari
	$scope.clearCari = function(){
		$scope.agens.searchQuery="";
	};
	//end clear cari


	//close search
	$scope.closeSearch = function(){
		$scope.cariAksi =null;
		$scope.agens.searchQuery="";	
	};
	//end close search

	//Ion Refresher Function
	$scope.refreshAgen = function(){
		$timeout(function(){
			Agen.allAgen().then(function(result){
				$scope.agens = result;
			});
			Agen.allAgenBus().then(function(result){
				$scope.agenBus = result;
			});
			Agen.allAgenTravel().then(function(result){
				$scope.agenTravel = result;
			});
			$scope.$broadcast('scroll.refreshComplete');
		},1000);
	};
	//end ion refresher function

	//Configuration each modal
	$scope.showTambahEditDialog = function(aksi){
		$scope.aksi = aksi;
		$scope.dialog.show();
	};
	//end configuration each modal

	//remove  dialog
	$scope.exitDialog = function(){
		$scope.dialog.remove();
		$ionicModal.fromTemplateUrl('templates/form.html',function(dialog){
			$scope.dialog = dialog;
		},{
			scope: $scope,
			animation:'slide-in-up'
		});
	};
	//end remove dialog

	//save empty
	$scope.saveEmpty = function(dataInput){
		$scope.form = angular.copy(dataInput);
	};
	//end save empty

	//get Alamat
	$scope.getAlamat = function(lat,ltg,fn){
		var latlng = new google.maps.LatLng(lat,ltg);
		geocoder.geocode({'latLng':latlng},function(result,status){
			fn(result[0].formatted_address);
		});
	};
	//end get Alamat
	
	//function to input data
	$scope.doInput = function(dataInput){
		var newInput = {};
		$scope.isEmptyNama = dataInput.nama.$error;
		$scope.isEmptyAlamat = dataInput.alamat.$error;
		$scope.isEmptyTeleponSelular = dataInput.telepon1.$error;
		$scope.isEmptyTeleponKantor = dataInput.telepon2.$error;

		newInput.nama = dataInput.nama.$modelValue;
		newInput.jenis_agen = dataInput.jenis_agen.$modelValue;
		newInput.alamat = dataInput.alamat.$modelValue;
		newInput.telepon1 = dataInput.telepon1.$modelValue;
		newInput.telepon2 = dataInput.telepon2.$modelValue;
		newInput.lokasi = dataInput.lokasi_saya.$modelValue;

		var confirmPopup = $ionicPopup.confirm({
			title:'Peringatan',
			template:"<div align='center'>Apakah Anda Yakin Akan Menambahkan Data Agen?</div>",
			buttons:[
			{
				text:'Tidak',onTap:function(e){
					console.log('Tidak Terjadi Tambah Data Agen');
				}
			},{
				text:'Ya',type:'button-dark',onTap:function(e){
					if(e){
						$ionicLoading.show({
						    content: 'Loading',
						    animation: 'fade-in',
						    showBackdrop: true,
						    maxWidth: 200
					  	});
						if(dataInput.nama.$valid && dataInput.jenis_agen.$valid){
							if(newInput.lokasi == true){
									TxData.getIdAgen().then(function(result){
										var posOptions = {enableHighAccuracy:true,timeout:10000};
							 			$cordovaGeolocation.getCurrentPosition(posOptions).then(function(pos){
											var latInput = pos.coords.latitude;
											var longInput = pos.coords.longitude;

											$scope.getAlamat(latInput,longInput,function(alamat){
												TxData.insertAgen(result,newInput.nama,newInput.jenis_agen.id_jenis,latInput,longInput);
													$scope.ruteAgen.forEach(function(rute){
														//console.log(rute.flag1);
														var flag;
														if(rute.flag_awal == true){
															flag = 1;
														}else{
															flag = 0;
														}
														//console.log(result,rute.id_tujuan_rute,flag);
														TxData.insertRute(result,rute.id_tujuan_rute,flag);
													});

									 				TxData.getIdProfil().then(function(profilId){
									 					//console.log(profilId+','+result,alamat+','+newInput.telepon1+','+newInput.telepon2);
									 					TxData.insertProfil(profilId,result,alamat,newInput.telepon1,newInput.telepon2);

									 				});
							 				
											});

											$timeout(function() {
										 		$scope.exitDialog();
										 	 	$ionicLoading.hide();
										 	 	$ionicPopup.alert({
													title: 'Peringatan',
													content: "<div align='center'>Berhasil Menambahkan Data Agen Dengan Nama Agen: "+newInput.nama+"</div>",
													buttons:[{
														text:"OK",type:'button-dark',onTap:function(e){
															return
														}
													}]
												});
										    }, 6000);

										}, function (error) {
											$ionicLoading.show({
											    content: 'Loading',
											    animation: 'fade-in',
											    showBackdrop: true,
											    maxWidth: 200
										  	});
										 	$timeout(function() {
										 		$scope.exitDialog();
												$ionicLoading.hide();
												$ionicPopup.alert({
													title: 'Peringatan',
													content: "<div align='center'>Gagal Memasukkan Data, Karena Kesalahan Pengambilan Lokasi,karena "+error+"</div>",
													buttons:[{
														text:"OK",type:'button-dark',onTap:function(e){
															return
														}
													}]
												});
										    }, 3000);
									    });
						 			});	
								
							}else{
								if(dataInput.alamat.$valid){
									TxData.getIdAgen().then(function(results){
										geocoder.geocode({'address':newInput.alamat},function(result,status){
											if(status == google.maps.GeocoderStatus.OK){							
												var latitude = result[0].geometry.location.lat();
												var longitude = result[0].geometry.location.lng();

												TxData.insertAgen(results,newInput.nama,newInput.jenis_agen.id_jenis,latitude,longitude);

													$scope.ruteAgen.forEach(function(rute){
														//console.log(rute.tujuan_rute,rute.flag);
														var flag;
														if(rute.flag_awal == true){
															flag = 1;
														}else{
															flag = 0;
														}
														TxData.insertRute(results,rute.id_tujuan_rute,flag);
													});

									 				TxData.getIdProfil().then(function(profilId){
									 					TxData.insertProfil(profilId,results,newInput.alamat,newInput.telepon1,newInput.telepon2);

										 			});
									 			$timeout(function() {
											 		$scope.exitDialog();
											 	 	$ionicLoading.hide();
											 	 	$ionicPopup.alert({
														title: 'Peringatan',
														content: "<div align='center'>Berhasil Menambahkan Data Agen Dengan Nama Agen: "+newInput.nama+"</div>",
														buttons:[{
															text:"OK",type:'button-dark',onTap:function(e){
																return
															}
														}]
													});
											    }, 6000);
											}else{
												$ionicLoading.show({
													    content: 'Loading',
													    animation: 'fade-in',
													    showBackdrop: true,
													    maxWidth: 200
											  	});
											 	$timeout(function() {
											 		$scope.exitDialog();
											 	 	$ionicLoading.hide();
													$ionicPopup.alert({
														title: 'Peringatan',
														content: "<div align='center'>Gagal Memasukkan Data, Karena Kesalahan Pada Koordinat Alamat : "+status+"</div>",
														buttons:[{
															text:"OK",type:'button-dark',onTap:function(e){
																return
															}
														}] 
													});
											    }, 3000);
											}
										});
					 				});	
								}
							}
						}
					}
				}
			}]
		});
 	};
 	//end function to input data

 	//function to edit data
 	$scope.doEdit = function(dataInput){
 		var newInput = {};
 		
 		$scope.isEmptyNama = dataInput.nama.$error;
		$scope.isEmptyAlamat = dataInput.alamat.$error;
		$scope.isEmptyTeleponSelular = dataInput.telepon1.$error;
		$scope.isEmptyTeleponKantor = dataInput.telepon2.$error;

 		newInput.id_agen = dataInput.id_agen.$modelValue;
 		newInput.id_profil = dataInput.id_profil.$modelValue;
 		newInput.nama = dataInput.nama.$modelValue;
		newInput.jenis_agen = dataInput.jenis_agen.$modelValue;
		newInput.alamat = dataInput.alamat.$modelValue;
		newInput.telepon1 = dataInput.telepon1.$modelValue;
		newInput.telepon2 = dataInput.telepon2.$modelValue;
		newInput.lokasi = dataInput.lokasi_saya.$modelValue;

 		var confirmPopup = $ionicPopup.confirm({
 			title:'Peringatan',
 			template:"<div align='center'>Apakah Anda Yakin Akan Mengedit Data Agen?</div>",
 			buttons:[
 			{
 				text:'Tidak',onTap:function(e){
 					console.log('Tidak Terjadi Edit Data Agen');
 				}

 			},{
 				text:'Ya',type:'button-dark',onTap:function(e){
 					if(e){
 						$ionicLoading.show({
						    content: 'Loading',
						    animation: 'fade-in',
						    showBackdrop: true,
						    maxWidth: 200
					  	});
				 		if(dataInput.nama.$valid && dataInput.jenis_agen.$valid){
							if(newInput.lokasi == true){			
									var posOptions = {enableHighAccuracy:true,timeout:10000};
									$cordovaGeolocation.getCurrentPosition(posOptions).then(function(pos){
										var latInput = pos.coords.latitude;
										var longInput = pos.coords.longitude;

										$scope.getAlamat(latInput,longInput,function(alamat){
											$scope.ruteAgen.forEach(function(rute){
											//console.log(rute.id_tujuan_rute,rute.flag_rute);
												var flag;
												if(rute.flag_rute == true){
													flag = 1;
												}else{
													flag = 0;
												}
											TxData.editRute(newInput.id_agen,rute.id_tujuan_rute,flag);
											});
											// TxData.editRute(newInput.id_agen,"Jakarta",0);
											TxData.editAgen(newInput.id_agen,newInput.nama,newInput.jenis_agen.id_jenis,latInput,longInput);
											TxData.editProfil(newInput.id_profil,alamat,newInput.telepon1,newInput.telepon2);
										},function(error){
											$ionicLoading.show({
											    content: 'Loading',
											    animation: 'fade-in',
											    showBackdrop: true,
											    maxWidth: 200
										  	});
										 	$timeout(function() {
										 		$scope.exitDialog();
												$ionicLoading.hide();
												$ionicPopup.alert({
													title: 'Peringatan',
													content: "<div align='center'>Gagal Mengubah Data, Karena Kesalahan Pengambilan Lokasi,karena "+error+"</div>",
													buttons:[{
														text:"OK",type:'button-dark',onTap:function(e){
															return
														}
													}]
												});
										    }, 6000);
										});
									});	

							}else{
								if(dataInput.alamat.$valid){
									geocoder.geocode({'address':newInput.alamat},function(result,status){
										if(status == google.maps.GeocoderStatus.OK){
											var latitude = result[0].geometry.location.lat();
											var longitude = result[0].geometry.location.lng();
											// console.log(latitude);

											$scope.ruteAgen.forEach(function(rute){
											//console.log(rute.id_tujuan_rute,rute.flag_rute);
												var flag;
												if(rute.flag_rute == true){
													flag = 1;
												}else{
													flag = 0;
												}
											TxData.editRute(newInput.id_agen,rute.id_tujuan_rute,flag);
											});
											// TxData.editRute(newInput.id_agen,"Jakarta",0);
											TxData.editAgen(newInput.id_agen,newInput.nama,newInput.jenis_agen.id_jenis,latitude,longitude);
											TxData.editProfil(newInput.id_profil,newInput.alamat,newInput.telepon1,newInput.telepon2);
											
										}else{
											$ionicLoading.show({
												    content: 'Loading',
												    animation: 'fade-in',
												    showBackdrop: true,
												    maxWidth: 200
										  	});
										 	$timeout(function() {
										 		$scope.exitDialog();
										 	 	$ionicLoading.hide();
												$ionicPopup.alert({
													title: 'Peringatan',
													content: "<div align='center'>Gagal Mengubah Data, Karena Kesalahan Pada Koordinat Alamat : "+status+"</div>",
													buttons:[{
														text:"OK",type:'button-dark',onTap:function(e){
															return
														}
													}] 
												});
										    }, 6000);
										}
									});
								}
							}
						}
						$timeout(function() {
					 		$scope.exitDialog();
					 	 	$ionicLoading.hide();
					 	 	$ionicPopup.alert({
								title: 'Peringatan',
								content: "<div align='center'>Berhasil Mengubah Data Agen Dengan Nama Agen: "+newInput.nama+"</div>",
								buttons:[{
									text:"OK",type:'button-dark',onTap:function(e){
										return
									}
								}]
							});
					    }, 6000);
 					}
 				}
 			}]
 		});
 	};
 	//end function to edit data

 	//remove Data
	$scope.removeData = function(dataAgen){
		var confirmPopup = $ionicPopup.confirm({
  			title:'Peringatan',
  			template:"<div align='center'>Apakah Anda Yakin Akan Menghapus Agen "+dataAgen.nama_agen+"?</div>",
  			buttons:[
  			{
  				text:'Tidak',onTap:function(e){
  					console.log('Tidak Terjadi Hapus Data Agen')
  				}	
  			},
  			{
  				text:'<b>Ya</b>',type:'button-dark',onTap:function(e){
  					if(e){
  						TxData.removeAgen(dataAgen.id_agen);
						TxData.removeProfil(dataAgen.id_profil);
						TxData.removeRute(dataAgen.id_agen);
						Agen.allAgen().then(function(result){
							$scope.agens = result;
						});
						Agen.allAgenBus().then(function(result){
							$scope.agenBus = result;
						});
						Agen.allAgenTravel().then(function(result){
							$scope.agenTravel = result;
						});
  					}
  				}
  			}]
		});
	};
	//end function to remove data

	//edit Data Load
	$scope.editData = function(dataAgen){
		$scope.id_agen = dataAgen.id_agen;
		$scope.id_profil = dataAgen.id_profil;
		$scope.nama = dataAgen.nama_agen;
		Agen.getJenisAgen().then(function(result){
			$scope.jenis_agens = result;
			if(dataAgen.id_jenis == 1){
				$scope.jenis_agen = result[0];
			}else{
				$scope.jenis_agen = result[1];
			}
		});
		$scope.alamat = dataAgen.alamat_agen;
		$scope.telepon1 = dataAgen.phone_agen_satu;
		$scope.telepon2 = dataAgen.phone_agen_dua;
		$scope.lat_lokasi = dataAgen.lat_lokasi;
		$scope.long_lokasi = dataAgen.long_lokasi;

		Agen.getRuteByid(dataAgen.id_agen).then(function(result){
			$scope.ruteAgen = angular.copy(result);
			for(i=0;i<result.length;i++){
				if($scope.ruteAgen[i].flag_rute == 1){
					$scope.ruteAgen[i].flag_rute = true;
				}
			}
			return $scope.ruteAgen;		
		});

		$scope.showTambahEditDialog('ubah');
	};
	//end edit Data Load
	
	//cek checkbox rute agen
	$scope.changeRuteAgen = function(){
		console.log($scope.ruteAgen);	
	};
	//end cek checkbox
	
});