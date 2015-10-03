	//google map service
	var directionsService = new google.maps.DirectionsService();
	var directionsDisplay = new google.maps.DirectionsRenderer({ suppressMarkers:true});
	var service = new google.maps.DistanceMatrixService();
	var geocoder = new google.maps.Geocoder();
	//end google map service

	//array map variable
	var markers = [];
	var verteks = [];
	var verteks_zero = [];
	//end array map variable

	//tanggal variable
	var nama_bulan = new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
	var nama_hari = new Array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
	var tgl = new Date();
	var hari = tgl.getDay();
	var date = tgl.getDate();
	var bulan = tgl.getMonth();
	var tahun = tgl.getFullYear();
	var tgl_pencarian = nama_hari[hari]+','+date+'-'+nama_bulan[bulan]+'-'+tahun;
	//end tanggal variable

	//array icon
	var icon = {travelicon: 'img/marker_travel.png',busicon: 'img/marker_bus.png',mylocation:'img/my_location.png'};
	//end array icon

	//opsi jelajah map dan lain lain
	Agen.getRuteAll().then(function(result){
		if(result.length == 0){
			for(var i=0;i<masterRute.length;i++){
				TxData.insertRuteInit(masterRute[i].tujuan);
			}
		}
	});
	Agen.getJenisAgen().then(function(result){
		if(result.length == 0){
			for(var i=0;i<masterJenis.length;i++){
				TxData.insertJenisAgen(masterJenis[i].jenis);
			}	
		}
	});
	Agen.getParameter().then(function(result){
		if(result.length == 0){
			for(var i=0;i<masterParameter.length;i++){
				TxData.insertParameter(masterParameter[i].jenis);
			}
		}
	});
	Agen.getJalur().then(function(result){
		if(result.length == 0){
			for(var i=0;i<masterJalur.length;i++){
				TxData.insertJalur(masterJalur[i].jalur);
			}	
		}
	});
	Agen.getJelajahAll().then(function(result){
		if(result.length == 0){
			for(var i=0;i<masterJelajah.length;i++){
				TxData.insertJelajah(masterJelajah[i].jelajah);
			}	
		}
	});
    //end opsi jelajah map
    
    //centerOnMe
  	$scope.centerOnMe = function() {
    	if(!$scope.map) {
      		return;
    	}

    	$scope.loading = $ionicLoading.show({
      		template: 'Mencari...',
      		showBackdrop: false
    	});
    	
    	navigator.geolocation.watchPosition(function(pos) {
      		$scope.map.setCenter(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
      		$ionicLoading.hide();
    	}, function(error) {
			$ionicPopup.alert({
	    		title: 'Peringatan',
	    		content: 'Terjadi kesalahan, gagal memuat wilayah anda: '+error.message
	    	});
	    	$ionicLoading.hide();
    	});    
  	};
  	//end center on me

  	//customizing marker directions
  	$scope.makeMarker = function(pos,icon,title){
  		new google.maps.Marker({position:pos,map:$scope.map,icon:icon,title:title});
  	};
  	//end customizing marker directions

  	//set All Map
  	$scope.setAllMap = function(map){
		for(var i = 0; i< markers.length;i++){
			markers[i].setMap(map);
		}	
  	};
  	//end set all map

  	//Init Map
  	$scope.mapCreated = function(map) {
    	$scope.map = map;
    	$scope.centerOnMe();
    	directionsDisplay.setMap($scope.map);

    	Agen.allAgen().then(function(result){
    		
			if(result.length == 0){
				for(var i=0;i<dataAgency.length;i++){
					console.log(dataAgency[i].id_agen,dataAgency[i].nama,dataAgency[i].id_jenis,dataAgency[i].lat_lokasi,dataAgency[i].long_lokasi);
					TxData.insertAgen(dataAgency[i].id_agen,dataAgency[i].nama,dataAgency[i].id_jenis,dataAgency[i].lat_lokasi,dataAgency[i].long_lokasi);
					TxData.insertProfil(dataAgency[i].id_profil,dataAgency[i].id_agen,dataAgency[i].alamat_agen,dataAgency[i].phone_agen_satu,dataAgency[i].phone_agen_dua);
				}
				for(var j=0;j<ruteAgency.length;j++){
					TxData.insertRute(ruteAgency[j].id_agen,ruteAgency[j].id_tujuan_rute,ruteAgency[j].flag_rute);
				}	
			}


        	var markerOptions = [{
					          		position:new google.maps.LatLng(koordinat.lat_lokasi, koordinat.long_lokasi),
					          		map: $scope.map,
					          		title: koordinat.nama_agen,
					          		icon: icon.busicon},{
					        		position:new google.maps.LatLng(koordinat.lat_lokasi, koordinat.long_lokasi),
						          	map: $scope.map,
						          	title: koordinat.nama_agen,
						          	icon: icon.travelicon
	          					}];

    		result.forEach(function(koordinat){
    			var markerLoad;
    			var contentAgen = '<div id="content">'+'<div id="siteNotice">'+'</div>'+
								'<b id="firstHeading" class="firstHeading"><u>'+koordinat.nama_agen+'</u></b>'+
								'<div id="bodyContent">'+
								'Jenis Agen: '+koordinat.jenis_agen+'</br>'+
								'Alamat: '+koordinat.alamat_agen+'</br>'+
								'Telepon: <b>'+koordinat.phone_agen_satu+'</b>/<b>'+koordinat.phone_agen_dua+'</b>'+
								'</div>'+
								'</div>'+
								'</div>';
				var compiled = $compile(contentAgen)($scope);
    			var infowindow = new google.maps.InfoWindow({
     					content: compiled[0],
     					maxWidth:300
  				});

		        //console.log(koordinat.jenis_agen);
	        	if(koordinat.jenis_agen == 'BUS'){
	        		markerLoad = new google.maps.Marker(markerOptions[0]);
	        	}else{
	        		markerLoad = new google.maps.Marker(markerOptions[1]);
	        	}
	        	
	        	markers.push(markerLoad);
	        	google.maps.event.addListener(markerLoad, 'click', function() {
    				infowindow.open($scope.map,markerLoad);
    			});	
    		});
  		});
  	};
  	//end init map

  	//Modal Configuration
  	$ionicModal.fromTemplateUrl('templates/cari.html',function(cariModal){
  		$scope.cariModal = cariModal;
  	},{
  		scope:$scope,
  		animation:'slide-in-up'
  	});
  	//end modal configuration
  
  	//show modal 
  	$scope.showModalCari = function(cari){
  		$scope.cari = cari;
  		$scope.jelajah = '1';
		$scope.jalur = {id_jalur:'1',jelajah_mode:'TOL'};

  		Agen.getParameter().then(function(parameter){
  			$scope.paramIdRute = parameter[0].id_param;
  			$scope.paramIdJenis = parameter[1].id_param;
  			$scope.paramIdNama = parameter[2].id_param;
  		});

		Agen.getJalur().then(function(jalur){
			$scope.Jalur = jalur;
		});

  		$scope.cariModal.show();
  	};
  	//end show modal

    //toggle button vehicle
    $scope.setJelajah = function(type) {
        $scope.jelajah = type;
    };
    $scope.isJelajah = function(type) {
        return type === $scope.jelajah;
    };
    //end toggle button vehicle

  	//remove modal
  	$scope.removeModalCari = function(){
  		$scope.cariModal.remove();

		$ionicModal.fromTemplateUrl('templates/cari.html',function(cariModal){
			$scope.cariModal = cariModal;
		},{
			scope: $scope,
			animation:'slide-in-up'
		});
  	};
  	//end remove modal
  
  	//show action sheet
 	$scope.showActionsheet = function () {
  	  	$ionicActionSheet.show({
      	titleText: 'Mode Pencarian Lokasi',
      	buttons: [
        	{
          		text: '<i></i> Lokasi Saya'
        	},{
          		text: '<i></i> Cari Berdasarkan Jenis Agen'
        	},{
       	  		text: '<i></i> Cari Berdasarkan Rute Agen'
        	},{
          		text: '<i></i> Cari Berdasarkan Nama Agen'
        	}],buttonClicked: function (index) {
	            if(index === 0){
	            	directionsDisplay.setMap(null);
	            	$scope.lokasiSaya();
	            }else if(index === 1){
	            	directionsDisplay.setMap($scope.map);
	            	Agen.getJenisAgen().then(function(jenis){
						$scope.jenis_agens = jenis;
						$scope.selectedOption = jenis[0];
					});
	            	$scope.showModalCari('jenis_agen');
	            }else if(index===2){
	            	directionsDisplay.setMap($scope.map);
	            	Agen.getRuteAll().then(function(rute){
	            		$scope.rute = rute;
	            		$scope.selectRute = rute[0];
	            	});
	            	$scope.showModalCari('rute_agen');
	            }else{
	            	directionsDisplay.setMap($scope.map);    	
				    Agen.allAgen().then(function(result){
				    	$scope.data = result;
				    	$scope.selectData = result[0];
				    });
	            	$scope.showModalCari('nama_agen');
	            }
	            return true;
	      	}
    	});
  	};
  	//end show action

    //load rute by rute
    $scope.loadRuteByRute = function(search){
    	var jRute = search.jRute.$modelValue;
    	var paramIdRute = search.paramIdRute.$modelValue;

    	$scope.hitungJarak(jRute,paramIdRute,$scope.jelajah,$scope.jalur);
		$timeout(function() {
    	$scope.removeModalCari();
    	}, 1000);
    };
    //end load rute by rute

    //load rute by jenis
    $scope.loadRuteByJenis = function(search){
    	var jAgen = search.jAgen.$modelValue;
    	var paramIdJenis = search.paramIdJenis.$modelValue;

    	$scope.hitungJarak(jAgen,paramIdJenis,$scope.jelajah,$scope.jalur);
		$state.go('menu.dashboard');
	 	$timeout(function() {
	     $scope.removeModalCari();
	    }, 1000);
    };
    //end load rute by jenis

  	//load rute by nama
    $scope.loadRuteByNama = function(search){
    	var jNama = search.jNama.$modelValue;
    	var paramIdNama = search.paramIdNama.$modelValue;
    	Agen.getByIdAgen(jNama.id_agen).then(function(result){
			$scope.navigasiNormal(result.lat_lokasi,result.long_lokasi,paramIdNama,result.nama_agen,$scope.jelajah,$scope.jalur);
		});
    	$state.go('menu.dashboard');
	 	$timeout(function() {
	     $scope.removeModalCari();
	    }, 1000);
    };
    //end load rute by nama
    

  	//lokasi saya
    $scope.lokasiSaya = function(){
		if (!$scope.map) {
			return;
		}

		$scope.loading = $ionicLoading.show({
		template: 'Mencari posisi perangkat anda...',
		showBackdrop: false
		});

		$scope.mapCreated($scope.map); 
		navigator.geolocation.getCurrentPosition(function (pos) {
			$ionicLoading.hide();
			$scope.map.setCenter(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));
			var lokasiSaya = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
				geocoder.geocode({'latLng':lokasiSaya},function(alamat){
					var contentLokasi = '<div id="content">'+
									'<div id="siteNotice">'+'</div>'+
									'<b id="firstHeading" class="firstHeading"><u>Lokasi Saya</u></b>'+
									'<div id="bodyContent">'+
									'Saya berada di '+alamat[1].formatted_address+
									'</div>'+
									'</div>';
					var infoLokasi = new google.maps.InfoWindow({
						content: contentLokasi,
						maxWidth:300
					});

					var myLocation = new google.maps.Marker({
						position: lokasiSaya,
						map: $scope.map,
						title: alamat[1].formatted_address,
						icon:icon.mylocation
					});		
					// google.maps.event.addListener(myLocation,'tap','toggleBounce');
					google.maps.event.addListener(myLocation, 'click', function() {
    					infoLokasi.open($scope.map,myLocation);
    				});	
				});
			}, function (error) {
			$ionicPopup.alert({
				title: 'Peringatan',
				content: 'Terjadi kesalahan, gagal memuat posisi anda: '+error.message
			});
			$ionicLoading.hide();
		});
    };
    //end lokasi saya
    
    //do insert Cari
	$scope.insertCari = function(lat_cari,ltg_cari,parameter,spesifik,jelajah,jalur){
		TxData.getIdSpesifik().then(function(id_spesifikasi){
			TxData.getIdOpsiMap().then(function(id_opsi_map){
				TxData.getIdLokasiPerangkat().then(function(id_lokasi_perangkat){
					TxData.insertPencarian(id_opsi_map,tgl_pencarian);
					TxData.insertSpesifikasi(id_spesifikasi,parameter,spesifik);
					TxData.insertLokasiPerangkat(id_lokasi_perangkat,lat_cari,ltg_cari);
					TxData.insertOpsiMap(id_opsi_map,id_spesifikasi,id_lokasi_perangkat,jelajah,jalur);
				});
			});
		});	
	};
	//end do insert cari

   //function hitung jarak
    $scope.hitungJarak = function(spesifik,parameter,arg_jelajah,arg_jalur){
    	navigator.geolocation.getCurrentPosition(function(pos){
    		var posisiSaya = new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude);
    		Agen.getJelajahById(arg_jelajah).then(function(jelajah){
    			if(parameter == '1'){
		    		Agen.getAgenByRute(spesifik.id_tujuan_rute).then(function(results){
		    			if(results.length != 0){
				    		for(var i = 0;i<results.length;i++){
				    			verteks.push(results[i].lat_lokasi+','+results[i].long_lokasi+','+results[i].nama_agen);
				    		}
				    		console.log(verteks);
				    		// var ngasal = [];
				    		// for(var j=0;j<verteks.length;j++){
				    		// 	var x = verteks[j].split(',');
				    		// 	ngasal.push(new google.maps.LatLng(x[0],x[1]));
				    		// }
				    		// console.log(ngasal[0]);
				    		if(jelajah.id_jelajah == '1'){
								service.getDistanceMatrix({
									origins:[posisiSaya],
									destinations:verteks,
									travelMode:google.maps.TravelMode[jelajah.mode_jelajah],
									unitSystem:google.maps.UnitSystem.METRIC
								}, $scope.dijkstra);
								$scope.insertCari(pos.coords.latitude,pos.coords.longitude,parameter,spesifik.tujuan_rute,jelajah.id_jelajah,'3');
								verteks_zero.push({lat:pos.coords.latitude,ltg:pos.coords.longitude,jelajah:jelajah.mode_jelajah,jalur:'3'});
				    		}else{
				    			$scope.insertCari(pos.coords.latitude,pos.coords.longitude,parameter,spesifik.tujuan_rute,jelajah.id_jelajah,arg_jalur.id_jalur);
				    			verteks_zero.push({lat:pos.coords.latitude,ltg:pos.coords.longitude,jelajah:jelajah.mode_jelajah,jalur:arg_jalur.id_jalur});
					    		if(arg_jalur.id_jalur == '1'){
									service.getDistanceMatrix({
										origins:[posisiSaya],
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidTolls: true
									}, $scope.dijkstra);
								}else{
									service.getDistanceMatrix({
										origins:[posisiSaya],
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidHighways: true
									}, $scope.dijkstra);
								}
				    		}
		    			}else{
		    				$ionicPopup.alert({
								title: 'Peringatan',
								content: 'Tidak Terdapat Hasil Pencarian Dengan Paramter Yang Dimaksud'
							});
							$ionicLoading.hide();
		    			}
		    		});	
	    		}else{	
	    			Agen.getAgenByJenis(spesifik.id_jenis).then(function(results){
	    				if(results.length != 0){
				    		for(var i = 0;i<results.length;i++){
				    			verteks.push(results[i].lat_lokasi+','+results[i].long_lokasi);
				    		}
				    		if(jelajah.id_jelajah == '1'){
				    			service.getDistanceMatrix({
									origins:[posisiSaya],
									destinations:verteks,
									travelMode:google.maps.TravelMode[jelajah.mode_jelajah],
									unitSystem:google.maps.UnitSystem.METRIC
								}, $scope.dijkstra);
								$scope.insertCari(pos.coords.latitude,pos.coords.longitude,parameter,spesifik.jenis_agen,jelajah.id_jelajah,'3');
								verteks_zero.push({lat:pos.coords.latitude,ltg:pos.coords.longitude,jelajah:jelajah.mode_jelajah,jalur:'3'});
				    		}else{
				    			$scope.insertCari(pos.coords.latitude,pos.coords.longitude,parameter,spesifik.jenis_agen,jelajah,arg_jalur.id_jalur);	
								verteks_zero.push({lat:pos.coords.latitude,ltg:pos.coords.longitude,jelajah:jelajah.mode_jelajah,jalur:arg_jalur.id_jalur});
								if(arg_jalur.id_jalur == '1'){
									service.getDistanceMatrix({
										origins:[posisiSaya],
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidTolls: true
									}, $scope.dijkstra);
								}else{
									service.getDistanceMatrix({
										origins:[posisiSaya],
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidHighways: true
									}, $scope.dijkstra);
								}

				    		}

	    				}else{
	    					$ionicPopup.alert({
								title: 'Peringatan',
								content: 'Tidak Terdapat Hasil Pencarian Dengan Paramter Yang Dimaksud'
							});
							$ionicLoading.hide();
	    				}
		    		});	
	    		}
	    	});
    	},function(error){
    		$ionicPopup.alert({
				title: 'Peringatan',
				content: 'Terjadi kesalahan, gagal memuat lokasi: '+error.message
			});
			$ionicLoading.hide();
    	});  	
    };
    //end hitung jarak

    //dijkstra function
    $scope.dijkstra = function(response){
		var routes = response.rows[0];
		var pathResult =[];
		var hasil =[];
		for(var i = 0;i<routes.elements.length;i++){
			var rteLength = routes.elements[i].distance.value;
			console.log(routes.elements[i].distance);
			pathResult.push({path:verteks[i],pathLength:rteLength});
		}

		for(var i=0;i<pathResult.length;i++){
			var newPathLength = pathResult[i].pathLength;
			var newPath = pathResult[i].path;
			if(hasil.length == 0){
				var oldPathLength = pathResult[0].pathLength;
				//console.log(oldPathLength+'>'+newPathLength);
				if(oldPathLength>newPathLength){
					hasil.push({path:newPath,pathLength:newPathLength});
				}else{
					hasil.push({path:pathResult[0].path,pathLength:pathResult[0].pathLength});
				}
			}else{
				var oldPathLength = hasil[0].pathLength;
				//console.log(oldPathLength+'>'+newPathLength);
				if(oldPathLength>newPathLength){
					//console.log(oldPathLength+'>'+newPathLength);
					hasil.splice(0,hasil.length);
					hasil.push({path:newPath,pathLength:newPathLength});
				}
			}
		}
		//console.log(verteks_zero[0],verteks_zero[1]);
		var start = new google.maps.LatLng(verteks_zero[0].lat,verteks_zero[0].ltg);
		var end = hasil[0].path;
		navigasiDijkstra(start,end,verteks_zero[0].jelajah,verteks_zero[0].jalur);
    };
    //end directions dijkstra

    //Show Navigation on map
	function navigasiDijkstra(start, end,jelajah,jalur) {
	    if(jalur == '1'){
			var request = {
		        origin: start,
		        destination: end,
		        optimizeWaypoints: true,
		        travelMode: google.maps.TravelMode[jelajah],
		        avoidTolls:true
		    };
		}else if(jalur == '2'){
			var request = {
		        origin: start,
		        destination: end,
		        optimizeWaypoints: true,
		        travelMode: google.maps.TravelMode[jelajah],
		        avoidHighways:true
		    };
		}else{
			var request = {
		        origin: start,
		        destination: end,
		        optimizeWaypoints: true,
		        travelMode: google.maps.TravelMode[jelajah]
		    };
		}

	    directionsService.route(request, function (result, status) {
	        if (status == google.maps.DirectionsStatus.OK) {
	            directionsDisplay.setDirections(result);
	            var leg = result.routes[ 0 ].legs[ 0 ];
  				var leg_start = $scope.makeMarker( leg.start_location, new google.maps.MarkerImage(icon.mylocation), "Mulai" );
	            //$scope.setAllMap(null);
	        }
	    });
	    verteks.splice(0,verteks.length);
	    verteks_zero.splice(0,verteks_zero.length);
	};
	//end show navigations

	//show navigations map normal
	$scope.navigasiNormal = function(lat,ltg,parameter,spesifik,arg_jelajah,arg_jalur){
    	navigator.geolocation.getCurrentPosition(function(pos){
    		var posisiSaya = new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude);
    		var posisiTujuan = new google.maps.LatLng(lat,ltg);
    		Agen.getJelajahById(arg_jelajah).then(function(jelajah){
    			if(jelajah.id_jelajah == '1'){
	    			var dataRute = {
	    			origin: posisiSaya,
	    			destination: posisiTujuan,
	    			travelMode:google.maps.TravelMode[jelajah.mode_jelajah],
	    			provideRouteAlternatives:true
	    			};
	    			$scope.insertCari(pos.coords.latitude,pos.coords.longitude,parameter,spesifik,jelajah.id_jelajah,'3');
	    		}else{   			
		    		if(arg_jalur.id_jalur == '1'){
		    			var dataRute = {
			    			origin: posisiSaya,
			    			destination: posisiTujuan,
			    			travelMode:google.maps.TravelMode[jelajah.mode_jelajah],
			      			avoidTolls: true,
			      			provideRouteAlternatives:true
		    			};
		    		}else{
		    			var dataRute = {
			    			origin: posisiSaya,
			    			destination: posisiTujuan,
			    			travelMode:google.maps.TravelMode[jelajah.mode_jelajah],
			    			avoidHighways: true,
			    			provideRouteAlternatives:true
		    			};
		    		}
		    		$scope.insertCari(pos.coords.latitude,pos.coords.longitude,parameter,spesifik,jelajah.id_jelajah,arg_jalur.id_jalur); 
	    		}
    	
		    		directionsService.route(dataRute, function(result, status) {
					    if (status == google.maps.DirectionsStatus.OK) {
						      //  for(var i=0;i<result.routes.length;i++){
								    // new google.maps.DirectionsRenderer({
					       				//map: $scope.map,
					       				//directions: result,
					       				//routeIndex: i,
					       				//suppressMarkers:true
					       			//});
						      // }
						      // var leg = result.routes[ 0 ].legs[ 0 ];
			  				  // $scope.makeMarker( leg.start_location, icon.start, "Mulai" );

					        directionsDisplay.setDirections(result);
					        var leg = result.routes[ 0 ].legs[ 0 ];
		  				    var leg_start = $scope.makeMarker( leg.start_location, new google.maps.MarkerImage(icon.mylocation), "Mulai" );
						    //$scope.setAllMap(null);
					    }
					});
		    });
    	},function(error){
    		$ionicPopup.alert({
		      title: 'Peringatan',
		      content: 'Terjadi kesalahan, gagal memuat navigasi: '+error.message
		    });
		    $ionicLoading.hide();
    	});
    };
    //end show navigations normal