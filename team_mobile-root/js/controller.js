angular.module('telkomakses.controllers', [])

.controller('navigation',function($scope,$ionicPopover,$ionicModal,$ionicLoading,$state,$timeout,Services,notifications,md5){
	//popover menu

	$scope.tourGuideActive = 0;

	//logout sistem
	$scope.logoutSistem = function(){
		$ionicLoading.show({
			content:'Loading',
			animation:'fade-in',
			showBackdrop:true,
			maxWidth:200
		});
		$timeout(function(){
			$ionicLoading.hide();
			Services.logoutTime({id:Services.getUser().id_user});
			Services.logout();
			$state.go('login');
		},4000)
	}
	$ionicPopover.fromTemplateUrl('src/v_menu_bar.html', {
		scope: $scope,
	}).then(function(popover) {
		$scope.popover = popover;
	});

	$scope.show = function($event){
		$scope.dataPegawai = [{id:Services.getUser().id_pegawai,img:Services.getUser().img,nama:Services.getUser().nama}];

		$scope.popover.show($event);
	}

 	//Modal Configuration
  	$ionicModal.fromTemplateUrl('src/v_setting_modal.html',function(setting){
  		$scope.setting = setting;
  	},{
  		scope:$scope,
  		animation:'slide-in-up'
  	});
  	//end modal configuration
  	
  	$scope.showSetting = function(){
  		Services.getDataPegawai({id:Services.getUser().id_pegawai}).success(function(data){
  			$scope.pegawai = data;
  		});
  		$scope.dataEdit = {alamat:false,kontak:false,email:false,pass:false};
  		$scope.setting.show();
  	};

  	$scope.editDataPegawai = function(item){
	  	$ionicLoading.show({
			content:'Loading',
			animation:'fade-in',
			showBackdrop:true,
			maxWidth:200
		});
  		if(item.alamat || item.kontak || item.email || item.pass){
	  		$timeout(function(){
		  		if(item.alamat){
		  			if(item.xalamat){
		  				Services.editPegawai({id_pegawai:Services.getUser().id_pegawai,alamat_pegawai:item.xalamat});
		  			}else{
		  				console.log('Tidak Merubah Alamat');
		  			}
		  		}else if(item.kontak){
		  			if(item.xkontak){
						Services.editPegawai({id_pegawai:Services.getUser().id_pegawai,telp_hp_pegawai:item.xkontak});
		  			}else{
						console.log('Tidak Merubah Kontak');
		  			}
		  		}else if(item.email){
		  			if(item.xemail){
		  				console.log(item.xemail);
						Services.editPegawai({id_pegawai:Services.getUser().id_pegawai,email_pegawai:item.xemail});
						Services.logoutTime({id:Services.getUser().id_user});
						Services.logout();
						$timeout(function(){
							$state.go('login');
						},2500)
		  			}else{
		  				console.log('Tidak Merubah Email');
		  			}
		  		}else if(item.pass){
		  			var xpasmd5 = md5.createHash(item.xpass_c.toUpperCase());
		  			var xpas = md5.createHash(item.xpass.toUpperCase());
		  			if(xpasmd5 == Services.getUser().pass ){
						Services.editPegawai({id_user:Services.getUser().id_user,pass:xpas});
						Services.logoutTime({id:Services.getUser().id_user});
						Services.logout();
						$timeout(function(){
							$state.go('login');
						},2500)
		  			}else{
						notifications.showError({
							message: 'Gagal Memverifikasi Password!',
							hideDelay: 3000, //ms
							hide: true, //bool
							autoHideAnimation:'fadeOutNotifications',
							autoHideAnimationDelay:1200
						});

						Services.logoutTime({id:Services.getUser().id_user});
						Services.logout();
						$state.go('login');
		  			}	
		  		}else{
		  			console.log('Anda Tidak Merubah Data!');
		  		}
		  		$ionicLoading.hide();
				notifications.showSuccess({
					message: 'Data Berhasil Di Update',
					hideDelay: 3000, //ms
					hide: true, //bool
					autoHideAnimation:'fadeOutNotifications',
					autoHideAnimationDelay:1200
				});
	  		},4000)
  		}else{
	  		$timeout(function(){
	  			$ionicLoading.hide();
				notifications.showWarning({
					message:'Anda Tidak Melakukan Perubahan Data',
					hideDelay:3000,
					hide:true,
					autoHideAnimation:'fadeOutNotifications',
					autoHideAnimationDelay:1200
				});
	  		},4000)
  		}

		$timeout(function(){
			$scope.removeSetting();
		},4000);
  	}

  	$scope.removeSetting =function(){
  		$scope.setting.remove();	

  		$ionicModal.fromTemplateUrl('src/v_setting_modal.html',function(setting){
			$scope.setting = setting;
		},{
			scope: $scope,
			animation:'slide-in-up'
		});
  	};

	$scope.switchType = function (options, clicked) {
	  $scope.options.items[0].isActive = false;
	  $scope.options.items[1].isActive = false;
	  clicked.isActive = true;

	  if(clicked.cssClass == 'ion-person-stalker'){
	  	$state.go('data');
	  }else{
	  	$state.go('beranda');
	  }
	  $scope.options.button.cssClass = clicked.cssClass;
	};

	$scope.switchType = function (options, clicked) {
	  $scope.options.items[0].isActive = false;
	  $scope.options.items[1].isActive = false;
	  clicked.isActive = true;

	  if(clicked.cssClass == 'ion-person-stalker'){
	  	$state.go('data');
	  }else{
	  	$state.go('beranda');
	  }
	  $scope.options.button.cssClass = clicked.cssClass;
	};

	$scope.options = {
	  content: "",
	  background:'#2980b9',
	  button:{
	  	size:'normal',
		cssClass:'ion-android-pin'
	  },
	  isOpen: false,
	  toggleOnClick: true,
	  items: [
	    {	
	      	cssClass:'ion-person-stalker',
	      	onclick: $scope.switchType
	    },
	    {	
	    	cssClass:'ion-android-pin',
	    	isActive: true,
	      	onclick: $scope.switchType
	    }
	  ]
	};
})

.controller('login',function($scope,$ionicLoading,$timeout,$state,notifications,Services){
	$scope.dataLogin = {};

	//login ke sistem
	$scope.login = function(dataLogin){

		var cek = [{nilai:$scope.dataLogin.e_teknisi},{nilai:$scope.dataLogin.pass}];

		if(cek[0].nilai && cek[1].nilai){

			$ionicLoading.show({
				content:'Loading',
				animation:'fade-in',
				showBackdrop:true,
				maxWidth:200
			});

			Services.loginTeknisi({
				email:cek[0].nilai,
				pass:cek[1].nilai
			}).success(function(data){
				if(data.length > 0){

					if(data[0].grant_status == 'OFF'){
						notifications.showWarning({
							message:'Akun Anda Belum Di Aktivasi, Silahkan Hubungi Kepala Teknisi',
							hideDelay:3000,
							hide:true,
							autoHideAnimation:'fadeOutNotifications',
							autoHideAnimationDelay:1200
						});
					}else{
						Services.setUser({id_user:data[0].id_user,id_pegawai:data[0].id_pegawai,img:data[0].img_pegawai_small,nama:data[0].nama_pegawai,pass:data[0].password});
						Services.loginTimeTeknisi({id_user:data[0].id_user});
						$state.go('beranda');
					}
				}else{
					notifications.showError({
						message: 'Mohon Cek Kembali Ketersediaan Akun Anda!',
						hideDelay: 3000, //ms
						hide: true, //bool
						autoHideAnimation:'fadeOutNotifications',
						autoHideAnimationDelay:1200
					});
				}
			}).error(function(err){
				notifications.showError({
					message: 'Sambungan Internet Terputus!',
					hideDelay: 3000, //ms
					hide: true, //bool
					autoHideAnimation:'fadeOutNotifications',
					autoHideAnimationDelay:1200
				});
			});

			$timeout(function(){
				$ionicLoading.hide();
			},6000);

		}else{
			if(!cek[0].nilai && !cek[1].nilai){
				notifications.showError({
					message: 'Mohon Isikan Email dan Password Akun Anda!',
					hideDelay: 3000, //ms
					hide: true, //bool
					autoHideAnimation:'fadeOutNotifications',
					autoHideAnimationDelay:1200
				});
			}else if(!cek[0].nilai){
				notifications.showError({
					message: 'Mohon Isikan Email Akun Anda!',
					hideDelay: 3000, //ms
					hide: true, //bool
					autoHideAnimation:'fadeOutNotifications',
					autoHideAnimationDelay:1200
				});
			}else{
				notifications.showError({
					message: 'Mohon Isikan Password Akun Anda!',
					hideDelay: 3000, //ms
					hide: true, //bool
					autoHideAnimation:'fadeOutNotifications',
	            	autoHideAnimationDelay:1200
				});
			}
		}
	}
})

.controller('beranda',function($scope,$compile,$ionicLoading,$timeout,$ionicModal,Services,notifications){
	//deklarasi variable
	var directionsService = new google.maps.DirectionsService;
  	var directionsDisplay = new google.maps.DirectionsRenderer({ suppressMarkers: true });
	var id_pegawai = Services.getUser().id_pegawai;
	var markers = [];
	var leg_starts = []; 

	//set button navigation hidden or show
	$scope.$on('$ionicView.afterEnter',function(){
		Services.getDataPelanggan({id:Services.getUser().id_pegawai}).success(function(data){
			$scope.pelanggans = data;
			$scope.dataCari = {cariPelanggan:data[0]};
		}).error(function(err){
			notifications.showError({
				message: 'Sambungan Internet Terputus!',
				hideDelay: 3000, //ms
				hide: true, //bool
				autoHideAnimation:'fadeOutNotifications',
				autoHideAnimationDelay:1200
			});
		});
	});

	//config map
	$scope.mapCreated = function(map) {
		$scope.$on('$ionicView.afterEnter',function(){
			$ionicLoading.show({
				content:'Loading',
				animation:'fade-in',
				showBackdrop:true,
				maxWidth:200
			});

			$timeout(function(){
				$ionicLoading.hide();
				$scope.map = map;
				$scope.centerOnMe();
				$scope.pelangganOnMap(map);	
				$scope.clearOverlay(map);
				directionsDisplay.setMap(null);
			},5500)
		});
  	}

	//set map null
	$scope.clearOverlay = function(map){
		for(var i = 0;i<markers.length;i++){
			markers[i].setMap(null);
			console.log('sukses mereload!');
		}

		for(var i = 0;i<leg_starts.length;i++){
			leg_starts[i].setMap(null);
		}

		leg_starts.splice(0,leg_starts.length);
		markers.splice(0,markers.length);
		$scope.pelangganOnMap(map);
	}

	//center on me
  	$scope.centerOnMe = function(){
		if(!$scope.map){
			return;
		}
		var options = {timeout:3000,enableHighAccuracy:true,maximumAge:6000};
		
		navigator.geolocation.getCurrentPosition(function(pos){
			var lokasi = new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude);
			$scope.map.setCenter(lokasi);
		},function(err){
			if(err.code == 1){
				var err_message = 'GPS Perangkat Tidak Ditemukan';
			}else if(err.code == 2){
				var err_message = 'Posisi Tidak Ditemukan';
			}else{
				var err_message = 'Koneksi Lemah'
			}

			notifications.showError({
				message: 'Terdapat Kesalahan Dalam Menentukan Lokasi Anda, '+err_message,
				hideDelay: 3000, //ms
				hide: true, //bool
				autoHideAnimation:'fadeOutNotifications',
            	autoHideAnimationDelay:1200
			});
		},options);
	}

	//show pelanggan on map
	$scope.pelangganOnMap = function(map){
		Services.getPelangganMarker({id:Services.getUser().id_pegawai}).success(function(data){

			data.forEach(function(koord){
				var lokasi = new google.maps.LatLng(koord.lat_pelanggan,koord.ltg_pelanggan);

		        var content= '<div id="content">'+'<div id="siteNotice">'+'</div>'+
		              '<b id="firstHeading" class="firstHeading" style="color:#000;"><u>'+koord.id_speedy+'</u></b>'+
		              '<div id="bodyContent" style="color:#000;">'+
		              'Nama: '+koord.nama_pelanggan+'</br>'+
		              'Alamat: '+koord.alamat_pelanggan+'</br>'+
		              '</div>'+
		              '</div>';

				var compiled = $compile(content)($scope);

				var info = new google.maps.InfoWindow({content:compiled[0],maxWidth:300});
				var marker = new google.maps.Marker({position:lokasi,map:map,title:koord.nama_pelanggan,icon:'assets/img/marker.png'});
				
				google.maps.event.addListener(marker,'click',function(){
					info.open(map,marker);
				});
				
				markers.push(marker);
			});
		}).error(function(err){
			notifications.showError({
				message: 'Sambungan Internet Terputus!',
				hideDelay: 3000, //ms
				hide: true, //bool
				autoHideAnimation:'fadeOutNotifications',
				autoHideAnimationDelay:1200
			});
		});
	}
	
	//navigasi form	
	$ionicModal.fromTemplateUrl('src/v_navigasi_modal.html',function(navigasi){
  		$scope.navigasi = navigasi;
  	},{
  		scope:$scope,
  		animation:'slide-in-up'
  	});

	//show navigasi
  	$scope.showNavigasi = function(){
  		$scope.navigasi.show();
  	}

  	//remove navigasi
  	$scope.removeNavigasi= function(){
  		$scope.navigasi.remove();
		$ionicModal.fromTemplateUrl('src/v_navigasi_modal.html',function(navigasi){
	  		$scope.navigasi = navigasi;
	  	},{
	  		scope:$scope,
	  		animation:'slide-in-up'
	  	});
  	}

  	//cari method
  	$scope.cari = function(item){
  		var options = {timeout:30000,enableHighAccuracy:true,maximumAge:10000};
  		var xinput = item.cariPelanggan.id_speedy;

		directionsDisplay.setMap($scope.map);

		$ionicLoading.show({
			content:'Loading',
			animation:'fade-in',
			showBackdrop:true,
			maxWidth:200
		});
  		$timeout(function(){
  			$ionicLoading.hide();
  			Services.getPelangganMarkerById({id_speedy:xinput}).success(function(data){
		  		navigator.geolocation.getCurrentPosition(function(pos){
		  		  var destinasi = new google.maps.LatLng(data[0].lat_pelanggan,data[0].ltg_pelanggan);	
		  		  var lokasi_saya = new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude);

				  directionsService.route({
				    origin: lokasi_saya,
				    destination:destinasi,
				    travelMode: google.maps.TravelMode.DRIVING
				  }, function(response, status) {
				    if (status === google.maps.DirectionsStatus.OK) {
				  	  var leg_start = new google.maps.Marker({position:response.routes[ 0 ].legs[ 0 ].start_location,map:$scope.map,icon:'assets/img/my_location.png',title:'Lokasi Saya'});
				      leg_starts.push(leg_start);
				      directionsDisplay.setDirections(response);
				    } else {
				      window.alert('Directions request failed due to ' + status);
				    }
				  });
		  		},function(err){
		  			$ionicLoading.hide();
		  			console.log(err);
		  		},options);
	  		});
  		},6000);
  		$scope.navigasi.hide();
  	}

})

.controller('data',function($scope,$ionicLoading,$ionicModal,$compile,$cordovaSocialSharing,$state,$timeout,Services,notifications){
	//deklarasi variable
	var id_pegawai = Services.getUser().id_pegawai;
	var markers = [];
	var id_speedy_marker;
	var setIdSpeedy;
	var setIdKunjungan;
	var setLatPelanggan;
	var setLtgPelanggan;
	var setAddressPelanggan;
	
  	$scope.dataInput = {statusKunjungan:'SELESAI'};
	$scope.statusKunjunganList=[{text:'MENUNGGU',value:'MENUNGGU'},{text:'SELESAI',value:'SELESAI'}];

	//loading data
	$scope.$on('$ionicView.afterEnter',function(){
		$ionicLoading.show({
			content:'Loading',
			animation:'fade-in',
			showBackdrop:true,
			maxWidth:200
		});

		$timeout(function(){
			$ionicLoading.hide();
			Services.getDataPelanggan({id:id_pegawai}).success(function(data){
				$scope.pelanggan = data;
				//console.log(data);
			}).error(function(err){
				notifications.showError({
					message: 'Sambungan Internet Terputus!',
					hideDelay: 3000, //ms
					hide: true, //bool
					autoHideAnimation:'fadeOutNotifications',
					autoHideAnimationDelay:1200
				});
			});
		},4000);
	});

	//refresh data
	$scope.doRefresh = function(){
	    $timeout(function(){
			Services.getDataPelanggan({id:id_pegawai}).success(function(data){
				$scope.pelanggan = data;

			}).error(function(err){
				notifications.showError({
					message: 'Sambungan Internet Terputus!',
					hideDelay: 3000, //ms
					hide: true, //bool
					autoHideAnimation:'fadeOutNotifications',
					autoHideAnimationDelay:1200
				});
			});
	      	$scope.$broadcast('scroll.refreshComplete');
	    },4000);
  	}

	//menyimpan alamat 
	$scope.setAddress = function(item){
		setAddressPelanggan = item;
	}
	//menyimpan lat
	$scope.setLat = function(item){
		setLatPelanggan = item;
	}
	//menyimpan ltg
	$scope.setLtg = function(item){
		setLtgPelanggan = item;
	}
	//menyimpan marker by id
	$scope.pushMarkerById = function(item){
		id_speedy_marker = item;
	}

	//menyimpan id kunjungan
	$scope.pushIdKunjungan = function(item){
		setIdKunjungan = item;
	}

	//menyimpan id speedy
	$scope.pushIdSpeedy = function(item){
		setIdSpeedy = item;
	}

	//map created detail
	$scope.mapCreatedDetail = function(map) {
		$scope.map = map;
		$scope.pelangganOnIdMap(map);
		$scope.setOnIdMap(map);	
  	};

  	//map created edit
  	$scope.mapCreatedEdit = function(map) {
		$scope.map = map;
		$scope.inputLokasi(map);
  	}

  	//set on id map
	$scope.setOnIdMap = function(map){
		for(var i = 0;i<markers.length;i++){
			markers[i].setMap(map);
		}
	}

	//modal detail
  	$ionicModal.fromTemplateUrl('src/v_detail_modal.html',function(detail){
  		$scope.detail = detail;
  	},{
  		scope:$scope,
  		animation:'slide-in-up'
  	});

  	//show detail
  	$scope.showDetail = function(item){
  		Services.getDetailPelanggan({id_keluhan:item.id_keluhan}).success(function(data){
  			$scope.detailData = data;

  		});
  		$scope.pushMarkerById(item.id_speedy);
		$scope.detail.show();
  	}
  	
  	//remove detail
  	$scope.removeDetail = function(){
		$scope.detail.remove();
		$ionicModal.fromTemplateUrl('src/v_detail_modal.html',function(detail){
			$scope.detail = detail;
		},{
			scope:$scope,
			animation:'slide-in-up'
		});
  	}

	//center on pelanggan
	$scope.centerOnPelanggan = function(item){
		if(!$scope.map){
			return;
		}

		$ionicLoading.show({
			content:'Loading',
			animation:'fade-in',
			showBackdrop:true,
			maxWidth:200
		});

		$timeout(function(){
			$ionicLoading.hide();
			Services.getPelangganMarkerById({id_speedy:item}).success(function(data){

				data.forEach(function(koord){
					
					var lokasi = new google.maps.LatLng(koord.lat_pelanggan,koord.ltg_pelanggan);
					$scope.map.setCenter(lokasi);
					
				});
			}).error(function(err){
				notifications.showError({
					message: 'Sambungan Internet Terputus!',
					hideDelay: 3000, //ms
					hide: true, //bool
					autoHideAnimation:'fadeOutNotifications',
					autoHideAnimationDelay:1200
				});
			});
		},6000)
	}

	//pelanggan on id map
	$scope.pelangganOnIdMap = function(map){
		$scope.centerOnPelanggan(id_speedy_marker);
		Services.getPelangganMarkerById({id_speedy:id_speedy_marker}).success(function(data){

			data.forEach(function(koord){
				var lokasi = new google.maps.LatLng(koord.lat_pelanggan,koord.ltg_pelanggan);

		        var content= '<div id="content">'+'<div id="siteNotice">'+'</div>'+
		              '<b id="firstHeading" class="firstHeading" style="color:#000;"><u>'+koord.id_speedy+'</u></b>'+
		              '<div id="bodyContent" style="color:#000;">'+
		              'Nama: '+koord.nama_pelanggan+'</br>'+
		              'Alamat: '+koord.alamat_pelanggan+'</br>'+
		              '</div>'+
		              '</div>';

				var compiled = $compile(content)($scope);

				var info = new google.maps.InfoWindow({content:compiled[0],maxWidth:300});
				var marker = new google.maps.Marker({position:lokasi,map:map,title:koord.nama_pelanggan,icon:'assets/img/marker.png'});
				
				google.maps.event.addListener(marker,'click',function(){
					info.open(map,marker);
				});
				
			});
		}).error(function(err){
			notifications.showError({
				message: 'Sambungan Internet Terputus!',
				hideDelay: 3000, //ms
				hide: true, //bool
				autoHideAnimation:'fadeOutNotifications',
				autoHideAnimationDelay:1200
			});
		});
	}

  	//checklist
  	$ionicModal.fromTemplateUrl('src/checklist.html',function(ck){
  		$scope.ck = ck;
  	},{
  		scope:$scope,
  		animation:'slide-in-up'
  	});

  	//show checklist
  	$scope.ckshow = function(item){
  		console.log()
  		$scope.pushIdKunjungan(item.id_kunjungan);
		$scope.ck.show();
  	}
  	
  	//remove checklist
  	$scope.removeCk = function(){
		$scope.ck.remove();
		$ionicModal.fromTemplateUrl('src/checklist.html',function(ck){
			$scope.ck = ck;
		},{
			scope:$scope,
			animation:'slide-in-up'
		});
  	}

  	//kunjungan method
  	$scope.kunjungan = function(dataInput){
  		var x = setIdKunjungan;
  		if(!dataInput.ket){
			notifications.showError({
				message: 'Mohon Isikan Keterangan Kunjungan',
				hideDelay: 3000, //ms
				hide: true, //bool
				autoHideAnimation:'fadeOutNotifications',
				autoHideAnimationDelay:1200
			});
  		}else{
			$ionicLoading.show({
				content:'Loading',
				animation:'fade-in',
				showBackdrop:true,
				maxWidth:200
			});
			
			$timeout(function(){
				$ionicLoading.hide();

				Services.editKunjungan({
					id_kunjungan:setIdKunjungan,
					ket_kunjungan:dataInput.ket,
					status_kunjungan:dataInput.statusKunjungan
				}).success(function(data){
					notifications.showSuccess({
						message: 'Data Berhasil Di Update',
						hideDelay: 3000, //ms
						hide: true, //bool
						autoHideAnimation:'fadeOutNotifications',
						autoHideAnimationDelay:1200
					});
				}).error(function(err){
					notifications.showError({
						message: 'Sambungan Internet Terputus!',
						hideDelay: 3000, //ms
						hide: true, //bool
						autoHideAnimation:'fadeOutNotifications',
						autoHideAnimationDelay:1200
					});
				})
			},3000);
  		}

		$timeout(function(){
			$scope.removeCk();
			Services.getDataPelanggan({id:id_pegawai}).success(function(data){
				$scope.pelanggan = data;
				//console.log(data);
			}).error(function(err){
				notifications.showError({
					message: 'Sambungan Internet Terputus!',
					hideDelay: 3000, //ms
					hide: true, //bool
					autoHideAnimation:'fadeOutNotifications',
					autoHideAnimationDelay:1200
				});
			});
		},6000);
  	}

  	//edit data
  	$ionicModal.fromTemplateUrl('src/edit_data.html',function(pelanggan_edit){
  		$scope.pelanggan_edit = pelanggan_edit;
  	},{
  		scope:$scope,
  		animation:'slide-in-up'
  	});

  	//show pe
  	$scope.peshow = function(item){
  		Services.getDetailPelanggan({id_keluhan:item.id_keluhan}).success(function(data){
  			$scope.editData = data;
  		});
  		$scope.dataEdit = {lokasi:false,telepon_rumah:false,telepon_selular:false};
  		$scope.pushIdSpeedy(item.id_speedy);
		$scope.pelanggan_edit.show();
  	}


  	//sms telepon function
  	$scope.smstopelanggan = function(item){
  		var d = new Date();
  		var n = d.getHours();

		if(n > 1 && n <  12){
			$cordovaSocialSharing.shareViaSMS("Selamat Pagi Pak/Bu "+item.nama_pelanggan+" . . . ", item.telp_hp_pelanggan);
		}else if(n >= 12 && n<17){
			$cordovaSocialSharing.shareViaSMS("Selamat Siang Pak/Bu "+item.nama_pelanggan+" . . . ", item.telp_hp_pelanggan);
		}else{
			notifications.showWarning({
				message:'Tidak Dapat Mengirim SMS, Melebihi Jam Kerja',
				hideDelay:3000,
				hide:true,
				autoHideAnimation:'fadeOutNotifications',
				autoHideAnimationDelay:1200
			});
		}
  	}
  	
  	//remove pe
  	$scope.removepe = function(){
		$scope.pelanggan_edit.remove();
		$ionicModal.fromTemplateUrl('src/edit_data.html',function(pelanggan_edit){
			$scope.pelanggan_edit = pelanggan_edit;
		},{
			scope:$scope,
			animation:'slide-in-up'
		});
  	}

  	//input lokasi
  	$scope.inputLokasi = function(map){
		
		var options = {timeout:6000,enableHighAccuracy:true,maximumAge:6000};
		
		$ionicLoading.show({
			content:'Loading',
			animation:'fade-in',
			showBackdrop:true,
			maxWidth:200
		});

		$timeout(function(){
			$ionicLoading.hide();
			navigator.geolocation.getCurrentPosition(function(pos){
				console.log(pos);
				$scope.setLat(pos.coords.latitude);
				$scope.setLtg(pos.coords.longitude);

				var lokasi = new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude);
				
				$scope.map.setCenter(lokasi);

				Services.getAddress(pos.coords.latitude,pos.coords.longitude).success(function(data){
										console.log(data);
					$scope.setAddress(data.results[0].formatted_address);

			        var content= '<div id="content">'+'<div id="siteNotice">'+'</div>'+
			              '<b id="firstHeading" class="firstHeading" style="color:#000;"><u>Lokasi Anda Sekarang</u></b>'+
			              '<div id="bodyContent" style="color:#000;">'+
			              'Alamat: '+data.results[0].formatted_address+'</br>'+
			              '</div>'+
			              '</div>';

					var compiled = $compile(content)($scope);

					var info = new google.maps.InfoWindow({content:compiled[0],maxWidth:300});
					var marker = new google.maps.Marker({position:lokasi,map:map,title:'Lokasi Anda Sekarang',icon:'assets/img/my_location.png'});
					
					google.maps.event.addListener(marker,'click',function(){
						info.open(map,marker);
					});	
				});

			},function(err){
				if(err.code == 1){
					var err_message = 'GPS Perangkat Tidak Ditemukan';
				}else if(err.code == 2){
					var err_message = 'Posisi Tidak Ditemukan';
				}else{
					var err_message = 'Koneksi Lemah'
				}

				notifications.showError({
					message: 'Terdapat Kesalahan Dalam Menentukan Lokasi Anda, '+err_message,
					hideDelay: 3000, //ms
					hide: true, //bool
					autoHideAnimation:'fadeOutNotifications',
		        	autoHideAnimationDelay:1200
				});
			},options);
		},6000);
  	}

  	$scope.editDataPelanggan = function(dataInput){

		$ionicLoading.show({
			content:'Loading',
			animation:'fade-in',
			showBackdrop:true,
			maxWidth:200
		});

		$timeout(function(){
			$ionicLoading.hide();

			Services.getDataPelanggan({id:id_pegawai}).success(function(data){
				$scope.pelanggan = data;
				//console.log(data);
			}).error(function(err){
				notifications.showError({
					message: 'Sambungan Internet Terputus!',
					hideDelay: 3000, //ms
					hide: true, //bool
					autoHideAnimation:'fadeOutNotifications',
					autoHideAnimationDelay:1200
				});
			});
			
	  		if(!dataInput.lokasi && !dataInput.telepon_selular){
	  			notifications.showWarning({
					message:'Anda Tidak Melakukan Perubahan Data',
					hideDelay:3000,
					hide:true,
					autoHideAnimation:'fadeOutNotifications',
					autoHideAnimationDelay:1200
				});
				$scope.removepe();
	  		}else{
	  			if(dataInput.lokasi && dataInput.telepon_selular){
	  				if(dataInput.xtelepon_selular){
	  					Services.editPelanggan({id_speedy:setIdSpeedy,alamat_pelanggan:setAddressPelanggan,lat_pelanggan:setLatPelanggan,ltg_pelanggan:setLtgPelanggan,telp_hp_pelanggan:dataInput.xtelepon_selular});
			  			notifications.showSuccess({
							message: 'Data Berhasil Di Update',
							hideDelay: 3000, //ms
							hide: true, //bool
							autoHideAnimation:'fadeOutNotifications',
							autoHideAnimationDelay:1200
						});
						$scope.removepe();
	  				}else{
	  					notifications.showError({
							message: 'Isikan Telepon Selular Pelanggan!',
							hideDelay: 3000, //ms
							hide: true, //bool
							autoHideAnimation:'fadeOutNotifications',
							autoHideAnimationDelay:1200
						});
	  				}
	  			}

	  			if(dataInput.lokasi && !dataInput.telepon_selular){
	  				Services.editPelanggan({id_speedy:setIdSpeedy,alamat_pelanggan:setAddressPelanggan,lat_pelanggan:setLatPelanggan,ltg_pelanggan:setLtgPelanggan});
	  				notifications.showSuccess({
						message: 'Data Berhasil Di Update',
						hideDelay: 3000, //ms
						hide: true, //bool
						autoHideAnimation:'fadeOutNotifications',
						autoHideAnimationDelay:1200
					});
					$scope.removepe();
	  			}

	  			if(!dataInput.lokasi && dataInput.telepon_selular){
	  				if(dataInput.xtelepon_selular){
	  					Services.editPelanggan({id_speedy:setIdSpeedy,telp_hp_pelanggan:dataInput.xtelepon_selular});
						notifications.showSuccess({
							message: 'Data Berhasil Di Update',
							hideDelay: 3000, //ms
							hide: true, //bool
							autoHideAnimation:'fadeOutNotifications',
							autoHideAnimationDelay:1200
						});
						$scope.removepe();
	  				}else{
						notifications.showError({
							message: 'Isikan Telepon Selular Pelanggan!',
							hideDelay: 3000, //ms
							hide: true, //bool
							autoHideAnimation:'fadeOutNotifications',
							autoHideAnimationDelay:1200
						});
	  				}
	  			}
	  		}
		},4000)
  	}
})