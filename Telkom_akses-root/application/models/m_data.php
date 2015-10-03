<?php  
class m_data extends CI_Model{

	function __construct(){
		parent::__construct();
	}

	//digunakan untuk mendapatkan semua data pegawai
	function getDataPegawai(){
		$query = $this->db->query("SELECT * FROM tb_pegawai a INNER JOIN tb_user b ON a.email_pegawai = b.email_pegawai WHERE b.grant_status = 'ON' ORDER BY a.id_pegawai ASC ");
		return $query->result();
	}

	//digunakan untuk mendapatkan semua data pelanggan
	function getDatapelanggan(){
		$query = $this->db->query('SELECT * FROM tb_pelanggan ORDER BY id_speedy ASC');
		return $query->result();
	} 

	//digunakan untuk mendapatkan semua data jalur MSAN/DP
	function getDataJalur(){
		$query = $this->db->query('SELECT a.id_dp,a.id_msan,a.nama_dp,b.nama_msan FROM tb_dp a INNER JOIN tb_msan b ON a.id_msan = b.id_msan ORDER BY a.id_msan');
		return $query->result();
	}

	//digunakan untuk insert pegawai
	function insertPegawai($pegawai){
		$query = $this->db->insert('tb_pegawai',$pegawai);
		return $query;
	}

	//digunakan untuk insert pelanggan
	function insertPelanggan($pelanggan){
		$query = $this->db->insert('tb_pelanggan',$pelanggan);
		return $query;
	}

	//digunakan untuk insert user
	function insertUser($user){
		$query = $this->db->insert('tb_user',$user);
		return $query;
	}

	//digunakan untuk mendapatkan pegawai berdasarkan id pegawai
	function getPegawaiById($id){
		$query = $this->db->query("SELECT * FROM tb_pegawai a INNER JOIN tb_user b ON a.email_pegawai = b.email_pegawai WHERE a.id_pegawai ='$id' ORDER BY id_pegawai ASC");
		return $query->result();
	}

	//digunakan untuk menghapus data pegawai
	function deletePegawai($id){
		$this->db->where('id_pegawai',$id);
		$this->db->delete('tb_pegawai');
	}

	//digunakan untuk mendapatkan pelanggan beradasarkan id pegawai
	function getPelangganById($id){
		$query = $this->db->query("SELECT a.id_speedy,a.id_dp,b.nama_dp,c.nama_msan,a.nama_pelanggan,a.alamat_pelanggan,a.lat_pelanggan,a.ltg_pelanggan,a.telp_hp_pelanggan,a.telp_rumah_pelanggan,a.status_pelanggan
								FROM tb_pelanggan a INNER JOIN tb_dp b ON a.id_dp = b.id_dp INNER JOIN tb_msan c ON b.id_msan = c.id_msan WHERE a.id_speedy = '$id'");
		return $query->result();
	}

	//digunakan untuk menghapus pelanggan 
	function deletePelanggan($id){
		$this->db->where('id_speedy',$id);
		$this->db->delete('tb_pelanggan');
	}

	//digunakan untuk mengupdate pegawai
	function updatePegawai($id,$pegawai){
		$this->db->where('id_pegawai',$id);
		$this->db->update('tb_pegawai',$pegawai);
	}

	//digunakan untuk mengupdate user
	function updateUser($id,$pegawai){
		$this->db->where('id_user',$id);
		$this->db->update('tb_user',$pegawai);
	}

	//digunakan untuk mengupdate pelanggan
	function updatePelanggan($id,$pelanggan){
		$this->db->where('id_speedy',$id);
		$this->db->update('tb_pelanggan',$pelanggan);
	}

	//digunakan untuk semua jalur yang tidak sama dengan id dp yang dimiliki pengguna
	function dataJalurNotById($id){
		$query = $this->db->query("SELECT a.id_dp,a.id_msan,a.nama_dp,b.nama_msan FROM tb_dp a INNER JOIN tb_msan b ON a.id_msan = b.id_msan WHERE a.id_dp != '$id'");
		return $query->result();
	}

	//digunakan untuk mendapatkan riwayat pekerjaan tiap pengguna
	function getRiwayatPerUser($id){
		$query = $this->db->query("SELECT c.id_pegawai,c.nama_pegawai,e.id_speedy,e.nama_pelanggan,f.nama_dp,g.nama_msan,e.alamat_pelanggan,h.jenis_keluhan,d.tgl_laporan,b.tgl_pengerjaan,a.tgl_kunjungan,a.jam_kunjungan,a.status_kunjungan 
				FROM tb_kunjungan a INNER JOIN tb_jadwal b ON a.id_jadwal = b.id_jadwal 
				INNER JOIN tb_pegawai c ON b.id_pegawai = c.id_pegawai 
				INNER JOIN tb_keluhan d ON b.id_keluhan = d.id_keluhan 
				INNER JOIN tb_pelanggan e ON d.id_speedy = e.id_speedy 
				INNER JOIN tb_dp f ON f.id_dp = e.id_dp 
				INNER JOIN tb_msan g ON f.id_msan = g.id_msan 
				INNER JOIN tb_kat_keluhan h ON h.id_kat_keluhan = d.id_kat_keluhan 
				WHERE b.id_pegawai = '$id' 
				ORDER BY b.id_jadwal,a.tgl_kunjungan DESC");
		return $query->result();
	}

	//digunakan untuk menghitung total pekerjaan unfinished
	function getTotUFPerUser($id){
		$query = $this->db->query("SELECT DISTINCT * FROM tb_jadwal a INNER JOIN tb_kunjungan b ON a.id_jadwal = b.id_jadwal 
				WHERE b.status_kunjungan='MENUNGGU' AND id_pegawai = '$id'");
		return $query->result();
	}

	//digunakan untuk mendapatkan riwayat pekerjaan tiap pengguna per bulan
	function getRiwayatPerUserBulanan($id,$bulan){
		$query = $this->db->query("SELECT c.id_pegawai,c.nama_pegawai,e.id_speedy,e.nama_pelanggan,f.nama_dp,g.nama_msan,e.alamat_pelanggan,h.jenis_keluhan,d.tgl_laporan,b.tgl_pengerjaan,a.tgl_kunjungan,a.jam_kunjungan,a.status_kunjungan 
				FROM tb_kunjungan a INNER JOIN tb_jadwal b ON a.id_jadwal = b.id_jadwal 
				INNER JOIN tb_pegawai c ON b.id_pegawai = c.id_pegawai 
				INNER JOIN tb_keluhan d ON b.id_keluhan = d.id_keluhan 
				INNER JOIN tb_pelanggan e ON d.id_speedy = e.id_speedy 
				INNER JOIN tb_dp f ON f.id_dp = e.id_dp 
				INNER JOIN tb_msan g ON f.id_msan = g.id_msan 
				INNER JOIN tb_kat_keluhan h ON h.id_kat_keluhan = d.id_kat_keluhan 
				WHERE b.id_pegawai = '$id' AND MONTH(a.tgl_kunjungan) = '$bulan'
				ORDER BY b.id_jadwal,a.tgl_kunjungan DESC");
		return $query->result();
	}

	//digunakan untuk menghitung total pekerjaan unfinished per bulan
	function getTotUFPerUserBulanan($id,$bulan){
		$query = $this->db->query("SELECT DISTINCT * FROM tb_jadwal a INNER JOIN tb_kunjungan b ON a.id_jadwal = b.id_jadwal 
				WHERE b.status_kunjungan='MENUNGGU' AND id_pegawai = '$id' AND MONTH(b.tgl_kunjungan) = '$bulan'");
		return $query->result();
	}

	function checkIdPegawai($id){
		$query = $this->db->query("SELECT * FROM tb_pegawai WHERE id_pegawai='$id'");
		return $query->result();
	}

	function checkEmailPegawai($email){
		$query = $this->db->query("SELECT * FROM tb_pegawai WHERE email_pegawai LIKE '%$email%'");
		return $query->result();
	}

	function checkIdPelanggan($id){
		$query = $this->db->query("SELECT * FROM tb_pelanggan WHERE id_speedy='$id'");
		return $query->result();
	}

	function cekJabatan($id){
		$query = $this->db->query("SELECT jabatan_pegawai FROM tb_pegawai WHERE id_pegawai ='$id'");
		return $query->result();
	}
}
?>