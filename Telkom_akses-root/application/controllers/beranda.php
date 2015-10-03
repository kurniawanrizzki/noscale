<?php if(!defined("BASEPATH")) exit("TIDAK TERSEDIA"); 

class Beranda extends CI_Controller{
	
	//membentuk konstruktor
	function __construct(){
		parent::__construct();
		//load model dengan nama m_beranda
		$this->load->model('m_beranda','',TRUE);		
	}

	//function index
	function index(){
		//if season tidak bernilai is_login maka akan dikembalikan ke login/try_login
		if ($this->session->userdata('is_login')==FALSE) {
			# code...
			redirect('login/try_Login');
		}else{
			//jika ya maka akan me-direct ke halaman view beranda
			redirect('beranda/view_beranda');
		}
	}

	//view beranda digunakan untuk menampilkan beranda
	function view_beranda(){

		//mengambil data session dan mendekrasikan sebagai komponen array $data
		$user = $this->session->userdata('data_user');
		$data['pengguna']= $user;
		$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

		//menghitung pekerjaan unfinished
		$jumlah_jadwal = count($this->m_beranda->getJumlahJadwal());
		$jumlah_jadwal_by_id = count($this->m_beranda->getJumlahJadwalById($user->id_pegawai));

		if($this->session->userdata('is_login')==TRUE){
			//mendeklrasikan variable
			$data['title'] = "Beranda";
			$data['title2'] = "";
			$data['active'] = "";

			//rule untuk menambah jadwal berdasarkan jabatan pegawai
			if($user->jabatan_pegawai == 'KARYAWAN' || $user->jabatan_pegawai == 'KEPALA TEKNISI'){
				$tambah = ' / '.anchor('beranda/add_Jadwal','<span class="fa fa-plus"></span> Tambah Jadwal Baru');
			}else{
				$tambah = '';
			}

			$data['title_sub1'] = "<span class='fa fa-list'></span> Jadwal Pekerjaan Hari Ini <small>".$jumlah_jadwal." Pekerjaan".$tambah;
			$data['title_sub2'] = "<span class='fa fa-list'></span> Jadwal Pekerjaan Hari Ini <small>".$jumlah_jadwal_by_id." Pekerjaan</small>";

			//memanggil getPegawai()
			$data_pegawai= $this->m_beranda->getPegawai();
			$data['pegawai'] = $data_pegawai;

			//memuat view dengan nama file v_beranda_bar.php dan memparsing $data didalamnya
			$this->template->load('template/template_view','beranda/v_beranda_bar',$data);
		}else{
			redirect('login/try_login');
		}
	}

	//add jadwal by id digunakan untuk menambahkan jadwal
	function add_jadwal_by_id($id){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

			//ketentuan : jika jabatan pegawai adalah kepala teknisi / karuyawan maka user dapat melakukan add jadwal
			if($data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI' || $data['pengguna']->jabatan_pegawai == 'KARYAWAN'){

				$data['title'] = "Beranda";
				$data['title2'] = "Tambah Jadwal";
				$data['active'] = "";
				$data['title_sub1'] = "<span class='fa fa-plus'></span> Tambhkan Jadwal";
				$data['title_sub2'] = "";
				$data['action'] = site_url('beranda/add_jadwal_by_id/'.$id);
				$data['type'] = 'TambahById';

				$data['pegawai'] = $this->m_beranda->getPegawaiById($id);
				$data['keluhan'] = $this->m_beranda->getKeluhanBt();

				if($this->input->post('submit')){

					$item = sizeof($_POST['item']);
					for($i=0;$i<$item;$i++){
						$tgl_pengerjaan = date('Y-m-d',strtotime($_POST['tgl_pengerjaan'][$i]));
						if($_POST['cek'][$i]==''){
							$arr_data = array(
								'id_keluhan'=>$_POST['item'][$i],
								'id_pegawai'=>$data['pegawai'][0]->id_pegawai,
								'tgl_pengerjaan'=>$tgl_pengerjaan
								);				
							
							$this->m_beranda->addJadwal($arr_data);
						}else{
							if($_POST['log_ks'][$i] == '1'){
								$arr_data = array('log_ks'=>0);
								$this->m_beranda->updateKunjunganTerakhir($_POST['kunjungan'][$i],$arr_data);
								$arr_data = array('id_jadwal'=>$_POST['cek'][$i],
								'tgl_kunjungan'=>$tgl_pengerjaan);
								$this->m_beranda->addKunjungan($arr_data);
							}else if($_POST['log_j'][$i] == '0' && $_POST['kunjungan'][$i] !=''){
								$data_update1 = array('id_pegawai'=>$data['pegawai'][0]->id_pegawai,'tgl_pengerjaan'=>$tgl_pengerjaan);
								$data_update2 = array('tgl_kunjungan'=>$tgl_pengerjaan);

								$this->m_beranda->updateJadwal($_POST['cek'][$i],$data_update1);
								$this->m_beranda->updateKunjunganTerakhir($_POST['kunjungan'][$i],$data_update2);
							}else{
								$arr_data = array('id_jadwal'=>$_POST['cek'][$i],
								'tgl_kunjungan'=>$tgl_pengerjaan);
								$this->m_beranda->addKunjungan($arr_data);
							}
						}
					}
					redirect('beranda');
				}else{
					$this->template->load('template/template_view','beranda/v_beranda_iejadwal_bar',$data);
				}
			}else{
				//selain itu akan didirect ke error page
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');			
		}
	}

	//fungsi hapus jadwal 
	function hapus_jadwal($id,$id_jadwal){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;

			//ketentuan hanya diberikan ke pegawai dengan jabatan kepala teknisi dan karyawan
			if($data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI' || $data['pengguna']->jabatan_pegawai == 'KARYAWAN'){
				$cek = $this->m_beranda->selectKunjunganTerakhir($id_jadwal);
				if(count($cek)>0){
					$arr_data = array('log_ks'=>1);
					$this->m_beranda->updateKunjunganTerakhir($cek[0]->id_kunjungan,$arr_data);
				}

				$data_update1 = array('status_kunjungan'=>'TIDAK SELESAI');
				$this->m_beranda->hapusKunjungan($id,$data_update1);
				$data_update2 = array('log_j'=>1);
				$this->m_beranda->updateJadwal($id_jadwal,$data_update2);

				$slu = $this->m_beranda->selectJadwalToUpd($id_jadwal);
				$data_insert = array('id_keluhan'=>$slu[0]->id_keluhan);
				$this->m_beranda->addJadwalInHapus($data_insert);
				redirect('beranda');
			}else{
				//selain itu akan di direct ke error page
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');	
		}
	}

	// function addJadwal digunakan untuk menambahkan jadwal pengerjaan keluhan
	function add_jadwal(){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

			//fungsi ini hanya diberikan kepada kepala teknisi dan karyawan
			if($data['pengguna']->jabatan_pegawai == 'KEPALA TEKNISI' || $data['pengguna']->jabatan_pegawai == 'KARYAWAN'){
				$data['title'] = "Beranda";
				$data['title2'] = "Tambah Jadwal";
				$data['active'] = "";
				$data['title_sub1'] = "<span class='fa fa-plus'></span> Tambhkan Jadwal";
				$data['title_sub2'] = "";
				$data['action'] = site_url('beranda/add_jadwal');//ini adalah action form

				$data['type'] = 'Tambah';//identifikasi untuk membedakan form
				//model yang dipanggil pada halaman, yakni pegawai dan Keluhan yang tersedia
				$data['pegawai'] = $this->m_beranda->getPegawai();
				$data['keluhan'] = $this->m_beranda->getKeluhanBt();

				//jika tombol submit bernilai true maka akan menginsert data jadwal
				if($this->input->post('submit')){

					$item = sizeof($_POST['item']);
					for($i=0;$i<$item;$i++){
						$tgl_pengerjaan = date('Y-m-d',strtotime($_POST['tgl_pengerjaan'][$i]));
						if($_POST['cek'][$i]==''){
							$arr_data = array(
								'id_keluhan'=>$_POST['item'][$i],
								'id_pegawai'=>$_POST['id_pegawai'],
								'tgl_pengerjaan'=>$tgl_pengerjaan
								);				
							
							$this->m_beranda->addJadwal($arr_data);
						}else{
							if($_POST['log_ks'][$i] == '1'){
								$arr_data = array('log_ks'=>0);
								$this->m_beranda->updateKunjunganTerakhir($_POST['kunjungan'][$i],$arr_data);
								$arr_data = array('id_jadwal'=>$_POST['cek'][$i],
								'tgl_kunjungan'=>$tgl_pengerjaan);
								$this->m_beranda->addKunjungan($arr_data);
							}else if($_POST['log_j'][$i] == '0' && $_POST['kunjungan'][$i] !=''){
								$data_update1 = array('id_pegawai'=>$_POST['id_pegawai'],'tgl_pengerjaan'=>$tgl_pengerjaan);
								$data_update2 = array('tgl_kunjungan'=>$tgl_pengerjaan);

								$this->m_beranda->updateJadwal($_POST['cek'][$i],$data_update1);
								$this->m_beranda->updateKunjunganTerakhir($_POST['kunjungan'][$i],$data_update2);
							}else{
								$arr_data = array('id_jadwal'=>$_POST['cek'][$i],
								'tgl_kunjungan'=>$tgl_pengerjaan);
								$this->m_beranda->addKunjungan($arr_data);
							}
						}
					}
					redirect('beranda');
				}else{
					$this->template->load('template/template_view','beranda/v_beranda_iejadwal_bar',$data);
				}
			}else{
				redirect('errors/page_missing');
			}
		}else{
			redirect('login/try_login');			
		}
	}
}
?>