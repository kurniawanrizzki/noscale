<?php if(!defined("BASEPATH")) exit("AKSES TIDAK TERSEDIA"); 

class Tentang extends CI_Controller{

	//membentuk construct
	function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form'));
		$this->load->model('m_beranda','',TRUE);
		$this->load->library(array('table','form_validation','session'));	
	}

	//function index sebagai default
	function index(){
		//if season tidak bernilai is_login maka akan dikembalikan ke login/try_login
		if ($this->session->userdata('is_login')==FALSE) {
			# code...
			redirect('login/try_login');
		}else{
			//jika ya maka akan me-direct ke halaman view beranda
			redirect('tentang/view_tentang');
		}
	}

	function view_tentang(){
		if($this->session->userdata('is_login') == TRUE){
			$user = $this->session->userdata('data_user');
			$data['pengguna']= $user;
			$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);

			$data['title_sub1'] = "<span class='fa fa-columns'></span> Tentang Telkom Akses";
			$data['title_sub2'] = "";
			$data['title'] = "Tentang";
			$data['title2'] = "";
			$data['active'] = "";

			// $this->load->library('table');
			// $this->table->set_empty('&nbsp;');
			// $this->table->add_row('PT. Telkom Akses (PTTA) merupakan anak perusahaan PT Telekomunikasi Indonesia, Tbk (Telkom) yang sahamnya dimiliki sepenuhnya oleh Telkom. PTTA bergerak dalam bisnis penyediaan layanan konstruksi dan pengelolaan infrastruktur jaringan.');
			// $this->table->add_row('<img src='.base_url().'assets/thumbnails/telkom_akses1.jpg>');
			// $this->table->add_row('Pendirian PTTA merupakan bagian dari komitmen Telkom untuk terus melakukan pengembangan jaringan broadband untuk menghadirkan akses informasi dan komunikasi tanpa batas bagi seluruh masyarakat indonesia. Telkom berupaya menghadirkan koneksi internet berkualitas dan terjangkau untuk meningkatkan kualitas sumber daya manusia sehingga mampu bersaing di level dunia. Saat ini Telkom tengah membangun jaringan backbone berbasis Serat Optik maupun Internet Protocol (IP) dengan menggelar 30 node terra router dan sekitar 75.000 Km kabel Serat Optik. Pembangunan kabel serat optik merupakan bagian dari program Indonesia Digital Network (IDN) 2015. Sebagai bagian dari strategi untuk mengoptimalkan layanan nya, Telkom mendirikan PT. Telkom Akses.

			// Kehadiran PTTA diharapkan akan mendorong pertumbuhan jaringan akses broadband di indonesia. Selain Instalasi jaringan akses broadband, layanan lain yang diberikan oleh PT. Telkom Akses adalah Network Terminal Equipment (NTE), serta Jasa Pengelolaan Operasi dan Pemeliharaan (O&M – Operation & Maintenance) jaringan Akses Broadband.');
			$this->template->load('template/template_view','tentang/v_tentang_bar',$data); 
		}else{
			redirect('tentang/view_tentang');			
		}
	}
}
?>