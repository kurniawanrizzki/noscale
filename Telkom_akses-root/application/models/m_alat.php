<?php  
class M_alat extends CI_Model{

	//function get user
	function getUser($id){
		$query = $this->db->query("SELECT a.id_user,b.id_pegawai,b.nama_pegawai,b.jabatan_pegawai,a.email_pegawai,a.password,a.grant_status,count(c.login) AS jml_login FROM tb_user a LEFT JOIN tb_login c ON a.id_user = c.id_user INNER JOIN tb_pegawai b ON a.email_pegawai = b.email_pegawai GROUP BY b.id_pegawai HAVING b.id_pegawai != $id");
		return $query->result();
	}

	function getUserById($id){
		$query = $this->db->query("SELECT a.id_user,b.id_pegawai,b.nama_pegawai,b.jabatan_pegawai,b.email_pegawai,a.grant_status FROM tb_user a INNER JOIN tb_pegawai b ON a.email_pegawai = b.email_pegawai WHERE a.id_user = '$id'");
		return $query->result();
	}

	function getLoginById($id){
		$query = $this->db->query("SELECT a.id_user,c.id_pegawai,c.nama_pegawai,c.jabatan_pegawai,a.email_pegawai,b.login,b.logout FROM tb_user a LEFT JOIN tb_login b ON a.id_user = b.id_user INNER JOIN tb_pegawai c ON a.email_pegawai = c.email_pegawai WHERE a.id_user = '$id' ORDER BY b.id_login DESC");
		return $query->result();
	}

	function getLoginByIdPerbulan($id,$bulan){
		$query = $this->db->query("SELECT a.id_user,c.id_pegawai,c.nama_pegawai,c.jabatan_pegawai,a.email_pegawai,b.login,b.logout FROM tb_user a LEFT JOIN tb_login b ON a.id_user = b.id_user INNER JOIN tb_pegawai c ON a.email_pegawai = c.email_pegawai WHERE a.id_user = '$id' AND MONTH(b.login) = '$bulan'  ORDER BY b.id_login DESC");
		return $query->result();
	}

	//function get keluhan
	function getKeluhan(){
		$query = $this->db->query("SELECT a.id_keluhan,a.id_speedy,b.nama_pelanggan,b.alamat_pelanggan,b.lat_pelanggan,b.ltg_pelanggan,a.ket_keluhan,c.jenis_keluhan,a.tgl_laporan,d.tgl_pengerjaan,f.tgl_kunjungan,f.status_kunjungan,e.nama_pegawai AS teknisi 
				FROM tb_keluhan a INNER JOIN tb_pelanggan b ON a.id_speedy = b.id_speedy 
				INNER JOIN tb_kat_keluhan c ON a.id_kat_keluhan = c.id_kat_keluhan 
				LEFT JOIN tb_jadwal d ON a.id_keluhan = d.id_keluhan 
				LEFT JOIN tb_pegawai e ON d.id_pegawai = e.id_pegawai 
				LEFT JOIN tb_kunjungan f ON f.id_jadwal = d.id_jadwal 
				ORDER BY a.tgl_laporan, f.tgl_kunjungan DESC");
		return $query->result();
	}

	//function get keluhan hari ini 
	function getKeluhanHariIni(){
		date_default_timezone_set('Asia/Jakarta');
		$datenow = date('Y-m-d');
		$query = $this->db->query("SELECT a.id_keluhan,a.id_speedy,b.nama_pelanggan,b.alamat_pelanggan,b.lat_pelanggan,b.ltg_pelanggan,a.ket_keluhan,c.jenis_keluhan,a.tgl_laporan,d.tgl_pengerjaan,f.tgl_kunjungan,f.status_kunjungan,e.nama_pegawai AS teknisi 
				FROM tb_keluhan a INNER JOIN tb_pelanggan b ON a.id_speedy = b.id_speedy 
				INNER JOIN tb_kat_keluhan c ON a.id_kat_keluhan = c.id_kat_keluhan 
				LEFT JOIN tb_jadwal d ON a.id_keluhan = d.id_keluhan 
				LEFT JOIN tb_pegawai e ON d.id_pegawai = e.id_pegawai 
				LEFT JOIN tb_kunjungan f ON f.id_jadwal = d.id_jadwal 
				WHERE f.tgl_kunjungan = '$datenow'  AND f.status_kunjungan = 'MENUNGGU'
				ORDER BY e.nama_pegawai ASC");
		return $query->result();
	}

	//function get_keluhan dengan status unfinished dan null
	function getKeluhanUnfinul(){
		$query = $this->db->query("SELECT a.id_keluhan,a.id_speedy,b.nama_pelanggan,b.alamat_pelanggan,b.lat_pelanggan,b.ltg_pelanggan,a.ket_keluhan,c.jenis_keluhan,a.tgl_laporan,d.tgl_pengerjaan,f.tgl_kunjungan,f.status_kunjungan,e.nama_pegawai AS teknisi 
				FROM tb_keluhan a INNER JOIN tb_pelanggan b ON a.id_speedy = b.id_speedy 
				INNER JOIN tb_kat_keluhan c ON a.id_kat_keluhan = c.id_kat_keluhan 
				LEFT JOIN tb_jadwal d ON a.id_keluhan = d.id_keluhan 
				LEFT JOIN tb_pegawai e ON d.id_pegawai = e.id_pegawai 
				LEFT JOIN tb_kunjungan f ON f.id_jadwal = d.id_jadwal 
				WHERE f.status_kunjungan = 'MENUNGGU' 
				OR f.status_kunjungan IS NULL 
				ORDER BY a.tgl_laporan ASC,f.status_kunjungan DESC");
		return $query->result();
	}

	//function evaluasi data keluhan per bulan
	function getEvaluasiKeluhan($bulan,$tahun){
		$query = $this->db->query("SELECT MONTH(a.tgl_laporan) AS bulan,YEAR(a.tgl_laporan) AS tahun,b.jenis_keluhan,COUNT(*) AS jml_keluhan 
				FROM tb_keluhan a INNER JOIN tb_kat_keluhan b ON a.id_kat_keluhan = b.id_kat_keluhan 
				GROUP BY b.id_kat_keluhan,MONTH(a.tgl_laporan) HAVING BULAN = $bulan AND tahun = $tahun");
		return $query->result();
	}

	function getEvaluasiPegawai($bulan,$tahun){

		// SELECT MONTH(a.tgl_laporan) AS bulan,d.id_pegawai,d.nama_pegawai,c.status_kunjungan,COUNT(CASE WHEN c.status_kunjungan = 'MENUNGGU' THEN b.id_keluhan end) jml_uf, COUNT(CASE WHEN c.status_kunjungan = 'SELESAI' THEN b.id_keluhan end) jml_f, COUNT(CASE WHEN c.status_kunjungan = 'TIDAK SELESAI' THEN b.id_keluhan end) jml_t 
		// 		FROM tb_keluhan a 
		// 		LEFT JOIN tb_jadwal b ON a.id_keluhan = b.id_keluhan 
		// 		LEFT JOIN tb_kunjungan c ON b.id_jadwal = c.id_jadwal 
		// 		LEFT JOIN tb_pegawai d ON b.id_pegawai = d.id_pegawai 
		// 		GROUP BY d.nama_pegawai,bulan HAVING bulan = 7 
		// 		ORDER BY d.nama_pegawai DESC
		
		$query = $this->db->query("SELECT MONTH(a.tgl_laporan) AS bulan,YEAR(a.tgl_laporan) AS tahun,d.id_pegawai,d.nama_pegawai,c.status_kunjungan,COUNT(CASE WHEN c.status_kunjungan = 'MENUNGGU' THEN b.id_keluhan end) jml_uf, COUNT(CASE WHEN c.status_kunjungan = 'SELESAI' THEN b.id_keluhan end) jml_f, COUNT(CASE WHEN c.status_kunjungan = 'TIDAK SELESAI' THEN b.id_keluhan end) jml_t 
				FROM tb_keluhan a 
				INNER JOIN tb_jadwal b ON a.id_keluhan = b.id_keluhan 
				INNER JOIN tb_kunjungan c ON b.id_jadwal = c.id_jadwal 
				INNER JOIN tb_pegawai d ON b.id_pegawai = d.id_pegawai 
				GROUP BY d.nama_pegawai,bulan HAVING bulan = $bulan AND  tahun = $tahun
				ORDER BY d.nama_pegawai DESC");
		return $query->result();
	}

	//detail kerusakan msan/dp
	function getDetailKeluhanMsanDp($bulan){
		$query = $this->db->query("SELECT MONTH(d.tgl_laporan) AS bulan,b.nama_msan,a.nama_dp,COUNT(CASE WHEN MONTH(d.tgl_laporan) = 7 AND d.id_kat_keluhan = 14 THEN d.id_keluhan WHEN MONTH(d.tgl_laporan) != 7 AND d.id_kat_keluhan =14 THEN NULL END) jml_keluhan 
				FROM tb_dp a RIGHT JOIN tb_msan b ON a.id_msan = b.id_msan 
				LEFT JOIN tb_pelanggan c ON a.id_dp = c.id_dp 
				LEFT JOIN tb_keluhan d ON c.id_speedy = d.id_speedy 
				GROUP BY b.id_msan,a.id_dp ORDER BY b.id_msan,a.id_dp ASC");
		return $query->result();
	}

	//function insert keluhan
	function insertKeluhan($keluhan){
		$query = $this->db->insert('tb_keluhan',$keluhan);
		return $query;
	}

	//function get kategori keluhan
	function getKatKeluhan(){
		$query = $this->db->query('SELECT id_kat_keluhan,jenis_keluhan FROM tb_kat_keluhan');
		return $query;
	}

	//function get pelanggan
	function getInfoPelanggan($data){
		$query = $this->db->query("SELECT * FROM tb_pelanggan WHERE id_speedy LIKE '%$data%' OR nama_pelanggan LIKE '%$data%'"  );
		return $query->result();
	}

	function getPelanggan(){
		$query = $this->db->query("SELECT * FROM tb_pelanggan WHERE status_pelanggan = 'ON' ORDER BY id_speedy ASC");
		return $query->result();
	}

	//function get_pelanggan_by_id
	function getPelangganById($id){
		$query = $this->db->query("SELECT * FROM tb_pelanggan a INNER JOIN tb_dp b ON a.id_dp = b.id_dp INNER JOIN tb_msan c ON b.id_msan=c.id_msan WHERE a.id_speedy ='$id'");
		return $query->result();
	}

	//function get_kategori
	function getKategori(){
		$query = $this->db->query("SELECT * FROM tb_kat_keluhan ORDER BY id_kat_keluhan ASC");
		return $query->result();
	}

	//function get_jalur
	function getJalur($dp){
		$query = $this->db->query("SELECT * FROM tb_dp a INNER JOIN tb_msan b ON a.id_msan = b.id_msan WHERE a.id_dp != '$dp' ORDER BY a.id_dp");
		return $query->result();
	}

	function getDataKeluhanById($id){
		$query = $this->db->query("SELECT a.id_keluhan,a.id_speedy,b.nama_pelanggan,b.alamat_pelanggan,b.telp_hp_pelanggan,b.telp_rumah_pelanggan,g.id_dp,g.nama_dp,h.nama_msan,a.ket_keluhan,c.id_kat_keluhan,c.jenis_keluhan,a.tgl_laporan,d.tgl_pengerjaan,f.tgl_kunjungan,f.ket_kunjungan,f.status_kunjungan,e.nama_pegawai AS teknisi 
				FROM tb_keluhan a INNER JOIN tb_pelanggan b ON a.id_speedy = b.id_speedy 
				INNER JOIN tb_kat_keluhan c ON a.id_kat_keluhan = c.id_kat_keluhan 
				INNER JOIN tb_dp g ON b.id_dp = g.id_dp 
				INNER JOIN tb_msan h ON g.id_msan = h.id_msan
				LEFT JOIN tb_jadwal d ON a.id_keluhan = d.id_keluhan 
				LEFT JOIN tb_pegawai e ON d.id_pegawai = e.id_pegawai 
				LEFT JOIN tb_kunjungan f ON f.id_jadwal = d.id_jadwal   
				WHERE a.id_keluhan= '$id' ORDER BY f.id_kunjungan DESC LIMIT 1");
		// SELECT a.id_keluhan,a.id_speedy,c.id_kat_keluhan,b.id_dp,f.nama_dp,g.nama_msan,b.nama_pelanggan,b.alamat_pelanggan,b.telp_hp_pelanggan,b.telp_rumah_pelanggan,a.ket_keluhan,c.jenis_keluhan,a.tgl_laporan,d.tgl_pengerjaan,d.status_pengerjaan,e.nama_pegawai AS teknisi 
		// 		FROM tb_keluhan a INNER JOIN tb_pelanggan b ON a.id_speedy = b.id_speedy 
		// 		INNER JOIN tb_kat_keluhan c ON a.id_kat_keluhan = c.id_kat_keluhan 
		// 		INNER JOIN tb_dp f ON b.id_dp = f.id_dp 
		// 		INNER JOIN tb_msan g ON f.id_msan = g.id_msan 
		// 		LEFT JOIN tb_jadwal d ON a.id_keluhan = d.id_keluhan  
		// 		LEFT JOIN tb_pegawai e ON d.id_pegawai = e.id_pegawai 
		return $query->result();
	}

	function getKategoriNd($id){
		$query = $this->db->query("SELECT * FROM tb_kat_keluhan WHERE id_kat_keluhan != '$id'");
		return $query->result();
	}

	function hapusKeluhan($id){
		$this->db->where('id_keluhan',$id);
		$this->db->delete('tb_keluhan');
	}

	function ubahPasswordOrGrant($id,$user){
		$this->db->where('id_user',$id);
		$this->db->update('tb_user',$user);
	}

	function updateKeluhan($id,$keluhan){
		$this->db->where('id_keluhan',$id);
		$this->db->update('tb_keluhan',$keluhan);
	}

	function getRiwayatById($id,$bulan,$tahun){
		$query =  $this->db->query("SELECT MONTH(b.tgl_laporan) AS BULAN,a.id_jadwal,a.id_pegawai,d.nama_pegawai,c.id_speedy,c.nama_pelanggan,c.alamat_pelanggan,e.jenis_keluhan,b.tgl_laporan,a.tgl_pengerjaan,f.tgl_kunjungan,f.jam_kunjungan,f.status_kunjungan,f.ket_kunjungan 
				FROM tb_jadwal a INNER JOIN tb_keluhan b ON a.id_keluhan = b.id_keluhan 
				INNER JOIN tb_pelanggan c ON b.id_speedy = c.id_speedy 
				INNER JOIN tb_pegawai d ON a.id_pegawai = d.id_pegawai 
				INNER JOIN tb_kat_keluhan e ON b.id_kat_keluhan = e.id_kat_keluhan 
				INNER JOIN tb_kunjungan f ON a.id_jadwal = f.id_jadwal 
				WHERE a.id_pegawai = '$id' AND MONTH(b.tgl_laporan) = '$bulan' AND YEAR(b.tgl_laporan) = '$tahun'");
		return $query->result();
	}

	function getJabatan($id){
		$query = $this->db->query("SELECT a.jabatan_pegawai FROM tb_pegawai a  INNER JOIN tb_user b ON a.email_pegawai = b.email_pegawai WHERE b.id_user = '$id' ");
		return $query->result();
	}

	function getKeluhanByBulan($bulan){
		$query = $this->db->query("SELECT a.id_keluhan,a.id_speedy,b.nama_pelanggan,b.alamat_pelanggan,b.lat_pelanggan,b.ltg_pelanggan,a.ket_keluhan,c.jenis_keluhan,a.tgl_laporan,d.tgl_pengerjaan,f.tgl_kunjungan,f.status_kunjungan,e.nama_pegawai AS teknisi 
				FROM tb_keluhan a INNER JOIN tb_pelanggan b ON a.id_speedy = b.id_speedy 
				INNER JOIN tb_kat_keluhan c ON a.id_kat_keluhan = c.id_kat_keluhan 
				LEFT JOIN tb_jadwal d ON a.id_keluhan = d.id_keluhan 
				LEFT JOIN tb_pegawai e ON d.id_pegawai = e.id_pegawai 
				LEFT JOIN tb_kunjungan f ON f.id_jadwal = d.id_jadwal WHERE MONTH(f.tgl_kunjungan) = '$bulan'  
				ORDER BY a.tgl_laporan, f.tgl_kunjungan DESC");
		return $query->result();
	}

}
?>