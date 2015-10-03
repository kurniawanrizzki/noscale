<?php 
if(!defined('BASEPATH')) exit('TIDAK TERSEDIA');

class Login extends CI_Controller{

	//konstruktor dalam controller login
	function __construct(){
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->model('m_login','',TRUE);		
	}

	//index 
	function index(){
		//session start
		$session = $this->session->userdata('is_login');

		//jika session bernilai false, dalam hal ini jika tidak bernilai 'is_login',akan di direct di halaman login
		//jika session bernilai true, akan di direct ke halaman beranda
		if($session == FALSE){
			redirect('login/try_login');
		}else{
			redirect('beranda');
		}
	}

	//function try login digunakan sebagai dalam halaman login
	function try_login(){
		//deklarasi variabel yang di pass ke view v_login_bar.php
		$data['title'] = 'TAM'; //title
		$data['error']=''; //error
		$data['action'] = site_url('login/try_Login');//$action adalah action yang digunakan form pada halaman login

		//rule validation dengan library yang disediakan CI
		$rules = array(
					array('field'=>'email_pegawai',
						'label'=>'Email Pegawai',
						'rules'=>'required|trim|xss_clean|email'
						),
					array('field'=>'password',
						'label'=>'Password',
						'rules'=>'required')
				);

		$this->form_validation->set_rules($rules);
		//end rule validation

		//jika form validation bernilai FALSE maka akan dikembalikan ke halaman login, dengan menampilkan error text
		if($this->input->post('submit')){
			if($this->form_validation->run()==FALSE){
				$this->load->view('login/v_login_bar',$data);
			}else{
				
				//$data jadwal adalah fungsi yang digunakan untuk meng - update semua jadwal dengan status unfinished pada hari kemarin
				$dataJadwal = $this->m_login->selectJadwalUnfinished();

				if(count($dataJadwal) > 0){

					date_default_timezone_set("Asia/Jakarta");
					foreach ($dataJadwal as $dj) {
						#code...
						$arr_data = array('id_jadwal'=>$dj->id_jadwal,'tgl_kunjungan'=>date('Y-m-d'));
						$this->m_login->insertRepeatKunjungan($arr_data);

						$arr_change = array('status_kunjungan'=>'TIDAK SELESAI');
						$this->m_login->updateKunjunganMenunggu($dj->id_kunjungan,$arr_change);
					}
				}
				//end fungsi $data jadwal

				//field pada form login, yaitu email pegawai dan password 
				$email = $this->input->post('email_pegawai');
				$password = strtoupper($this->input->post('password'));
				$xpas = md5($password);

				//fungsi yang digunkan untuk mencocokan email dan password user
				$loginUser = $this->m_login->loginUser($email,$xpas);

				//jika hasil dari fungsi bernilai TRUE dan Grant Status Bernilai ON maka user akan di direct ke halaman beranda
				//jika tidak maka akan muncul text error di halaman login, jika memang salah maka user akan diperintah untuk memeriksa email dan password,
				//tapi jika akun user belum diaktivasi maka pesan error yang keluar adalah aktivasi akun
				if(count($loginUser) <>0){
				foreach ($loginUser as $login) {
					# code...
					if($login->grant_status == 'ON'){					
						$this->session->set_userdata('is_login',TRUE);
						$this->session->set_userdata('data_user',$login);
						date_default_timezone_set("Asia/Jakarta");
						$login_time = date('Y-m-d H:i:s');

						//array variable yang digunakan dalam insert waktu login dengan waktu logout null
						$arr_data = array('id_user'=>$login->id_user,
									'login'=>$login_time);

						//digunakan untuk insert waktu login user
						$this->m_login->insertWhenLogin($arr_data);
						redirect('beranda');
					}else{
						//login akan error jika belum diaktivasi, dan diminta untuk menghubungi kepala teknisi
						$data['error'] = 'Your account need activation, please contact your administrator';
						$this->load->view('login/v_login_bar',$data);
					}
				}
				}else{
					$data['error'] = 'Email and password account dont match';
					$this->load->view('login/v_login_bar',$data);
				}
			}
		}else{
			//digunakan untuk mendirect ke halaman login
			$this->load->view('login/v_login_bar',$data);
		}
	}

	//function logout ini digunakan untuk keluar dari sistem dan akan menyimpan waktu logout
	function logout($id){
		if($this->session->userdata('is_login') == TRUE){
			//set waktu asia/jakarta
			date_default_timezone_set("Asia/Jakarta");
			$logout_time = date('Y-m-d H:i:s');
			//mengambil id login user yang akan diupdate waktu logoutnya
			$log = $this->m_login->ambilLastLogin($id);
			foreach ($log as $l) {
				# code...
				//array variable yang digunakan untuk meng - update waktu logout
				$arr_data  = array('id_user'=>$l->id_user,
							'logout'=>$logout_time);

				//function yang digunkan untuk meng - update waktu logout
				$this->m_login->updateWhenLogout($l->id_login,$arr_data);
			}

			//session destroy yang akn me-direct ke halaman login	
			$this->session->sess_destroy();
			redirect('login/try_login');
		}else{
			redirect('login/try_login');			
		}
	}

}
?>