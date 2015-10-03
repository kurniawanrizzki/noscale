angular.module('telkomakses.services',['ngCookies'])

.factory('Services',function($http,$cookieStore){
	var sendData;
	var _user = $cookieStore.get('starter.user');
	var setUser = function(user){
		_user = user;
		$cookieStore.put('starter.user',_user);
	}

	return {
		getPelangganMarker:function(id_pegawai){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=Semua_Lokasi",id_pegawai,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		getDataPelanggan:function(id_pegawai){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=Pelanggan",id_pegawai,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'		
				},
				timeout:6000
			});
		},
		getDetailPelanggan:function(id_keluhan){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=Detail_Pelanggan",id_keluhan,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		getPelangganMarkerById:function(id_speedy){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=Lokasi_Pelanggan_By_Id",id_speedy,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		editPelanggan:function(dataEdit){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=Edit_Data_Pelanggan",dataEdit,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		editKunjungan:function(dataCheck){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=Checklist",dataCheck,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		editPegawai:function(dataEdit){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=Edit_Data_Pegawai",dataEdit,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		loginTeknisi:function(dataLogin){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=Login",dataLogin,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		loginTimeTeknisi:function(login){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=LoginTime",login,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		getMsanDp:function(id){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=getMsanDPOption",id,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		getMsanDpList:function(){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=getMsanDpList",{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		getAddress:function(lat,ltg){
			return $http.post("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBQyCepk4cuKxv0XmQ3Msb4QGwFyzKSocQ&latlng="+lat+","+ltg+"&sensor=true");	
		},
		getDataPegawai:function(id){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=getDataPegawai",id,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		logoutTime:function(id){
			return $http.post("http://students.ce.undip.ac.id/Telkom_akses_mobile/www/inc/action.php?Action=Logout",id,{
				headers:{
					'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8;'
				},
				timeout:10000
			});
		},
		setUser:setUser,
		isLoggedIn:function(){
			return _user?true:false;
		},
		getUser:function(){
			return _user;
		},
		logout:function(){
			$cookieStore.remove('starter.user');
			_user = null;
		}
	}
})