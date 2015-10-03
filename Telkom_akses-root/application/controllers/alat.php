<?php  if(!defined('BASEPATH')) exit("TIDAK TERSEDIA");

class Alat extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->library(array('table','form_validation','session'));
		$this->load->model('m_alat','',TRUE);
		$this->load->model('m_beranda','',TRUE);
	}

	function index(){
		//if season tidak bernilai is_login maka akan dikembalikan ke login/try_login
		if ($this->session->userdata('is_login')==FALSE) {
			# code...
			redirect('login/try_login');
		}else{
			//jika ya maka akan me-direct ke halaman view alat
			redirect('alat/view_alat');
		}
	}

	function view_alat($bulan = 'MONTH(CURDATE())',$tahun = 'YEAR(CURDATE())'){
		$user = $this->session->userdata('data_user');
		$data['pengguna']= $user;
		$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

		if($this->session->userdata('is_login') == TRUE){
			$data['title'] = "Alat";
			$data['title2'] = "Evaluasi";
			$data['active'] = "";
			$data['title_sub1'] = "<span class='fa bar-chart-o'></span> Evaluasi ";
			$data['title_sub2'] = "";
			$evaluasi_pegawai = $this->m_alat->getEvaluasiPegawai($bulan,$tahun);
			$evaluasi_keluhan = $this->m_alat->getEvaluasiKeluhan($bulan,$tahun);
			$data['evakeluhan'] = $evaluasi_keluhan;
			$data['evapegawai'] = $evaluasi_pegawai;

			$this->template->load('template/template_view','alat/v_alat_evaluasi_bar',$data);
		}else{
			redirect('login/try_login');
		}
	}

	function view_riwayat_evaluasi($id,$bulan,$tahun){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;

			$riwayat = $this->m_alat->getRiwayatById($id,$bulan,$tahun);
			echo json_encode($riwayat);
		}else{
			redirect('login/try_login');
		}
	}

	function kelola_pengguna(){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

			if ($user->jabatan_pegawai == 'KEPALA TEKNISI' || $user->jabatan_pegawai == 'MANAGER') {
				# code...
				$penggunax = $this->m_alat->getUser($user->id_pegawai);
				$data['penggunay'] = $penggunax;
				$data['title'] = "Alat";
				$data['title2'] = "Kelola Pengguna";
				$data['active'] = "";

				$data['title_sub1'] = "<span class='glyphicon glyphicon-user'></span> Kelola Pengguna";
				$data['title_sub2'] = "";

				$this->template->load('template/template_view','alat/v_alat_kelolauser_bar',$data);
			}else{
				redirect("errors/page_missing");
			}
		}else{
			redirect('login/try_login');
		}
	}

	function monitoring($id,$bulan = ''){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			
			if($bulan == ''){
				$bulan = date('m');
				$login = $this->m_alat->getLoginByIdPerbulan($id,$bulan);
			}else{
				if($bulan == '0'){
					$login = $this->m_alat->getLoginById($id);		
				}else{
					$login = $this->m_alat->getLoginByIdPerbulan($id,$bulan);
				}
			}
			echo json_encode($login);
		}else{
			redirect('login/try_login');			
		}
	}

	function default_password($id){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;

			$userData = $this->m_alat->getUserById($id);
			$getJabatan = $this->m_alat->getJabatan($id);

			if($data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI'){
				if($getJabatan[0]->jabatan_pegawai == 'TEKNISI'){
					foreach ($userData as $us) {
						# code...
						$xemail  = explode('@',strtolower($us->email_pegawai));
						$pass = md5(strtoupper($xemail[0]));
						$arr_data = array('password'=>$pass);
						$this->m_alat->ubahPasswordOrGrant($id,$arr_data);
						redirect('alat/kelola_pengguna');
					}
				}else{
					redirect('alat/kelola_pengguna');
				}
			}else if($data['pengguna']->jabatan_pegawai == 'MANAGER'){
				foreach ($userData as $us) {
					# code...
					$xemail  = explode('@',strtolower($us->email_pegawai));
					$pass = md5(strtoupper($xemail[0]));
					$arr_data = array('password'=>$pass);
					$this->m_alat->ubahPasswordOrGrant($id,$arr_data);
					redirect('alat/kelola_pengguna');
				}
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	function grant_user($id){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;

			$userData = $this->m_alat->getUserById($id);
			$getJabatan = $this->m_alat->getJabatan($id);
			if($data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI'){
				if($getJabatan[0]->jabatan_pegawai == 'TEKNISI'){
					foreach ($userData as $us) {
						# code...
						$arr_data = array('grant_status'=>$us->grant_status == 'OFF'?'ON':'OFF');
					}
					$this->m_alat->ubahPasswordOrGrant($id,$arr_data);
					redirect('alat/kelola_pengguna');
				}else{
					redirect('alat/kelola_pengguna');
				}
			}else if($data['pengguna']->jabatan_pegawai == 'MANAGER'){
				foreach ($userData as $us) {
					# code...
					$arr_data = array('grant_status'=>$us->grant_status == 'OFF'?'ON':'OFF');
				}
				$this->m_alat->ubahPasswordOrGrant($id,$arr_data);
				redirect('alat/kelola_pengguna');
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}


	function kelola_keluhan(){
		$user = $this->session->userdata('data_user');
		$data['pengguna']= $user;
		$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

		if($this->session->userdata('is_login')==TRUE){
			if($data['pengguna']->jabatan_pegawai == 'KARYAWAN' || $data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI' || $data['pengguna']->jabatan_pegawai == 'MANAGER'){
				$data['title_sub1'] = "<span class='fa fa-ticket'></span> Daftar Keluhan";
				$data['title_sub2'] = "";
				$data['title'] = "Alat";
				$data['title2'] = "Kelola Keluhan";
				$data['active'] = "";

				$keluhan_unfinul = $this->m_alat->getKeluhanUnfinul();
				$keluhan_hari_ini = $this->m_alat->getKeluhanHariIni();

				$data['tot_unfinul'] = count($keluhan_unfinul);
				$data['tot_hari_ini'] = count($keluhan_hari_ini);
				$data['keluhan_UF'] = $keluhan_unfinul;
				$data['keluhan_HI'] = $keluhan_hari_ini;

				$this->template->load('template/template_view','alat/v_alat_kelolakeluhan_bar',$data);
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	function view_keluhan($bulan = '0'){
		$user = $this->session->userdata('data_user');
		$data['pengguna']= $user;
		$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

		if($this->session->userdata('is_login')==TRUE){
			if($data['pengguna']->jabatan_pegawai == 'KARYAWAN' || $data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI' || $data['pengguna']->jabatan_pegawai == 'MANAGER'){
				if($bulan == '0'){
					$keluhan = $this->m_alat->getKeluhan();
				}else{
					$keluhan = $this->m_alat->getKeluhanByBulan($bulan);
				}
				$arr_data = array('k'=>$keluhan,'jabatan'=>$user);
				echo json_encode($arr_data);
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	function cari_data_pelanggan(){
		if($this->session->userdata){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

			if($data['pengguna']->jabatan_pegawai == 'KARYAWAN' || $data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI'){
				$data['link_back'] = anchor('alat/kelola_keluhan','Kembali Ke Data Keluhan',array('class'=>'add'));
				$data['action'] = site_url('alat/cari_data_pelanggan');
				$data['title'] = "Alat";
				$data['title2'] = "Kelola Keluhan";
				$data['active'] = "Tambah Keluhan";
				$data['title_sub1'] = "<span class='fa bar-chart-o'></span> Tambah Keluhan ";
				$data['title_sub2'] = "";

				$data['pelanggan'] = $this->m_alat->getPelanggan();

				$this->template->load('template/template_view','alat/v_alat_cdpengeluh_bar',$data);

			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	function View_To_Insert_Keluhan($id){
		if($this->session->userdata('is_login')){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

			if($data['pengguna']->jabatan_pegawai == 'KARYAWAN' || $data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI'){
				$data['title'] = "Alat";
				$data['title2'] = "Kelola Keluhan";
				$data['active'] = "Tambah Keluhan";
				$data['title_sub1'] = "<span class='fa bar-chart-o'></span> Tambah Keluhan ";
				$data['title_sub2'] = "";
				$data['link_back'] = anchor('alat/cariDataPelanggan','Kembali Ke Data Keluhan',array('clas'=>'add'));
				$data['action'] = site_url('alat/view_to_insert_keluhan/'.$id);
				$data['type'] = 'TAMBAH';
				$gpelanggan = $this->m_alat->getPelangganById($id);
				$data['pelanggan'] = $gpelanggan;
				$data['kategori'] = $this->m_alat->getKategori();
				foreach ($gpelanggan as $gp) {
					# code...
					$data['jalur'] = $this->m_alat->getJalur($gp->id_dp);
				}

				if($this->input->post('submit')){
					$arr_data = array(
								'id_speedy'=>$this->input->post('id_speedy'),
								'ket_keluhan'=>$this->input->post('ket_keluhan'),
								'id_kat_keluhan'=>$this->input->post('kat_keluhan'),
								'tgl_laporan'=>date("Y-m-d H:i:s")
								);
					$this->m_alat->insertKeluhan($arr_data);
					redirect('alat/kelola_keluhan');
				}else{
					$this->template->load('template/template_view','alat/v_alat_iekeluhan_bar',$data);
				}
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	function update_keluhan($id){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);
			
			if($data['pengguna']->jabatan_pegawai == 'KARYAWAN' || $data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI'){
				$data['title'] = "Alat";
				$data['title2'] = "Kelola Keluhan";
				$data['active'] = "Tambah Keluhan";
				$data['title_sub1'] = "<span class='fa bar-chart-o'></span> Edit Keluhan ";
				$data['link_back'] = anchor('alat/kelola_keluhan','Kembali Ke Data Keluhan',array('clas'=>'add'));
				$data['action'] = site_url('alat/update_keluhan/'.$id);
				$data['type'] = 'EDIT';
				$gpelanggan = $this->m_alat->getDataKeluhanById($id);
				$data['pelanggan'] = $gpelanggan;
				foreach ($gpelanggan as $gp) {
					# code...
					$data['kategori'] = $this->m_alat->getKategoriNd($gp->id_kat_keluhan);
					$data['jalur'] = $this->m_alat->getJalur($gp->id_dp);
				}

				if($this->input->post('submit')){
					$arr_data = array(
								'ket_keluhan'=>$this->input->post('ket_keluhan'),
								'id_kat_keluhan'=>$this->input->post('kat_keluhan'),
								);
					$this->m_alat->updateKeluhan($id,$arr_data);
					redirect('alat/kelola_keluhan');
				}else{
					$this->template->load('template/template_view','alat/v_alat_iekeluhan_bar',$data);
				}
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');			
		}
	}

	function delete_keluhan($id){
		if($this->session->userdata('is_login')){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;

			if($data['pengguna']->jabatan_pegawai == 'KARYAWAN' || $data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI'){
				$this->m_alat->hapusKeluhan($id);
				redirect('alat/kelola_keluhan');
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');			
		}
	}

	function view_detail_keluhan($id){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			
			echo json_encode($data['pelanggan'] = $this->m_alat->getDataKeluhanById($id));
		}else{
			redirect('login/try_login');	
		}
	}

	function getChartKeluhan($bulan = 'MONTH(CURDATE())',$tahun = 'YEAR(CURDATE())'){
		if($this->session->userdata('is_login') == TRUE){
			$evaluasi_keluhan = $this->m_alat->getEvaluasiKeluhan($bulan,$tahun);

			$data_json = array();
			foreach ($evaluasi_keluhan as $ek) {
				# code...
				$json_array['label'] = $ek->jenis_keluhan;
				$json_array['value'] = $ek->jml_keluhan;
				array_push($data_json, $json_array);
				
			}
			echo json_encode($data_json);
		}else{
			redirect('login/try_login');
		}
	}

	function getChartPegawai($bulan = 'MONTH(CURDATE())',$tahun = 'YEAR(CURDATE())'){
		if($this->session->userdata('is_login') == TRUE){
			$evaluasi_pegawai = $this->m_alat->getEvaluasiPegawai($bulan,$tahun);

			$data_json = array();
			foreach ($evaluasi_pegawai as $ep) {
				$json_array['y'] = $ep->nama_pegawai;
				$json_array['a'] = $ep->jml_f;
				$json_array['b'] = $ep->jml_uf;
				$json_array['c'] = $ep->jml_t;
				array_push($data_json, $json_array);
			}
			echo json_encode($data_json);
		}else{
			redirect('login/try_login');			
		}
	}

	function getDataEvaluasi($bulan = 'MONTH(CURDATE())',$tahun = 'YEAR(CURDATE())'){
		if($this->session->userdata('is_login') == TRUE){
			$evaluasi_pegawai = $this->m_alat->getEvaluasiPegawai($bulan,$tahun);
			$evaluasi_keluhan = $this->m_alat->getEvaluasiKeluhan($bulan,$tahun);

			$arr_data = array('ek'=>$evaluasi_keluhan,'ep'=>$evaluasi_pegawai);
			echo json_encode($arr_data);
		}else{
			redirect('login/try_login');			
		}
	}
}
?>