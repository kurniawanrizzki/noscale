angular.module('ShowServices',[])


.factory('Agen',function(DB){
  var self =this;

  //controller map
  self.getParameter = function(){
    return DB.query("SELECT * FROM tb_param_cari").then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log("TERJADI ERROR PADA getParameter()--> "+error);
    });
  };
  //end get All Parameter

  //controller agen,on edit
  self.getRuteByid = function(id){
    return DB.query("SELECT a.id_tujuan_rute,b.tujuan_rute,a.flag_rute FROM tb_rute a INNER JOIN tb_rute_tujuan b ON a.id_tujuan_rute = b.id_tujuan_rute  WHERE a.id_agen=?",[id]).then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log("TERJADI ERROR PADA getRuteById()--> "+error);
    });
  };
  //end getRuteById()

  //controller map,load semua rute data
  self.getRuteAll = function(){
    return DB.query("SELECT * FROM tb_rute_tujuan").then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log("TERJADI ERROR PADA getRuteAll()--> "+error);
    });
  };
  //end getRuteAll
  
  //controller detail
  self.allAgenRute = function(id){
    return DB.query("SELECT * FROM tb_agen a INNER JOIN tb_rute b ON a.id_agen = b.id_agen INNER JOIN tb_rute_tujuan c ON b.id_tujuan_rute = c.id_tujuan_rute  WHERE a.id_agen=? AND b.flag_rute=1",[id]).then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log("TERJADI ERROR PADA allAgenRute()--> "+error);
    });
  };
  //end all agen rute
  
  //controller map
  self.getAgenByRute = function(rute){
    return DB.query("SELECT * FROM tb_rute a INNER JOIN tb_agen b ON a.id_agen= b.id_agen INNER JOIN tb_profil c ON a.id_agen = c.id_agen INNER JOIN tb_jenis_agen d ON b.id_jenis = d.id_jenis WHERE a.id_tujuan_rute=? AND a.flag_rute=1",[rute]).then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log("TERJADI ERROR Pada getAgenByRute()--> "+error);
    });
  };
  //end getAgenByRute
  
  //pencarian
  self.getAgenByRuteNama = function(nama_rute){
    return DB.query("SELECT * FROM tb_rute a INNER JOIN tb_agen b ON a.id_agen= b.id_agen INNER JOIN tb_rute_tujuan c ON a.id_tujuan_rute = c.id_tujuan_rute WHERE c.tujuan_rute=? AND a.flag_rute=1",[nama_rute]).then(function(result){     
      return DB.fetchAll(result);
    },function(error){
      console.log("TERJADI ERROR Pada getAgenByRuteNama()--> "+error);
    });
  };
  //end getAgenByRuteNama
  
  //controller map,controller agen
  self.getJenisAgen = function(){
    return DB.query("SELECT * FROM tb_jenis_agen").then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log('TERJADI ERROR Pada getJenisAgen()--> '+error);
    });
  };
  //end get jenis agen

  //controller map,pencarian
  self.getJenisAgenById= function(id){
    return DB.query("SELECT * FROM tb_jenis_agen WHERE id_jenis=?",[id]).then(function(result){
      return DB.fetch(result);
    },function(error){
      console.log('TERJADI ERROR Pada getJenisAgenById()--> '+error);
    });
  };
  //end getJenisAgenById

  //controller map,pencarian
  self.getAgenByJenis = function(jenis,jurusan){
    return DB.query("SELECT * FROM tb_agen a INNER JOIN tb_profil b ON a.id_agen = b.id_agen INNER JOIN tb_rute c ON a.id_agen = c.id_agen INNER JOIN tb_jenis_agen d ON a.id_jenis = d.id_jenis INNER JOIN tb_rute_tujuan e ON c.id_tujuan_rute = e.id_tujuan_rute  WHERE a.id_jenis=? AND c.id_tujuan_rute=? AND c.flag_rute=1",[jenis,jurusan]).then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log("TERJADI ERROR Pada getAgenByJenis--> "+error);
    });
  };
  //end get agen by jenis

  //controller map,load jalur 
  self.getJalur = function(){
    return DB.query("SELECT * FROM tb_jalur_mode LIMIT 2").then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log('TERJADI ERROR Pada getJalur()--> '+error);  
    });
  };
  //end get jalur

  //controller map, jelajah
  self.getJelajahAll = function(){
    return DB.query("SELECT * FROM tb_jelajah_mode").then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log('TERJADI ERROR Pada getJelajahAll()--> '+error);  
    });
  };
  //end get jelajah all

  //controller map, jelajah by id
  self.getJelajahById = function(id){
    return DB.query("SELECT * FROM tb_jelajah_mode WHERE id_jelajah=?",[id]).then(function(result){
      return DB.fetch(result);
    },function(error){
      console.log('TERJADI ERROR Pada getJelajah()--> '+error);  
    });
  };
  //end get jelajah

  //controller agen
  self.allAgen = function(){
    return DB.query("SELECT * FROM tb_agen a INNER JOIN tb_profil b ON a.id_agen=b.id_agen INNER JOIN tb_jenis_agen c ON a.id_jenis = c.id_jenis ").then(function(result){
      return DB.fetchAll(result);
    },function(error){
    	console.log("TERJADI ERROR PADA allAgen()--> "+error);
    });
  };
  //end all agen query
  
  //controller agen
  self.allAgenBus = function(){
    return DB.query("SELECT * FROM tb_agen a INNER JOIN tb_profil b ON a.id_agen=b.id_agen INNER JOIN tb_jenis_agen c ON a.id_jenis = c.id_jenis WHERE c.jenis_agen='BUS'").then(function(result){
      return DB.fetchAll(result);
    },function(error){
    	console.log("TERJADI ERROR PADA allAgenBus()--> "+error);
    });
  };
  //end all agen bus query

  //controller agen
  self.allAgenTravel = function(){
    return DB.query("SELECT * FROM tb_agen a INNER JOIN tb_profil b ON a.id_agen=b.id_agen INNER JOIN tb_jenis_agen c ON a.id_jenis = c.id_jenis WHERE c.jenis_agen='TRAVEL'").then(function(result){
      return DB.fetchAll(result);
    },function(error){
    	console.log("TERJADI ERROR PADA allAgenTravel()--> "+error);
    });
  };
  //all agen travel query

  //controller agen
  self.getByIdAgen = function(id){
    return DB.query("SELECT * FROM tb_agen a INNER JOIN tb_profil b ON a.id_agen = b.id_agen WHERE a.id_agen=?",[id]).then(function(result){
    	return DB.fetch(result);
    },function(error){
    	console.log("TERJADI ERROR PADA getByIdAgen()--> "+error);
    });
  };
  //end get agen by id
  
  //controller riwayat
  self.getPencarian = function(){
    //   
    return DB.query("SELECT * FROM tb_pencarian a INNER JOIN tb_opsi_map b ON a.id_opsi_map = b.id_opsi_map INNER JOIN tb_spesifik_cari c ON b.id_spesifikasi = c.id_spesifikasi INNER JOIN tb_param_cari d ON c.id_param = d.id_param INNER JOIN tb_jalur_mode e ON b.id_jalur = e.id_jalur INNER JOIN tb_jelajah_mode f ON b.id_jelajah = f.id_jelajah INNER JOIN tb_lokasi_perangkat g ON b.id_lokasi_perangkat = g.id_lokasi_perangkat ORDER BY a.id_pencarian DESC").then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log("TERJADI ERROR PADA getPencarian()--> "+error);
    });
  };
  //end get semua pencarian

  //controller map
  self.getPencarianById = function(id){
    return DB.query("SELECT * FROM tb_pencarian a INNER JOIN tb_opsi_map b ON a.id_opsi_map = b.id_opsi_map INNER JOIN tb_spesifik_cari c ON b.id_spesifikasi = c.id_spesifikasi INNER JOIN tb_param_cari d ON c.id_param = d.id_param INNER JOIN tb_jalur_mode e ON b.id_jalur = e.id_jalur INNER JOIN tb_jelajah_mode f ON b.id_jelajah = f.id_jelajah INNER JOIN tb_lokasi_perangkat g ON b.id_lokasi_perangkat = g.id_lokasi_perangkat  WHERE a.id_pencarian = ?",[id]).then(function(result){
      return DB.fetch(result);
    },function(error){
      console.log("TERJADI ERROR PADA getPencarianById--> "+error);
    });
  };
  //end get pencarian by id pencarian

  //controller map, pencarian
  self.getAgenByNamaJenis = function(jenis,jurusan){
    return DB.query("SELECT * FROM tb_agen a INNER JOIN tb_profil b ON a.id_agen = b.id_agen INNER JOIN tb_rute c ON a.id_agen = c.id_agen INNER JOIN tb_jenis_agen d ON a.id_jenis = d.id_jenis INNER JOIN tb_rute_tujuan e ON c.id_tujuan_rute = e.id_tujuan_rute  WHERE d.jenis_agen=? AND e.tujuan_rute=? AND c.flag_rute=1",[jenis,jurusan]).then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log("TERJADI ERROR Pada getAgenByNamaJenis--> "+error);
    });
  };
  //end get ageb by jenis nama

  //controller riwayat
  self.getAgenByNama = function(nama){
    return DB.query("SELECT * FROM tb_agen a INNER JOIN tb_profil b ON a.id_agen = b.id_agen INNER JOIN tb_jenis_agen c ON a.id_jenis = c.id_jenis WHERE a.nama_agen=?",[nama]).then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log("TERJADI ERROR Pada getAgenByNama--> "+error);
    });
  };
  //end get agen nama
  
  //controller map untuk menampilkan nama
  self.getNamaAgen = function(){
    return DB.query("SELECT DISTINCT nama_agen FROM tb_agen ORDER BY id_agen").then(function(result){
      return DB.fetchAll(result);
    },function(error){
      console.log("TERJADI ERROR pada getNamaAgen()--> "+error);
    });
  };
  //end get nama

  return self;
});