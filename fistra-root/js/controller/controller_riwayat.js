angular.module('RiwayatController',['ShowServices','TxServices'])

// controller riwayat
.controller('riwayatCtrl',function($scope,$timeout,$ionicModal,$ionicPopup,$ionicLoading,$compile,Agen,TxData){
	var service = new google.maps.DistanceMatrixService();
	var directionsService = new google.maps.DirectionsService();
 	var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers:true});
 	var geocoder = new google.maps.Geocoder();
 	$scope.pencarian = [];
 	var verteks =[];
 	var markers = [];
 	var posisiPencarianTr=[];
 	var initPath=[];
 	var legStartMarkers = [];
	var icon = {travelicon: 'img/marker_travel.png',busicon: 'img/marker_bus.png',mylocation:'img/my_location.png'};
	
 	//Init Map
  	$scope.mapCreated = function(map) {
    	$scope.map = map;
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

	        	var markerOptions = [{
	          		position:new google.maps.LatLng(koordinat.lat_lokasi, koordinat.long_lokasi),
	          		map: $scope.map,
	          		title: koordinat.nama_agen,
	          		icon: icon.busicon},{
	        		position:new google.maps.LatLng(koordinat.lat_lokasi, koordinat.long_lokasi),
		          	map: $scope.map,
		          	title: koordinat.nama_agen,
		          	icon: icon.travelicon}];
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

  	//Configuration modal
	$ionicModal.fromTemplateUrl('templates/map.html',function(mapView){
		$scope.mapView = mapView;
	},{
		scope: $scope,
		animation:'slide-in-up'
	});
	//end configuration map

	//show modal map
	$scope.showMap = function(item){
		Agen.getPencarianById(item.id_pencarian).then(function(result){
			$scope.clearlegStart();
			verteks.splice(0,verteks.length);
	    	posisiPencarianTr.splice(0,posisiPencarianTr.length);
	    	initPath.splice(0,initPath.length);
			if(result.jenis_parameter == 'Rute Agen' || result.jenis_parameter == 'Nama Agen'){
				
				$scope.hitungJarak(result.lat_pencarian,result.long_pencarian,result.id_param,result.jenis_spesifikasi,result.id_jelajah,result.id_jalur);
			}else{
				$scope.hitungJarak2(result.lat_pencarian,result.long_pencarian,result.id_param,result.jenis_spesifikasi,result.id_jelajah,result.id_jalur);			
			}
		});
		$scope.mapView.show();
	};
	//end show modal

	//remove  modal 
	$scope.exitMap = function(){
		$scope.mapView.remove();

		$ionicModal.fromTemplateUrl('templates/map.html',function(mapView){
			$scope.mapView = mapView;
		},{
			scope: $scope,
			animation:'slide-in-up'
		});
	};
	//end remove modal

	//hitung jarak
	$scope.hitungJarak = function(lat,ltg,parameter,spesifik_pencarian,jelajah,jalur){
		
		$ionicLoading.show({
		    content: 'Loading',
		    animation: 'fade-in',
		    showBackdrop: true,
		    maxWidth: 200
	  	});

		Agen.getJelajahById(jelajah).then(function(jelajah_result){
			
			if(parameter == 1){
				
	    		Agen.getAgenByRuteNama(spesifik_pencarian).then(function(results){
	    			posisiPencarianTr.push(lat,ltg,jelajah_result.mode_jelajah,jalur);
	    			if(results.length != 0){
	    				if(results.length>8){
	    					var posisiPencarian = new google.maps.LatLng(lat,ltg);
			    			
			    			//console.log(results);
				    		for(var i = 0;i<results.length;i++){
				    			verteks.push(results[i].lat_lokasi+','+results[i].long_lokasi);
				    		}
						    if(jelajah_result.id_jelajah == 1){			
								service.getDistanceMatrix({
									origins:[posisiPencarian],
									destinations:verteks,
									travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
									unitSystem:google.maps.UnitSystem.METRIC
								}, $scope.dijkstra,$scope.errorDijkstra);
				    		}else{
					    		if(jalur == 1){
								service.getDistanceMatrix({
										origins:[posisiPencarian],
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidTolls: true
									}, $scope.dijkstra,$scope.errorDijkstra);
								}else{
									service.getDistanceMatrix({
										origins:[posisiPencarian],
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidHighways: true
									}, $scope.dijkstra,$scope.errorDijkstra);
								}
				    		}
	    				}else{

	    					verteks.push(lat+','+ltg);
	    					initPath.push(new google.maps.LatLng(lat,ltg));
		    				for(var i = 0;i<results.length;i++){
				    			verteks.push(results[i].lat_lokasi+','+results[i].long_lokasi);
				    			initPath.push(new google.maps.LatLng(results[i].lat_lokasi,results[i].long_lokasi));
					    	}
					    	if(jelajah_result.id_jelajah == 1){			
								service.getDistanceMatrix({
									origins:initPath,
									destinations:verteks,
									travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
									unitSystem:google.maps.UnitSystem.METRIC
								}, $scope.dijkstra,$scope.errorDijkstra);
				    		}else{
					    		if(jalur == 1){
								service.getDistanceMatrix({
										origins:initPath,
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidTolls: true
									}, $scope.dijkstra,$scope.errorDijkstra);
								}else{
									service.getDistanceMatrix({
										origins:initPath,
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidHighways: true
									}, $scope.dijkstra,$scope.errorDijkstra);
								}
				    		}
	    				}
	    				$timeout(function() {
						 	$ionicLoading.hide();
						}, 6000);
	    			}else{
			    		$ionicLoading.show({
						    content: 'Loading',
						    animation: 'fade-in',
						    showBackdrop: true,
						    maxWidth: 200
					  	});
					 	$timeout(function() {
					 	 	$ionicLoading.hide();
					 	 	$ionicPopup.alert({
								title: 'Peringatan',
								content: "<div align='center'>Tidak Ada Hasil Dari Parameter Rute Agen</div>",
								buttons:[{
									text:"OK",type:'button-dark',onTap:function(e){
										return
									}
								}]
							});
					    }, 3000);
	    			}
	    		});	
			}else if(parameter == 3){

    			Agen.getAgenByNama(spesifik_pencarian).then(function(results){
	    			posisiPencarianTr.push(lat,ltg,jelajah_result.mode_jelajah,jalur);
	    			if(results.length != 0){
	    				if(results.length>8){
	    					var posisiPencarian = new google.maps.LatLng(lat,ltg);
			    			
			    			//console.log(results);
				    		for(var i = 0;i<results.length;i++){
				    			verteks.push(results[i].lat_lokasi+','+results[i].long_lokasi);
				    		}
						    if(jelajah_result.id_jelajah == 1){			
								service.getDistanceMatrix({
									origins:[posisiPencarian],
									destinations:verteks,
									travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
									unitSystem:google.maps.UnitSystem.METRIC
								}, $scope.dijkstra,$scope.errorDijkstra);
				    		}else{
					    		if(jalur == 1){
								service.getDistanceMatrix({
										origins:[posisiPencarian],
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidTolls: true
									}, $scope.dijkstra,$scope.errorDijkstra);
								}else{
									service.getDistanceMatrix({
										origins:[posisiPencarian],
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidHighways: true
									}, $scope.dijkstra,$scope.errorDijkstra);
								}
				    		}
	    				}else{

	    					verteks.push(lat+','+ltg);
	    					initPath.push(new google.maps.LatLng(lat,ltg));
		    				for(var i = 0;i<results.length;i++){
				    			verteks.push(results[i].lat_lokasi+','+results[i].long_lokasi);
				    			initPath.push(new google.maps.LatLng(results[i].lat_lokasi,results[i].long_lokasi));
					    	}
					    	if(jelajah_result.id_jelajah == 1){			
								service.getDistanceMatrix({
									origins:initPath,
									destinations:verteks,
									travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
									unitSystem:google.maps.UnitSystem.METRIC
								}, $scope.dijkstra,$scope.errorDijkstra);
				    		}else{
					    		if(jalur == 1){
								service.getDistanceMatrix({
										origins:initPath,
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidTolls: true
									}, $scope.dijkstra,$scope.errorDijkstra);
								}else{
									service.getDistanceMatrix({
										origins:initPath,
										destinations:verteks,
										travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
										unitSystem:google.maps.UnitSystem.METRIC,
										avoidHighways: true
									}, $scope.dijkstra,$scope.errorDijkstra);
								}
				    		}
	    				}
	    				$timeout(function() {
						 	$ionicLoading.hide();
						}, 6000);
	    			}else{
			    		$ionicLoading.show({
						    content: 'Loading',
						    animation: 'fade-in',
						    showBackdrop: true,
						    maxWidth: 200
					  	});
					 	$timeout(function() {
					 	 	$ionicLoading.hide();
					 	 	$ionicPopup.alert({
								title: 'Peringatan',
								content: "<div align='center'>Tidak Ada Hasil Dari Parameter Nama Agen</div>",
								buttons:[{
									text:"OK",type:'button-dark',onTap:function(e){
										return
									}
								}]
							});
					    }, 3000);
	    			}
	    			
		    		
	    		});	
			}
		});

	};
	//end hitung jarak
	
	//hitung jarak 2
	$scope.hitungJarak2 = function(lat,ltg,parameter,spesifik_pencarian,jelajah,jalur){
		$ionicLoading.show({
		    content: 'Loading',
		    animation: 'fade-in',
		    showBackdrop: true,
		    maxWidth: 200
	  	});

		var spesifikResult = spesifik_pencarian.split(" ");

		Agen.getJelajahById(jelajah).then(function(jelajah_result){
			
    		Agen.getAgenByNamaJenis(spesifikResult[0],spesifikResult[2]).then(function(results){
    			posisiPencarianTr.push(lat,ltg,jelajah_result.mode_jelajah,jalur);
    			if(results.length != 0){
    				if(results.length>8){
    					var posisiPencarian = new google.maps.LatLng(lat,ltg);
		    			
		    			//console.log(results);
			    		for(var i = 0;i<results.length;i++){
			    			verteks.push(results[i].lat_lokasi+','+results[i].long_lokasi);
			    		}
					    if(jelajah_result.id_jelajah == 1){			
							service.getDistanceMatrix({
								origins:[posisiPencarian],
								destinations:verteks,
								travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
								unitSystem:google.maps.UnitSystem.METRIC
							}, $scope.dijkstra,$scope.errorDijkstra);
			    		}else{
				    		if(jalur == 1){
							service.getDistanceMatrix({
									origins:[posisiPencarian],
									destinations:verteks,
									travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
									unitSystem:google.maps.UnitSystem.METRIC,
									avoidTolls: true
								}, $scope.dijkstra,$scope.errorDijkstra);
							}else{
								service.getDistanceMatrix({
									origins:[posisiPencarian],
									destinations:verteks,
									travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
									unitSystem:google.maps.UnitSystem.METRIC,
									avoidHighways: true
								}, $scope.dijkstra,$scope.errorDijkstra);
							}
			    		}
    				}else{

    					verteks.push(lat+','+ltg);
    					initPath.push(new google.maps.LatLng(lat,ltg));
	    				for(var i = 0;i<results.length;i++){
			    			verteks.push(results[i].lat_lokasi+','+results[i].long_lokasi);
			    			initPath.push(new google.maps.LatLng(results[i].lat_lokasi,results[i].long_lokasi));
				    	}
				    	if(jelajah_result.id_jelajah == 1){			
							service.getDistanceMatrix({
								origins:initPath,
								destinations:verteks,
								travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
								unitSystem:google.maps.UnitSystem.METRIC
							}, $scope.dijkstra,$scope.errorDijkstra);
			    		}else{
				    		if(jalur == 1){
							service.getDistanceMatrix({
									origins:initPath,
									destinations:verteks,
									travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
									unitSystem:google.maps.UnitSystem.METRIC,
									avoidTolls: true
								}, $scope.dijkstra,$scope.errorDijkstra);
							}else{
								service.getDistanceMatrix({
									origins:initPath,
									destinations:verteks,
									travelMode:google.maps.TravelMode[jelajah_result.mode_jelajah],
									unitSystem:google.maps.UnitSystem.METRIC,
									avoidHighways: true
								}, $scope.dijkstra,$scope.errorDijkstra);
							}
			    		}
    				}
    				$timeout(function() {
					 	$ionicLoading.hide();
					}, 6000);
    			}else{
		    		$ionicLoading.show({
					    content: 'Loading',
					    animation: 'fade-in',
					    showBackdrop: true,
					    maxWidth: 200
				  	});
				 	$timeout(function() {
				 	 	$ionicLoading.hide();
				 	 	$ionicPopup.alert({
							title: 'Peringatan',
							content: "<div align='center'>Tidak Ada Hasil Dari Parameter Jenis dan Rute Agen</div>",
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
	};
	//end hitunh jarak 2

	//dijkstra
	$scope.dijkstra = function(response,status){
		if(status == google.maps.DistanceMatrixStatus.OK){
			if(response.originAddresses.length > 1){
				var routes = response.rows;
				var origins = response.originAddresses;
				var destinations = response.destinationAddresses;
				var pathResult = [];
				var hasil =[];

				for(var i=0;i<origins.length;i++){
					var hasilX = response.rows[i].elements;

					for(var j=0;j<origins.length;j++){
						//console.log('Jarak antara '+origins[i]+' dan '+destinations[j]+' adalah '+hasil[j].distance.text);
						
						pathResult.push({identitas:i+','+j,pathAwal:verteks[i],pathAgenTujuan:verteks[j],pathLength:hasilX[j].distance.value});

					}
				}
				console.log(pathResult);

				for(var i=1;i<destinations.length;i++){
					var newPathLength = pathResult[i].pathLength;
					var newPath = pathResult[i].pathAgenTujuan;
					//console.log(newPath);
					if(hasil.length == 0){
						var oldPathLength = pathResult[1].pathLength;

						if(oldPathLength>newPathLength ){
							hasil.push({path:newPath,pathLength:newPathLength});

						}else{

							hasil.push({path:pathResult[1].pathAgenTujuan,pathLength:pathResult[1].pathLength});
						}
					}else{
						var oldPathLength = hasil[0].pathLength;
					
						if(oldPathLength>newPathLength){

							hasil.splice(0,hasil.length);
							hasil.push({path:newPath,pathLength:newPathLength});

						}
					}
				}
				
				console.log(hasil);
				var start = new google.maps.LatLng(posisiPencarianTr[0],posisiPencarianTr[1]);
				var end = hasil[0].path;
				navigasiDijkstra(start,end,posisiPencarianTr[2],posisiPencarianTr[3]);
			}else{
				var routes = response.rows[0];
				var pathResult =[];
				var hasil =[];
				console.log(response);
				for(var i = 0;i<routes.elements.length;i++){
					var rteLength = routes.elements[i].duration.value;
					pathResult.push({path:verteks[i],pathLength:rteLength});
				}
				
				for(var i=0;i<pathResult.length;i++){
					var newPathLength = pathResult[i].pathLength;
					var newPath = pathResult[i].path;
					if(hasil.length == 0){
						var oldPathLength = pathResult[0].pathLength;
						if(oldPathLength>newPathLength){
							hasil.push({path:newPath,pathLength:newPathLength});
						}else{
							hasil.push({path:pathResult[0].path,pathLength:pathResult[0].pathLength});
						}
					}else{
						var oldPathLength = hasil[0].pathLength;
						if(oldPathLength>newPathLength){
							hasil.splice(0,hasil.length);
							hasil.push({path:newPath,pathLength:newPathLength});
						}
					}
				}
			
				var start = new google.maps.LatLng(posisiPencarianTr[0],posisiPencarianTr[1]);
				var end = hasil[0].path;
				navigasiDijkstra(start,end,posisiPencarianTr[2],posisiPencarianTr[3]);
			}
		}
    };
    //end dijkstra

    //Show Navigation on map
	function navigasiDijkstra(start, end,jelajah,jalur) {

	     if(jalur == 1){
			var request = {
		        origin: start,
		        destination: end,
		        optimizeWaypoints: true,
		        travelMode: google.maps.TravelMode[jelajah],
		        avoidTolls:true
		    };
		}else if(jalur == 2){
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

		geocoder.geocode({'latLng':start},function(alamat){
		    directionsService.route(request, function (result, status) {
		        if (status == google.maps.DirectionsStatus.OK) {
		            directionsDisplay.setDirections(result);
		            
		           	var leg = result.routes[ 0 ].legs[ 0 ];
		           	console.log(leg);
		           	console.log(alamat);
	            	leg_start = $scope.makeMarker( leg.start_location, new google.maps.MarkerImage(icon.mylocation), "Mulai",alamat[0].formatted_address );
					
		            //$scope.setAllMap(null);
		        }
		    },function(error){
			    $ionicLoading.show({
				    content: 'Loading',
				    animation: 'fade-in',
				    showBackdrop: true,
				    maxWidth: 200
			  	});
			 	$timeout(function() {
			 	 	$ionicLoading.hide();
			 	 	$ionicPopup.alert({
						title: 'Peringatan',
						content: "<div align='center'>Gagal Melakukan Memuat Navigasi Ke Tujuan, Karena : "+error+"</div>",
						buttons:[{
							text:"OK",type:'button-dark',onTap:function(e){
								return
							}
						}]
					});
			    }, 3000);
		    });
	    });
	};
	//end show navigations
	
	//errorDijkstra
    $scope.errorDijkstra = function(error){
		$ionicLoading.show({
		    content: 'Loading',
		    animation: 'fade-in',
		    showBackdrop: true,
		    maxWidth: 200
	  	});
	 	$timeout(function() {
	 		$scope.exitMap();
	 	 	$ionicLoading.hide();
	 	 	$ionicPopup.alert({
				title: 'Peringatan',
				content: "<div align='center'>Gagal Memuat Jarak Terdekat, Karena : "+error+"</div>",
				buttons:[{
					text:"OK",type:'button-dark',onTap:function(e){
						return
					}
				}]
			});
		 }, 3000);
    };
    //end Error Dijkstra

	//customizing marker directions
	$scope.makeMarker = function(pos,icon,title,alamat){
		
		var contentLokasi = '<div id="content">'+
							'<div id="siteNotice">'+'</div>'+
							'<b id="firstHeading" class="firstHeading"><u>Lokasi Saya</u></b>'+
							'<div id="bodyContent">'+
							'Saya berada di '+alamat+
							'</div>'+
							'</div>';

		var infoLokasi = new google.maps.InfoWindow({
			content: contentLokasi,
			maxWidth:300
		});

		var legStart = new google.maps.Marker({position:pos,map:$scope.map,icon:icon,title:title});
		legStartMarkers.push(legStart);

		google.maps.event.addListener(legStart, 'click', function() {
			infoLokasi.open($scope.map,legStart);
		});
	  		
  	};
  	//end customizing

  	//set Leg  marker
  	$scope.setLegStart = function(map){
  		for(var i = 0;i<legStartMarkers.length;i++){
  			legStartMarkers[i].setMap(map);
  		}	
  	};
  	//end leg marker

  	//clear leg marker
  	$scope.clearlegStart = function(){
  		$scope.setLegStart(null);
  		legStartMarkers = [];
  	};
  	//end clear marker

  	//load agen pencarian
	Agen.getPencarian().then(function(result){
		$scope.pencarian = result;
		//console.log(result);
	});
	//end load agen pencarian

	//ion refresher
	$scope.refreshRiwayat = function(){
		$timeout(function(){
			Agen.getPencarian().then(function(result){
			$scope.pencarian = result;
			});
			$scope.$broadcast('scroll.refreshComplete');
		},1000)	
	};
	//end ion refresher

	//hapus  riwayat
	$scope.hapusRiwayat = function(history){
		var confirmPopup = $ionicPopup.confirm({
  			title:'Peringatan',
  			template:"<div align='center'>Apakah Anda Yakin Akan Riwayat Ini?</div>",
  			buttons:[
  			{
  				text:'Tidak',onTap:function(e){
  					console.log('Tidak Terjadi Hapus Riwayat')
  				}	
  			},
  			{
  				text:'<b>Ya</b>',type:'button-dark',onTap:function(e){
  					if(e){
  						TxData.removePencarianById(history.id_pencarian);
						TxData.removeSpesifikasiById(history.id_spesifikasi);
						TxData.removeOpsiMapById(history.id_opsi_map);
						TxData.removeLokasiPerangkatId(history.id_lokasi_perangkat);
						Agen.getPencarian().then(function(result){
							$scope.pencarian = result;
						});
  					}
  				}
  			}]
		});
		
	};
	//end hapus riwayat

});