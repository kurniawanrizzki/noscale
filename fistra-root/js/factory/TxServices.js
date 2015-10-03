angular.module('TxServices',[])

.factory('TxData',function(DB){
	var self = this;

	//membuat id agen
	self.getIdAgen = function(){
	  	return DB.query("SELECT id_agen FROM tb_agen ORDER BY id_agen DESC").then(function(result){
	  		var idAgen = null;
	  		var quotData = result.rows.length;
			
	  		if(quotData == 0){
	  			idAgen = 'AGN001';
	  		}else if(quotData < 9){
	  			var LastId = parseInt(result.rows.item(0).id_agen.substring(3,6),10);
	  			idAgen = 'AGN00'+(LastId+1);
	  		}else if(quotData>=9 && quotData<99){
	  			var LastId = parseInt(result.rows.item(0).id_agen.substring(3,6),10);
	  			idAgen = 'AGN0'+(LastId+1);
	  		}else if(quotData>=99 && quotData<1000){
	  			var LastId = parseInt(result.rows.item(0).id_agen.substring(3,6),10);
	  			idAgen = 'AGN'+(LastId+1);
	  		}else{
	  			console.log('DATABASE HAS BEEN FULL');
	  		}
	  		console.log(LastId);
	  		return idAgen;
	  	},function(error){
	  		console.log("TERJADI ERROR DI getIdAgen()--> "+error);
	  	});
	  };

	  //membuat id profil
	  self.getIdProfil = function(){
	  	return DB.query("SELECT id_profil FROM tb_profil ORDER BY id_profil DESC").then(function(result){
	  		var idProfil = null;
	  		var quotData = result.rows.length;
	
	  		if(quotData == 0){
	  			idProfil = 'PRO001';
	  		}else if(quotData < 9){
	  			var LastIdProfil = parseInt(result.rows.item(0).id_profil.substring(3,6),10);
	  			idProfil = 'PRO00'+(LastIdProfil+1);
	  		}else if(quotData>=9 && quotData<99){
	  			var LastIdProfil = parseInt(result.rows.item(0).id_profil.substring(3,6),10);
	  			idProfil = 'PRO0'+(LastIdProfil+1);
	  		}else if(quotData>=99 && quotData<1000){
	  			var LastIdProfil = parseInt(result.rows.item(0).id_profil.substring(3,6),10);
	  			idProfil = 'PRO'+(LastIdProfil+1);
	  		}else{
	  			console.log('DATABASE HAS BEEN FULL');
	  		}
	  		return idProfil;
	  	},function(error){
	  		console.log("TERJADI ERROR DI getIdProfil()--> "+error);
	  	});
	  };

	  //membuat id lokasi perangkat
	  self.getIdLokasiPerangkat = function(){
	  	return DB.query("SELECT id_lokasi_perangkat FROM tb_lokasi_perangkat ORDER BY id_lokasi_perangkat DESC").then(function(result){
	  		var idCari = null;
	  		var quotData = result.rows.length;

	  		if(quotData == 0){
	  			idCari = 'CAR001';
	  		}else if(quotData < 9){
	  			var LastIdCari = parseInt(result.rows.item(0).id_lokasi_perangkat.substring(3,6),10);
	  			idCari = 'CAR00' + (LastIdCari+1);
	  		}else if(quotData>=9 && quotData<99){
	  			var LastIdCari = parseInt(result.rows.item(0).id_lokasi_perangkat.substring(3,6),10);
	  			idCari = 'CAR0' + (LastIdCari+1);
	  		}else if(quotData>=99 && quotData<1000){
	  			var LastIdCari = parseInt(result.rows.item(0).id_lokasi_perangkat.substring(3,6),10);
	  			idCari = 'CAR' + (LastIdCari+1);
	  		}else{
	  			console.log('DATABASE HAS BEEN FULL');
	  		}
	  		return idCari;
	  	},function(error){
	  		console.log("TERJADI ERROR DI getIdCari()--> "+error);
	  	});
	  };

	  //membuat id spesifik
	  self.getIdSpesifik = function(){
	  	return DB.query("SELECT id_spesifikasi FROM tb_spesifik_cari ORDER BY id_spesifikasi DESC").then(function(result){
	  		var idSp = null;
	  		var quotData = result.rows.length;

	  		if(quotData == 0){
	  			idSp = 'SPS001';
	  		}else if(quotData < 9){
	  			var LastIdSp = parseInt(result.rows.item(0).id_spesifikasi.substring(3,6),10);
	  			idSp = 'SPS00' + (LastIdSp+1);
	  		}else if(quotData>=9 && quotData<99){
	  			var LastIdSp = parseInt(result.rows.item(0).id_spesifikasi.substring(3,6),10);
	  			idSp = 'SPS0' + (LastIdSp+1);
	  		}else if(quotData>=99 && quotData<1000){
	  			var LastIdSp = parseInt(result.rows.item(0).id_spesifikasi.substring(3,6),10);
	  			idSp = 'SPS' + (LastIdSp+1);
	  		}else{
	  			console.log('DATABASE HAS BEEN FULL');
	  		}
	  		return idSp;
	  	},function(error){
	  		console.log("TERJADI ERROR DI getIdSpesifik()--> "+error);
	  	});
	  };

	  //membuat id opsi map
	  self.getIdOpsiMap = function(){
	  	return DB.query("SELECT id_opsi_map FROM tb_opsi_map ORDER BY id_opsi_map DESC").then(function(result){
	  		var idOpsi = null;
	  		var quotData = result.rows.length;

	  		if(quotData == 0){
	  			idOpsi = 'OPS001';
	  		}else if(quotData < 9){
	  			var LastIdOpsi = parseInt(result.rows.item(0).id_opsi_map.substring(3,6),10);
	  			idOpsi = 'OPS00' + (LastIdOpsi+1);
	  		}else if(quotData>=9 && quotData<99){
	  			var LastIdOpsi = parseInt(result.rows.item(0).id_opsi_map.substring(3,6),10);
	  			idOpsi = 'OPS0' + (LastIdOpsi+1);
	  		}else if(quotData>=99 && quotData<1000){
	  			var LastIdOpsi = parseInt(result.rows.item(0).id_opsi_map.substring(3,6),10);
	  			idOpsi = 'OPS' + (LastIdOpsi+1);
	  		}else{
	  			console.log('DATABASE HAS BEEN FULL');
	  		}
	  		return idOpsi;
	  	},function(error){
	  		console.log("TERJADI ERROR DI getIdOpsiMap()--> "+error);
	  	});
	  };

	  //fungsi insert
	  self.insertAgen = function(id,name,jenis,lat,ltg){
	    return DB.query('INSERT INTO tb_agen (id_agen,nama_agen,id_jenis,lat_lokasi,long_lokasi) VALUES (?,?,?,?,?)',[id,name,jenis,lat,ltg]).then(function(result){
	      console.log('INSERT AGEN SUKSES!');
	    },function(error){
	     	console.log('GAGAL INSERT DATA DI TABLE AGEN--> '+error);
	     	//console.log(id+','+name+','+jenis+','+lat+','+ltg);
	    });
	  };

	  self.insertProfil = function(profil_id,id,alamat,ponsel1,ponsel2){
	  	return DB.query('INSERT INTO tb_profil (id_profil,id_agen,alamat_agen,phone_agen_satu,phone_agen_dua) VALUES (?,?,?,?,?)',[profil_id,id,alamat,ponsel1,ponsel2]).then(function(result){
	    	console.log('INSERT PROFIL SUKSES!');
	    },function(error){
	    	console.log('GAGAL INSERT DATA DATA DI TABLE PROFIL--> '+error);
	    	//console.log(profil_id+','+id+','+alamat+','+ponsel1+','+ponsel2);
	    });
	  };

	  self.insertRute = function(id_agen,rute_tujuan,flag){
	  	return DB.query('INSERT INTO tb_rute (id_agen,id_tujuan_rute,flag_rute) VALUES (?,?,?)',[id_agen,rute_tujuan,flag]).then(function(result){
	  		console.log('SUKSES MELAKUKAN INSERT RUTE');
	  	},function(error){
	  		console.log('GAGAL INSERT DATA PADA TABLE RUTE--> '+error);
	  	});
	  };

	  self.insertRuteInit = function(tujuan_rute){
	  	return DB.query('INSERT INTO tb_rute_tujuan (tujuan_rute) VALUES (?)',[tujuan_rute]).then(function(result){
	  		console.log('SUKSES MELAKUKAN INSERT INIT RUTE');
	  	},function(error){
	  		console.log('GAGAL INSERT DATA PADA INIT RUTE--> '+error);
	  	});				
	  };

	  self.insertJenisAgen = function(jenis){
	  	return DB.query('INSERT INTO tb_jenis_agen (jenis_agen) VALUES (?)',[jenis]).then(function(result){
			console.log('SUKSES INSERT DATA PADA TABLE JENIS AGEN');
		},function(error){
			console.log('GAGAL INSERT PADA TABLE JENIS AGEN--> '+error);
		});
	  };

	  self.insertPencarian = function(id_opsi,tgl){
	  	return DB.query('INSERT INTO tb_pencarian (id_opsi_map,tanggal_pencarian) VALUES (?,?)',[id_opsi,tgl]).then(function(result){
	  		console.log('SUKSES MELAKUKAN INSERT PENCARIAN');
	  	},function(error){
	  		console.log('GAGAL INSERT DATA PADA TABLE PENCARIAN--> '+error);
	  	});
	  };

	  self.insertSpesifikasi = function(id_spesifik,id_param,jenis){
	  	return DB.query('INSERT INTO tb_spesifik_cari (id_spesifikasi,id_param,jenis_spesifikasi) VALUES (?,?,?)',[id_spesifik,id_param,jenis]).then(function(result){
	  		console.log('SUKSES MELAKUKAN INSERT SPESIFIKASI');
	  	},function(error){
	  		console.log('GAGAL INSERT DATA PADA TABLE SPESIFIKASI--> '+error);
	  	});
	  };

	  self.insertParameter = function(parameter){
	  	return DB.query('INSERT INTO tb_param_cari (jenis_parameter) VALUES (?)',[parameter]).then(function(result){
	  		console.log('SUKSES MELAKUKAN INSERT PARAMETER');
	  	},function(error){
	  		console.log('GAGAL INSERT DATA PADA TABLE PARAMETER--> '+error);
	  	});
	  };

	  self.insertOpsiMap = function(id_opsi,id_spesifikasi,id_lokasi,id_jelajah,id_jalur){	
	  	return DB.query('INSERT INTO tb_opsi_map (id_opsi_map,id_spesifikasi,id_lokasi_perangkat,id_jalur,id_jelajah) VALUES (?,?,?,?,?)',[id_opsi,id_spesifikasi,id_lokasi,id_jalur,id_jelajah]).then(function(result){
	  		console.log('SUKSES MELAKUKAN INSERT PADA TABLE OPSI MAP');
	  	},function(error){
	  		console.log('GAGAL INSERT DATA PADA TABLE OPSI MAP--> '+error);
	  	});
	  };

	  self.insertJalur = function(jalur_mode){
	  	return DB.query('INSERT INTO tb_jalur_mode (mode_jalur) VALUES (?)',[jalur_mode]).then(function(result){
	  		console.log('SUKSES MELAKUKAN INSERT JALUR');
	  	},function(error){
	  		console.log('GAGAL INSERT DATA PADA TABLE JALUR--> '+error);
	  	});
	  };

	  self.insertJelajah = function(jelajah_mode){
	  	return DB.query('INSERT INTO tb_jelajah_mode (mode_jelajah) VALUES (?)',[jelajah_mode]).then(function(result){
	  		console.log('SUKSES MELAKUKAN INSERT JELAJAH');
	  	},function(error){
	  		console.log('GAGAL INSERT DATA PADA TABLE JELAJAH--> '+error);
	  	});
	  };

	  self.insertLokasiPerangkat = function(id_perangkat,lat,ltg){
	  	return DB.query('INSERT INTO tb_lokasi_perangkat (id_lokasi_perangkat,lat_pencarian,long_pencarian) VALUES (?,?,?) ',[id_perangkat,lat,ltg]).then(function(result){
	  		console.log('SUKSES MELAKUKAN INSERT PADA TABLE LOKASI PERANGKAT');
	  	},function(error){
	  		console.log('GAGAL INSERT PADA TABEL LOKASI PERANGKAT--> '+error);
	  	})
	  };
	  //end fungsi insert
	  
	  //fungsi update
	  self.editAgen = function(id,name,jenis,lat,ltg){
	  	//console.log(id,name,jenis,lat,ltg);
	  	return DB.query("UPDATE tb_agen SET nama_agen=?,id_jenis=?,lat_lokasi=?,long_lokasi=? WHERE id_agen=?",[name,jenis,lat,ltg,id]).then(function(result){
	  		console.log('UPDATE AGEN SUKSES');
	  	},function(error){
	  		console.log('GAGAL UPDATE DATA DARI TABLE AGEN--> '+error);
	  	});
	  };

	  self.editProfil = function(profil_id,alamat,ponsel1,ponsel2){
	  	//console.log(profil_id,alamat,ponsel1,ponsel2);
	  	return DB.query("UPDATE tb_profil SET alamat_agen=?,phone_agen_satu=?,phone_agen_dua=? WHERE id_profil=?",[alamat,ponsel1,ponsel2,profil_id]).then(function(result){
	  		console.log("UPDATE PROFIL SUKSES");
	  	},function(error){
	  		console.log('GAGAL UPDATE DATA DARI TABLE PROFIL--> '+error);	
	  	});
	  };

	  self.editRute = function(id,id_rute_tujuan,flag){
	  	//console.log(id,id_rute_tujuan,flag);
	  	return DB.query("UPDATE tb_rute SET flag_rute=? WHERE id_agen=? AND id_tujuan_rute=?",[flag,id,id_rute_tujuan]).then(function(result){
	  		console.log("UPDATE RUTE SUKSES");	
	  	},function(error){
	  		console.log("GAGAL UPDATE DATA DARI TABLE RUTE--> "+error);
	  	});
	  };
	  //end fungsi update
	  
	  //fungsi delete
	  self.removeAgen = function(id){
	  	return DB.query('DELETE FROM tb_agen WHERE id_agen=?',[id]).then(function(result){
	  		console.log('DELETE AGEN SUKSES');	
	  	},function(error){
	  		console.log('GAGAL DELETE DATA AGEN--> '+error);
	  	});
	  };

	  self.removeProfil = function(id){
	  	return DB.query('DELETE FROM tb_profil WHERE id_profil=?',[id]).then(function(result){
	  		console.log('DELETE PROFIL SUKSES');
	  	},function(error){
	  		console.log('GAGAL DELETE DATA PROFIL--> '+error);
	  	});
	  };

	  self.removeRute = function(id){
	  	return DB.query('DELETE FROM tb_rute WHERE id_agen=?',[id]).then(function(result){
	  		console.log('DELETE RUTE SUKSES');
	  	},function(error){
	  		console.log('GAGAL DELETE PADA RUTE--> '+error);	
	  	});
	  };

	  self.removePencarianById = function(id){
	  	return DB.query('DELETE FROM tb_pencarian WHERE id_pencarian=?',[id]).then(function(result){
	  		console.log('DELETE PENCARIAN SUKSES');
	  	},function(error){
	  		console.log('GAGAL DELETE PADA PENCARIAN--> '+error);
	  	});
	  };

	  self.removeSpesifikasiById = function(id){
	  	return DB.query('DELETE FROM tb_spesifik_cari WHERE id_spesifikasi=?',[id]).then(function(result){
	  		console.log('DELETE SPESIFIKASI SUKSES');
	  	},function(error){
	  		console.log('GAGAL DELETE PADA SPESIFIKASI');
	  	});
	  };

	  self.removeOpsiMapById = function(id){
	  	return DB.query('DELETE FROM tb_opsi_map WHERE id_opsi_map=?',[id]).then(function(result){
	  		console.log('DELETE OPSI MAP SUKSES');
	  	},function(error){
	  		console.log('GAGAL DELETE PADA OPSI MAP');
	  	});
	  };

	  self.removeLokasiPerangkatId = function(id){
	  	return DB.query('DELETE FROM tb_lokasi_perangkat WHERE id_lokasi_perangkat=?',[id]).then(function(result){
	  		console.log('DELETE LOKASI PERANGKAT SUKSES');
	  	},function(result){
	  		console.log('GAGAL DELETE PADA LOKASI PERANGKAT');
	  	});
	  }

	  self.removeAllPencarian = function(){
	  	return DB.query('DELETE FROM tb_pencarian').then(function(result){
	  		console.log('DELETE PENCARIAN SUKSES');
	  	},function(error){
	  		console.log('GAGAL DELETE PADA PENCARIAN--> '+error);
	  	});
	  };

	  self.removeAllSpesifikasi = function(){
	  	return DB.query('DELETE FROM tb_spesifik_cari').then(function(result){
	  		console.log('DELETE SPESIFIKASI SUKSES');
	  	},function(error){
	  		console.log('GAGAL DELETE PADA SPESIFIKASI--> '+error);
	  	});
	  };

	  self.removeAllOpsiMap = function(){
	  	return DB.query('DELETE FROM tb_opsi_map').then(function(result){
	  		console.log('DELETE OPSI MAP SUKSES');
	  	},function(error){
	  		console.log('GAGAL DELETE PADA OPSI MAP--> '+error);
	  	});
	  };

	  self.removeAllLokasiPerangkat = function(){	
	  	return DB.query('DELETE FROM tb_lokasi_perangkat').then(function(result){
	  		console.log('DELETE LOKASI PERANGKAT SUKSES');
	  	},function(error){
	  		console.log('GAGAL DELETE PADA LOKASI PERANGKAT--> '+error);
	  	})
	  };
	  //end fungsi delete

	  return self;
});
