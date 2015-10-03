<?php
//model yang digunakan pada controller login  
Class M_login extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	//Login 

	//function loginuser yang digunakan untuk mencocokkan akun user dengan passwordnya
	function loginUser($email,$password){
		$this->db->select('a.id_user,b.img_pegawai,b.img_pegawai_small,b.id_pegawai,b.nama_pegawai,b.email_pegawai,a.password,b.jabatan_pegawai,a.grant_status');
		$this->db->from('tb_user a');
		$this->db->join('tb_pegawai b','a.email_pegawai= b.email_pegawai');
		$this->db->where('b.email_pegawai',$email);
		$this->db->where('a.password',$password);

    	$query = $this->db->get()->result();
    
		return $query;
	}


	//function untuk mengambil last login dari user untuk digunakan pada methode updateWhenLogout
	function ambilLastLogin($id){
		$query = $this->db->query("SELECT* FROM tb_login WHERE id_user='$id' ORDER BY id_login DESC LIMIT 1");
		return $query->result();
	}

	//function yang digunakan untuk menginsert data login
	function insertWhenLogin($login){
		$query = $this->db->insert('tb_login',$login);
		return $query;
	}

	//function yang digunakan untuk mengupdate data logout pada tb login
	function updateWhenLogout($id,$logout){
		$this->db->where('id_login',$id);
		$this->db->update('tb_login',$logout);
	}

	//end Login

	//kelola kunjungan teknisi jika terlewat 1 hari 

	//function ini digunakan untuk menampilkna semua data jadwal dengan status unfinished dan tanggalnya sudah melewati tanggal hari ini
	function selectJadwalUnfinished(){
		date_default_timezone_set('Asia/Jakarta');
		$datenow = date('Y-m-d');
		$query = $this->db->query("SELECT a.id_kunjungan,a.id_jadwal,b.id_pegawai,a.tgl_kunjungan,a.ket_kunjungan 
				FROM tb_kunjungan a INNER JOIN tb_jadwal b ON a.id_jadwal = b.id_jadwal 
				WHERE a.status_kunjungan = 'MENUNGGU' 
				AND a.tgl_kunjungan < '$datenow'" );
		return $query->result();
	}

	//function update kunjungan untuk pelanggan yang masih menunggu dilayani dan lewat 1 hari
	function updateKunjunganMenunggu($id,$kunjungan){
		$this->db->where('id_kunjungan',$id);
		$this->db->update('tb_kunjungan',$kunjungan);
	}

	//function ini digunakan untuk menjadwal kembali jadwal yang lewat 1 hari 
	function insertRepeatKunjungan($kunjungan){
		$query = $this->db->insert('tb_kunjungan',$kunjungan);
		return $query;
	}

	//end kelola kunjungan
}
?>