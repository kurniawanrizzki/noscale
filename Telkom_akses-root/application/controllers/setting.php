<?php  if(!defined('BASEPATH')) exit('AKSES TIDAK TERSEDIA');

class setting extends CI_Controller{
	var $gallery_path;
	var $gallery_path_url;
	//membentuk konstruktor
	function __construct(){
		parent::__construct();
		$this->load->helper(array('url','form','html'));
		$this->load->library(array('form_validation','session'));
		$this->load->model('m_setting','',TRUE);
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
			redirect('setting/view_setting');
		}
	}

	function view_setting(){
		$user = $this->session->userdata('data_user');
		$data['pengguna']= $user;
		$data['imgPegawai'] = $this->m_beranda->getImage($user->id_pegawai);
		//if season tidak bernilai is_login maka akan dikembalikan ke login/try_login
		if ($this->session->userdata('is_login')==FALSE) {
			# code...
			redirect('login/try_login');
		}else{
			//jika ya maka akan me-direct ke halaman view

			$data['action'] = site_url('setting/change_info_profil');
			
			$data['title_sub1'] = "<span class='fa fa-gear'></span> Sunting Profil";
			$data['title_sub2'] = "";
			$data['title'] = "Sunting";
			$data['title2'] = "";
			$data['active'] = "";

			$data['settingData'] = $this->m_setting->select_profil($user->id_pegawai);

			$this->template->load('template/template_view','setting/v_setting_bar',$data);
		}
	}

	function change_img_pegawai(){
		$user = $this->session->userdata('data_user');
	    $imagePath = $this->gallery_path;

		$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
		$temp = explode(".", $_FILES["img"]["name"]);
		$extension = end($temp);
		
		//Check write Access to Directory

		if(!is_writable($imagePath)){
			$response = Array(
				"status" => 'error',
				"message" => 'Can`t upload File; no write Access'
			);
			print json_encode($response);
			return;
		}
		
		if ( in_array($extension, $allowedExts)){
			if ($_FILES["img"]["error"] > 0){		
				$response = array(
					"status" => 'error',
					"message" => 'ERROR Return Code: '. $_FILES["img"]["error"]);	
		  	}else{
				
			      $filename = $_FILES["img"]["tmp_name"];
				  list($width, $height) = getimagesize( $filename );

				  move_uploaded_file($filename,  $imagePath.'/'.$_FILES["img"]["name"]);
				  $arr_data = array('img_pegawai'=>$_FILES["img"]["name"]);
				  $this->m_setting->update_display($user->id_pegawai,$arr_data);

				  $response = array(
					"status" => 'success',
					"url" => $this->gallery_path_url.'/'.$_FILES["img"]["name"],
					"width" => $width,
					"height" => $height);
			}
		}else{
		   $response = array(
				"status" => 'error',
				"message" => 'something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini',
			);
		}
		  
		print json_encode($response);
	 }


	 function image_cropping(){
	 	$user = $this->session->userdata('data_user');
	 	$imgUrl = $_POST['imgUrl'];
		// original sizes
		$imgInitW = $_POST['imgInitW'];
		$imgInitH = $_POST['imgInitH'];
		// resized sizes
		$imgW = $_POST['imgW'];
		$imgH = $_POST['imgH'];
		// offsets
		$imgY1 = $_POST['imgY1'];
		$imgX1 = $_POST['imgX1'];
		// crop box
		$cropW = $_POST['cropW'];
		$cropH = $_POST['cropH'];
		// rotation angle
		$angle = $_POST['rotation'];

		$jpeg_quality = 100;

		$output_filename = $this->gallery_path."/croppedImg_".rand();
		$file_image_src = str_replace("http://localhost/Telkom_akses/", "", $imgUrl); 
		$what = getimagesize($file_image_src);

		switch(strtolower($what['mime']))
		{
		    case 'image/png':
		        $img_r = imagecreatefrompng($file_image_src);
				$source_image = imagecreatefrompng($file_image_src);
				$type = '.png';
		        break;
		    case 'image/jpeg':
		        $img_r = imagecreatefromjpeg($file_image_src);
				$source_image = imagecreatefromjpeg($file_image_src);
				error_log("jpg");
				$type = '.jpeg';
		        break;
		    case 'image/gif':
		        $img_r = imagecreatefromgif($file_image_src);
				$source_image = imagecreatefromgif($file_image_src);
				$type = '.gif';
		        break;
		    default: die('image type not supported');
		}

	 	if(!$_POST){
			$response = Array(
			    "status" => 'error',
			    "message" => 'No Post Data, Please Check Your Configuration!'
		    );
	 	}else{

			//Check write Access to Directory

			if(!is_writable(dirname($output_filename))){
				$response = Array(
				    "status" => 'error',
				    "message" => 'Can`t write cropped File'
			    );	
			}else{

			    // resize the original image to size of editor
			    $resizedImage = imagecreatetruecolor($imgW, $imgH);
				imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);

			    // rotate the rezized image
			    $rotated_image = imagerotate($resizedImage, -$angle, 0);

			    // find new width & height of rotated image
			    $rotated_width = imagesx($rotated_image);
			    $rotated_height = imagesy($rotated_image);

			    // diff between rotated & original sizes
			    $dx = $rotated_width - $imgW;
			    $dy = $rotated_height - $imgH;
			    
			    // crop rotated image to fit into original rezized rectangle
				$cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
				imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
				imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
				// crop image into selected area
				
				$final_image = imagecreatetruecolor($cropW, $cropH);
				imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
				imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
				// finally output png image

				imagejpeg($final_image, $output_filename.$type, $jpeg_quality);
				$imgSmall = explode('/', $output_filename);
				$arr_data = array('img_pegawai_small'=>$imgSmall[1].$type);
				$this->m_setting->update_display_small($user->id_pegawai,$arr_data);

				$file_image_url = str_replace('C:\wamp\www', 'http://localhost', $output_filename);
				$response = Array(
				    "status" => 'success',
				    "url" => $file_image_url.$type
			    );
			}
	 	}
		print json_encode($response);
	 }

	 function change_info_profil(){
	 	if($this->session->userdata('is_login') == TRUE){
	 		$user = $this->session->userdata('data_user');

		 	if($this->input->post('alamat_pegawai')){
		 		$arr_data = array('alamat_pegawai'=>strtoupper($this->input->post('alamat_pegawai')));
		 		$this->m_setting->update_alamat($user->id_pegawai,$arr_data);
		 		redirect('setting/view_setting');
		 	}else if($this->input->post('telepon_pegawai')){
		 		$arr_data = array('telp_hp_pegawai'=>strtoupper($this->input->post('telepon_pegawai')));
		 		$this->m_setting->update_kontak($user->id_pegawai,$arr_data);
		 		redirect('setting/view_setting');
		 	}else if($this->input->post('email_pegawai')){
		 		$arr_data = array('email_pegawai'=>strtoupper($this->input->post('email_pegawai')));
		 		$this->m_setting->update_email($user->id_pegawai,$arr_data);
		 		$this->session->sess_destroy();
				redirect('login/try_login');
		 	}else{
		 		$konfirmasi = $this->m_setting->confirm_change($user->email_pegawai,md5(strtoupper($this->input->post('pass_pegawai_ago'))));
		 		if(count($konfirmasi) > 0){			
			 		$arr_data = array('password'=>md5(strtoupper($this->input->post('pass_pegawai_change'))));
			 		$this->m_setting->update_password($user->id_user,$arr_data);
			 		$this->session->sess_destroy();
					redirect('login/try_login');	
		 		}else{
		 			redirect('setting/view_Setting');
		 		}
		 	}
	 	}else{
	 		redirect('login/try_login');
	 	}
	 }
}
?>