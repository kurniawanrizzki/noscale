<?php if(!defined("BASEPATH")) exit("AKSES TIDAK TERSEDIA");

class Data extends CI_Controller{
	var $gallery_path;
	var $gallery_path_url;
	//membentuk konstruktor
	function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','html'));
		$this->load->library(array('table','form_validation','googlemaps','session'));
		$this->load->model('m_data','',TRUE);
		$this->load->model('m_beranda','',TRUE);
		$this->gallery_path = realpath(APPPATH . '../assets/images');
		$this->gallery_path_url = base_url() . 'assets/images';	
	}

	//function index sebagai default
	function index(){
		//if season tidak bernilai is_login maka akan dikembalikan ke login/try_login
		if ($this->session->userdata('is_login')==FALSE) {
			# code...
			redirect('login/try_login');
		}else{
			//jika ya maka akan me-direct ke halaman view
			redirect('data/view_data');
		}
	}

	//digunakan view data untuk menampilkan data data pegawai
	function view_data(){
		//mengambil data session dan mendekrasikan sebagai komponen array $data
		$user = $this->session->userdata('data_user');
		$data['pengguna']= $user;
		$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

		//jika session bernilai true
		if($this->session->userdata('is_login')==TRUE){
			//deklarasi variable yang digunakan pada template
			$data['title_sub1'] = "<span class='fa fa-users'></span> Daftar Kepegawaian";
			$data['title_sub2'] = "";
			$data['title'] = "Data";
			$data['title2'] = "Data Pegawai";
			$data['active'] = "";

			//method yang digunakan dalam memanggil pegawai
			$all_pegawai = $this->m_data->getDataPegawai();
			$data['pegawai'] = $all_pegawai;

			//load view
			$this->template->load('template/template_view','data/v_data_pegawai_bar',$data);
		}else{
			redirect('login/try_login');
		}
	}

	//function addPegawai
	function add_Pegawai(){
		if($this->session->userdata('is_login')== TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);	

			//add pegawai hanya diberikan kepada manager dan kepala teknisi
			if($data['pengguna']->jabatan_pegawai == 'MANAGER' || $data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI'){
				//deklarasi variable
				$data['title_sub1'] = "<span class='fa fa-users'></span> Tambah Pegawai";
				$data['title_sub2'] = "";
				$data['title'] = "Data";
				$data['title2'] = "Pegawai";
				$data['active'] = 'Tambah Pegawai';
				$data['action'] = site_url('data/add_pegawai');
				$data['type'] ='TAMBAH';

				//jika submit maka akan berhasil menyimpan semua data pegawai
				if($this->input->post('submit')){
					
					$arr_data = array('id_pegawai'=>strtoupper($this->input->post('id_pegawai')),
								'nama_pegawai'=>strtoupper($this->input->post('nama_pegawai')),
								'jabatan_pegawai'=>strtoupper($this->input->post('jabatan_pegawai')),
								'alamat_pegawai'=>strtoupper($this->input->post('alamat_pegawai')),
								'email_pegawai'=>strtoupper($this->input->post('email_pegawai')),
								'telp_hp_pegawai'=>strtoupper($this->input->post('telp_hp_pegawai'))
								);

					//set default password
					$password = explode('@',$this->input->post('email_pegawai'));
					//array data user
					$arr_user = array('email_pegawai'=>strtoupper($this->input->post('email_pegawai')),
								'password'=>md5(strtoupper($password[0]))
								);

					//load semua function yang digunakan untuk insert
					$this->m_data->insertPegawai($arr_data);
					$this->m_data->insertUser($arr_user);
					redirect('data');
				}else{
					$this->template->load('template/template_view','data/v_data_iepegawai_bar',$data);
				}
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	//function update pegawai
	function update_pegawai($id){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);
			$data['title_sub1'] = "<span class='fa fa-users'></span> Edit Pegawai";
			$data['title_sub2'] = "";
			$data['title'] = "Data";
			$data['title2'] = "Pegawai";
			$data['active'] = 'Edit Pegawai';
			$data['type'] = 'EDIT';
			$data['action'] = ('data/update_pegawai/'.$id);
			//get pegawai berdasarkan id
			$data['pegawai'] = $this->m_data->getPegawaiById($id);
			$cekJabatan = $this->m_data->cekJabatan($id);

			//hanya diberikan kepada manager dan kepala teknisi
			if($data['pengguna']->jabatan_pegawai == 'MANAGER'){

				if($this->input->post('submit')){
					
					//array data pegawai
					$arr_data = array(
								'nama_pegawai'=>strtoupper($this->input->post('nama_pegawai')),
								'jabatan_pegawai'=>strtoupper($this->input->post('jabatan_pegawai')),
								'alamat_pegawai'=>strtoupper($this->input->post('alamat_pegawai')),
								'telp_hp_pegawai'=>strtoupper($this->input->post('telp_hp_pegawai'))
								);

					//set default password
					$password = explode('@',$this->input->post('email_pegawai'));
					//array data user
					$arr_user = array('email_pegawai'=>strtoupper($this->input->post('email_pegawai')),
								'password'=>md5(strtoupper($password[0]))
								);

					//model to update
					$this->m_data->updatePegawai($id,$arr_data);
					redirect('data');
					
				}else{
					$this->template->load('template/template_view','data/v_data_iepegawai_bar',$data);
				}

			}else if($data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI'){
				if($cekJabatan[0]->jabatan_pegawai != 'TEKNISI'){
					redirect('errors/page_missing');
				}else{
					if($this->input->post('submit')){
						
						//array data pegawai
						$arr_data = array(
									'nama_pegawai'=>strtoupper($this->input->post('nama_pegawai')),
									'jabatan_pegawai'=>strtoupper($this->input->post('jabatan_pegawai')),
									'alamat_pegawai'=>strtoupper($this->input->post('alamat_pegawai')),
									'telp_hp_pegawai'=>strtoupper($this->input->post('telp_hp_pegawai'))
									);

						//set default password
						$password = explode('@',$this->input->post('email_pegawai'));
						//array data user
						$arr_user = array('email_pegawai'=>strtoupper($this->input->post('email_pegawai')),
									'password'=>md5($password[0])
									);

						//model to update
						$this->m_data->updatePegawai($id,$arr_data);
						redirect('data');
						
					}else{
						$this->template->load('template/template_view','data/v_data_iepegawai_bar',$data);
					}
				}
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	//function delete pegawai
	function delete_pegawai($id){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			//delete hanya diberikan  pada manager dan kepala teknisi
			if($data['pengguna']->jabatan_pegawai == 'MANAGER' || $data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI'){
				//method delete pegawai
				$this->m_data->deletePegawai($id);
				redirect('data');
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	//function detail pegawai
	function detail_pegawai($id){
		//encode to json data pegawai
		if($this->session->userdata('is_login') == TRUE){
			$detailP = $this->m_data->getPegawaiById($id);
			echo json_encode($detailP);
		}else{
			redirect('login/try_login');		
		}
	}


	//function pelangan 
	function Pelanggan(){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);
			
			//cek login atau tidak
			if($this->session->userdata('is_login') == TRUE){
				
				$data['title_sub1'] = "<span class='fa fa-tags'></span> Daftar Pelanggan";
				$data['title_sub2'] = "";

				$data['title'] = "Data";
				$data['title2'] = "Data Pelanggan";
				$data['active'] = "";
				
				$all_pelanggan = $this->m_data->getDatapelanggan();
				$data['pelanggan'] = $all_pelanggan;

				$this->template->load('template/template_view','data/v_data_pelanggan_bar',$data); 
			}else{
				redirect('login/try_login');
			}
		}else{
			redirect('login/try_login');
		}
	}


	//function addPelanggan
	function add_pelanggan(){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

			//hanya diberikan untuk kepala teknisi dan karyawan
			if($data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI' || $data['pengguna']->jabatan_pegawai == 'KARYAWAN'){
				$data['title_sub1'] = "<span class='fa fa-tags'></span> Tambah Pelanggan";
				$data['title_sub2'] = "";

				$data['title'] = "Data";
				$data['title2'] = "Pelanggan";
				$data['active'] = "Tambah Pelanggan";
				$data['dataJalur'] = $this->m_data->getDataJalur();
				$data['type'] ='TAMBAH';
				$data['action'] = site_url('data/add_pelanggan');

				if($this->input->post('submit')){
					$lokasi = get_lat_long($this->input->post('alamat_pelanggan'));
					$map = explode(',', $lokasi);
					$mapLat = $map[0];
					$mapLtg = $map[1];
					$arr_dataPelanggan = array(
						'id_speedy'=>$this->input->post('id_speedy'),
						'id_dp'=>$this->input->post('id_dp'),
						'nama_pelanggan'=>strtoupper($this->input->post('nama_pelanggan')),
						'alamat_pelanggan'=>strtoupper($this->input->post('alamat_pelanggan')),
						'lat_pelanggan'=>$mapLat,
						'ltg_pelanggan'=>$mapLtg,
						'telp_hp_pelanggan'=>$this->input->post('telp_hp_pelanggan'),
						'telp_rumah_pelanggan'=>$this->input->post('telp_rumah_pelanggan')
					);
					$this->m_data->insertPelanggan($arr_dataPelanggan);
					redirect('data/pelanggan');
				}else{
					$this->template->load('template/template_view','data/v_data_iepelanggan_bar',$data);
				}
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	//function update pelanggan
	function update_pelanggan($id){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

			//hanya diberikan kepada kepala teknisi, karywan, dan teknisi
			if($data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI' || $data['pengguna']->jabatan_pegawai == 'KARYAWAN' || $data['pengguna']->jabatan_pegawai == 'TEKNISI'){
				$data['title_sub1'] = "<span class='fa fa-tags'></span> Edit Pelanggan";
				$data['title_sub2'] = "";

				$data['title'] = "Data";
				$data['title2'] = "Pelanggan";
				$data['active'] = "Edit Pelanggan";
				$data['type'] = 'EDIT';
				$data['action'] = ('data/update_pelanggan/'.$id);
				$data['link_back'] = anchor('data/pelanggan','Kembali Ke Data Pelanggan',array('class'=>'back'));
				$data['pelanggan'] = $this->m_data->getpelangganById($id);
				$pelanggan= $data['pelanggan'];
				foreach ($pelanggan as $p) {
					# code...
					$data['dataJalur'] = $this->m_data->dataJalurNotById($p->id_dp); 
				}

				$getPelanggan = $this->m_data->getPelangganById($id);
				if($getPelanggan[0]->status_pelanggan == 'ON'){
					if($this->input->post('submit')){
						$lokasi = get_lat_long($this->input->post('alamat_pelanggan'));
						$map = explode(',', $lokasi);
						$mapLat = $map[0];
						$mapLtg = $map[1];
						if($data['pengguna']->jabatan_pegawai != 'TEKNISI'){
							$arr_dataPelanggan = array(
								'id_dp'=>$this->input->post('id_dp'),
								'nama_pelanggan'=>strtoupper($this->input->post('nama_pelanggan')),
								'alamat_pelanggan'=>strtoupper($this->input->post('alamat_pelanggan')),
								'lat_pelanggan'=>$mapLat,
								'ltg_pelanggan'=>$mapLtg,
								'telp_hp_pelanggan'=>$this->input->post('telp_hp_pelanggan'),
								'telp_rumah_pelanggan'=>$this->input->post('telp_rumah_pelanggan')
							);
						}else{
							$arr_dataPelanggan = array(
								'id_dp'=>$this->input->post('id_dp'),
								'nama_pelanggan'=>strtoupper($this->input->post('nama_pelanggan')),
								'alamat_pelanggan'=>strtoupper($this->input->post('alamat_pelanggan')),
								'lat_pelanggan'=>$mapLat,
								'ltg_pelanggan'=>$mapLtg,
								'telp_hp_pelanggan'=>$this->input->post('telp_hp_pelanggan')
							);
						}
						$this->m_data->updatePelanggan($id,$arr_dataPelanggan);
						redirect('data/pelanggan');
					}else{
						$this->template->load('template/template_view','data/v_data_iepelanggan_bar',$data);
					}
				}else{
					redirect('errors/page_missing');
				}
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	//function delete pelanggan
	function delete_pelanggan($id){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;

			if($data['pengguna']->jabatan_pegawai == 'KARYAWAN' || $data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI'){
				$this->m_data->deletePelanggan($id);
				redirect('data/pelanggan');
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	function changeStatusPelanggan($id){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');

			$getPelanggan = $this->m_data->getPelangganById($id);
			if($user->jabatan_pegawai != 'MANAGER'){
				$arr_data = array('status_pelanggan'=>$getPelanggan[0]->status_pelanggan == 'OFF'?'ON':'OFF');
				$this->m_data->updatePelanggan($id,$arr_data);
				redirect('data/pelanggan');
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');
		}
	}

	//function detail pelanggan
	function detail_pelanggan($id){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;

			echo json_encode($data['pelanggan'] = $this->m_data->getpelangganById($id));
		}else{
			redirect('login/try_login');
		}
	}

	function riwayat_pegawai_by_id($id,$bulan=''){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;


			if($bulan == ''){
				$bulan = date('m');
				$riwayat = $this->m_data->getRiwayatPerUserBulanan($id,$bulan);
				$totalUF = count($this->m_data->getTotUFPerUserBulanan($id,$bulan));	
			}else{
				if($bulan == '0'){
					$riwayat = $this->m_data->getRiwayatPerUser($id);
					$totalUF = count($this->m_data->getTotUFPerUser($id));	
				}else{
					$riwayat = $this->m_data->getRiwayatPerUserBulanan($id,$bulan);
					$totalUF = count($this->m_data->getTotUFPerUserBulanan($id,$bulan));
				}
			}
			$data_arr = array('datPegawai'=>$riwayat,'datTotUF'=>$totalUF);
			echo json_encode($data_arr);
		}else{
			redirect('login/try_login');			
		}
	}

	function checkIdPE($id_p){
		if($this->session->userdata('is_login') == TRUE){
			$check = $this->m_data->checkIdPegawai($id_p);
			echo json_encode($check);
		}else{
			redirect('login/try_login');			
		}
	}

	function checkEmPE($email_p){
		if($this->session->userdata('is_login') == TRUE){
			$check = $this->m_data->checkEmailPegawai($email_p);
			echo json_encode($check);
		}else{
			redirect('login/try_login');				
		}
	}

	function checkIdPel($id_p){
		if($this->session->userdata('is_login') == TRUE){
			$check = $this->m_data->checkIdPelanggan($id_p);
			echo json_encode($check);
		}else{
			redirect('login/try_login');
		}
	}

}

function get_lat_long($address){

    $address = str_replace(" ", "+", $address);

    $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
    return $lat.','.$long;
}


?>