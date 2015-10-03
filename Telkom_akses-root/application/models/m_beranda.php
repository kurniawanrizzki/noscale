<?php  
class M_beranda extends CI_Model{

	//membentuk construct
	function __construct(){
		parent::__construct();
	}

	function getImage($id){
		$query = $this->db->query("SELECT * FROM tb_pegawai WHERE id_pegawai = '$id'");
		return $query->result();
	}

	//function get pegawai digunakan untuk mendapatkan semua pegawai
	function getPegawai(){
		$query = $this->db->query("SELECT a.id_pegawai,a.nama_pegawai,a.img_pegawai_small,a.jabatan_pegawai 
				FROM tb_pegawai a INNER JOIN tb_user b ON a.email_pegawai = b.email_pegawai
				WHERE a.jabatan_pegawai = 'TEKNISI' AND b.grant_status = 'ON' 
				ORDER BY id_pegawai ASC");
		return $query->result();
	}

	//function ini digunakan untuk mendapatkan jumlah jadwal dengan status menunggu yang aktif hari ini
	function getJumlahJadwal(){
		date_default_timezone_set('Asia/Jakarta');
		$datenow = date('Y-m-d');
		$query = $this->db->query("SELECT DISTINCT a.id_jadwal 
				FROM tb_jadwal a INNER JOIN tb_kunjungan b ON a.id_jadwal = b.id_jadwal 
				WHERE b.tgl_kunjungan = '$datenow' AND b.status_kunjungan = 'MENUNGGU'");
		return $query->result();
	}

	//function ini dignuakan untuk mendapatkan jadwal jumlah dengan status menunggu untuk pengguna teknisi
	function getJumlahJadwalById($id){
		date_default_timezone_set('Asia/Jakarta');
		$datenow = date('Y-m-d');
		$query = $this->db->query("SELECT DISTINCT a.id_jadwal 
				FROM tb_jadwal a INNER JOIN tb_kunjungan b ON a.id_jadwal = b.id_jadwal 
				WHERE b.tgl_kunjungan = '$datenow' 
				AND b.status_kunjungan = 'MENUNGGU' 
				AND a.id_pegawai='$id'");
		return $query->result();
	}

	//function get jadwal tiap pegawai
	function getJadwal($id_pegawai){
		date_default_timezone_set('Asia/Jakarta');
		$datenow = date('Y-m-d');
		$query = $this->db->query("SELECT a.id_kunjungan,a.id_jadwal,c.id_speedy,d.nama_pelanggan,d.alamat_pelanggan,d.telp_hp_pelanggan,c.ket_keluhan,e.jenis_keluhan,b.tgl_pengerjaan,a.tgl_kunjungan,a.status_kunjungan
				FROM tb_kunjungan a INNER JOIN tb_jadwal b ON a.id_jadwal = b.id_jadwal
				INNER JOIN tb_keluhan c ON b.id_keluhan = c.id_keluhan
				INNER JOIN tb_pelanggan d ON c.id_speedy = d.id_speedy
				INNER JOIN tb_kat_keluhan e ON c.id_kat_keluhan = e.id_kat_keluhan
				WHERE b.id_pegawai = '$id_pegawai' AND a.tgl_kunjungan = '$datenow'
				AND a.status_kunjungan = 'MENUNGGU' 
				ORDER BY a.id_kunjungan ASC
				");
		return $query->result();
	}

	//function get pegawai berdasarkan id
	function getPegawaiById($id){
		$query = $this->db->query("SELECT id_pegawai,nama_pegawai,img_pegawai FROM tb_pegawai WHERE id_pegawai='$id'");
		return $query->result();
	}

	//function get keluhan untuk mendapatkan semua keluhan yang belum terjadwal atau yang tertunda untuk dimasukkan
	function getKeluhanBt(){
		$query = $this->db->query("SELECT e.id_kunjungan,d.id_jadwal,a.id_keluhan,a.id_speedy,c.nama_pelanggan,c.alamat_pelanggan,a.ket_keluhan,b.jenis_keluhan,d.log_j,e.log_ks 
				FROM tb_keluhan a 
				INNER JOIN tb_kat_keluhan b ON a.id_kat_keluhan = b.id_kat_keluhan 
				INNER JOIN tb_pelanggan c ON a.id_speedy = c.id_speedy 
				LEFT JOIN tb_jadwal d ON a.id_keluhan = d.id_keluhan 
				LEFT JOIN tb_kunjungan e ON d.id_jadwal = e.id_jadwal 
				WHERE d.id_pegawai IS NULL OR e.id_kunjungan IS NULL 
				OR e.status_kunjungan = 'TIDAK SELESAI' AND e.log_ks = 1  ORDER BY a.tgl_laporan ASC");
		return $query->result();
	}

	//function add jadwal digunakan untuk menambahkan jadwal
	function addJadwal($jadwal){
		$query = $this->db->insert('tb_jadwal',$jadwal);

		$last_id = $this->db->insert_id();
		$tgl_kunjungan = $jadwal['tgl_pengerjaan'];
	
		$kunjungan = array('id_jadwal'=>$last_id,'tgl_kunjungan'=>$tgl_kunjungan);
		$query = $this->db->insert('tb_kunjungan',$kunjungan);
	}

	function addJadwalInHapus($jadwal){
		$query = $this->db->insert('tb_jadwal',$jadwal);

		$last_id = $this->db->insert_id();

		$kunjungan = array('id_jadwal'=>$last_id);
		$query = $this->db->insert('tb_kunjungan',$kunjungan);
	}

	//function add kunjungan digunakan untuk menambahkan kunjungan
	function addKunjungan($kunjungan){
		$query = $this->db->insert('tb_kunjungan',$kunjungan);
	}

	//function hapus jadwal digunakan untuk menghapus jadwal
	function hapusKunjungan($id,$status){
		$this->db->where('id_kunjungan',$id);
		$this->db->update('tb_kunjungan',$status);
	}

	function updateJadwal($id,$log){
		$this->db->where('id_jadwal',$id);
		$this->db->update('tb_jadwal',$log);
	}

	function updateKunjunganTerakhir($id,$log){
		$this->db->where('id_kunjungan',$id);
		$this->db->update('tb_kunjungan',$log);
	}

	function selectKunjunganTerakhir($id_jadwal){
		$query = $this->db->query("SELECT id_kunjungan FROM tb_kunjungan WHERE id_jadwal = '$id_jadwal' AND status_kunjungan = 'TIDAK SELESAI' ORDER BY id_kunjungan DESC LIMIT 1");
		return $query->result();
	}

	function selectJadwalToUpd($id){
		$query = $this->db->query("SELECT id_keluhan FROM tb_jadwal WHERE id_jadwal = '$id' ORDER BY id_jadwal DESC LIMIT 1");
		return $query->result();
	}

}
?>