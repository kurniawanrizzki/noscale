angular.module('configDB',[])

.constant('DBHelper',{
	name: 'FISTRA_DB',
	tables:[

	//AGEN
	
	{
		name:'tb_agen',
		columns:[
			{name:'id_agen', type:'TEXT PRIMARY KEY'},
			{name:'id_jenis', type:'INTEGER'},
			{name:'nama_agen',type:'TEXT'},
			{name:'lat_lokasi',type:'INTEGER'},
			{name:'long_lokasi',type:'INTEGER'}
		]
	},{
		name:'tb_profil',
		columns:[
			{name:'id_profil',type:'TEXT PRIMARY KEY'},
			{name:'id_agen',type:'TEXT'},
			{name:'alamat_agen',type:'TEXT'},
			{name:'phone_agen_satu',type:'TEXT'},
			{name:'phone_agen_dua',type:'TEXT'}
		]
	},{
		name:'tb_rute',
		columns:[
			{name:'id_rute',type:'INTEGER PRIMARY KEY'},
			{name:'id_agen',type:'TEXT'},
			{name:'asal_rute',type:"TEXT DEFAULT \'SEMARANG\'" },
			{name:'id_tujuan_rute',type:'INTEGER'},
			{name:'flag_rute',type:'INTEGER'}
		]
	},{
		name:'tb_rute_tujuan',
		columns:[
			{name:'id_tujuan_rute', type:'INTEGER PRIMARY KEY'},
			{name:'tujuan_rute',type:'TEXT'},
			{name:'flag_awal',type:'INTEGER DEFAULT 0'}
		]
	},{
		name:'tb_jenis_agen',
		columns:[
			{name:'id_jenis',type:'INTEGER PRIMARY KEY'},
			{name:'jenis_agen',type:'TEXT'}
		]
	},

	//PENCARIAN

	{
		name:'tb_lokasi_perangkat',
		columns:[
			{name:'id_lokasi_perangkat',type:'TEXT PRIMARY KEY'},
			{name:'lat_pencarian',type:'INTEGER'},
			{name:'long_pencarian',type:'INTEGER'}
		]
	},{
		name:'tb_param_cari',
		columns:[
			{name:'id_param',type:'INTEGER PRIMARY KEY'},
			{name:'jenis_parameter',type:'TEXT'}
		]
	},{
		name:'tb_spesifik_cari',
		columns:[
			{name:'id_spesifikasi',type:'TEXT PRIMARY KEY'},
			{name:'id_param',type:'INTEGER'},
			{name:'jenis_spesifikasi',type:'TEXT'}
		]
	},{
		name:'tb_jelajah_mode',
		columns:[
			{name:'id_jelajah',type:'INTEGER PRIMARY KEY'},
			{name:'mode_jelajah',type:'TEXT'}
		]
	},{
		name:'tb_jalur_mode',
		columns:[
			{name:'id_jalur',type:'INTEGER PRIMARY KEY'},
			{name:'mode_jalur',type:'TEXT'}
		]
	},{
		name:'tb_opsi_map',
		columns:[
			{name:'id_opsi_map',type:'TEXT PRIMARY KEY'},
			{name:'id_spesifikasi',type:'INTEGER'},
			{name:'id_lokasi_perangkat',type:'INTEGER'},
			{name:'id_jelajah',type:'INTEGER'},
			{name:'id_jalur',type:'INTEGER'}
		]
	},{
		name:'tb_pencarian',
		columns:[
			{name:'id_pencarian',type:'INTEGER PRIMARY KEY'},
			{name:'id_opsi_map',type:'TEXT'},
			{name:'tanggal_pencarian',type:'TEXT'}
		]
	}]
});