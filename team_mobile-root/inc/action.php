<?php  
require_once '../inc/inc_db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Header:Content-Type, x-xsrf-token");
date_default_timezone_set("Asia/Jakarta");

$action = $_GET['Action'];
$data = json_decode(file_get_contents("php://input"));
$datenow = date('Y-m-d');

if($action == 'Login'){
	$id = $data->email;
	$pass = md5(strtoupper($data->pass));

	$query = "SELECT b.id_pegawai,a.id_user,b.img_pegawai_small,b.nama_pegawai,a.email_pegawai,a.password,a.grant_status FROM tb_user a INNER JOIN tb_pegawai b 
			ON a.email_pegawai = b.email_pegawai WHERE a.email_pegawai = '$id' AND a.password = '$pass' AND b.jabatan_pegawai = 'TEKNISI'";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$arr = array();
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$arr[] = $row;
		}
	}

	echo json_encode($arr);
}else if($action == 'LoginTime'){
	$login_time = date('Y-m-d H:i:s');
	$id_user = $data->id_user;

	$query = "INSERT INTO tb_login (id_user,login) VALUES ('$id_user','$login_time')";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
}else if($action == 'Pelanggan'){
	$id_pegawai = $data->id;

	$query = "SELECT d.id_kunjungan,b.id_keluhan,a.id_speedy,a.nama_pelanggan,a.alamat_pelanggan,b.ket_keluhan FROM tb_pelanggan a INNER JOIN tb_keluhan b 
			ON a.id_speedy = b.id_speedy INNER JOIN tb_jadwal c 
			ON b.id_keluhan = c.id_keluhan INNER JOIN tb_kunjungan d 
			ON c.id_jadwal = d.id_jadwal 
			WHERE d.status_kunjungan = 'MENUNGGU' 
			AND d.tgl_kunjungan = '$datenow' 
			AND c.id_pegawai = '$id_pegawai'";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$arr = array();
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$arr[] = $row;
		}
	}

	echo json_encode($arr);
}else if($action == 'Detail_Pelanggan'){
	$id_keluhan = $data->id_keluhan;

	$query = "SELECT a.id_speedy,b.nama_msan,c.nama_dp,a.nama_pelanggan,a.alamat_pelanggan,a.telp_hp_pelanggan,a.telp_rumah_pelanggan,d.ket_keluhan,e.jenis_keluhan FROM tb_pelanggan a INNER JOIN tb_dp c
			ON a.id_dp = c.id_dp INNER JOIN tb_msan b 
			ON c.id_msan = b.id_msan INNER JOIN tb_keluhan d 
			ON a.id_speedy = d.id_speedy INNER JOIN tb_kat_keluhan e
			ON d.id_kat_keluhan = e.id_kat_keluhan WHERE d.id_keluhan = '$id_keluhan'";
	
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$arr = array();
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$arr[] = $row;
		}
	}

	echo json_encode($arr);
}else if($action == 'Lokasi_Pelanggan_By_Id'){
	$id_speedy = $data->id_speedy;

	$query = "SELECT id_speedy,nama_pelanggan,alamat_pelanggan,lat_pelanggan,ltg_pelanggan FROM tb_pelanggan WHERE id_speedy = '$id_speedy'";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$arr = array();
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$arr[] = $row;
		}
	}

	echo json_encode($arr);
}else if($action == 'Semua_Lokasi'){
	$id_pegawai = $data->id;
	$query = "SELECT a.id_speedy,a.nama_pelanggan,a.alamat_pelanggan,a.lat_pelanggan,a.ltg_pelanggan FROM tb_pelanggan a INNER JOIN tb_keluhan b 
			ON a.id_speedy = b.id_speedy INNER JOIN tb_jadwal c ON b.id_keluhan = c.id_keluhan INNER JOIN tb_kunjungan d ON c.id_jadwal = d.id_jadwal WHERE d.status_kunjungan = 'MENUNGGU' AND c.id_pegawai = '$id_pegawai' AND d.tgl_kunjungan = '$datenow' ORDER BY id_speedy ASC";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$arr = array();
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$arr[] = $row;
		}
	}

	echo json_encode($arr);
}else if($action == 'Edit_Data_Pelanggan' ){
	$id_speedy = $data->id_speedy;
	$alamat_pelanggan = strtoupper($data->alamat_pelanggan);
	$lat_pelanggan = strtoupper($data->lat_pelanggan);
	$ltg_pelanggan = $data->ltg_pelanggan;
	$telp_hp_pelanggan = $data->telp_hp_pelanggan;

	if($alamat_pelanggan != '' && $lat_pelanggan != '' && $ltg_pelanggan != '' ){
		$query = "UPDATE tb_pelanggan SET 
			alamat_pelanggan = '$alamat_pelanggan',
			lat_pelanggan = '$lat_pelanggan',
			ltg_pelanggan = '$ltg_pelanggan' WHERE id_speedy = '$id_speedy'";
	}else if($telp_hp_pelanggan != ''){
		$query = "UPDATE tb_pelanggan SET telp_hp_pelanggan = '$telp_hp_pelanggan' WHERE id_speedy = '$id_speedy'";
	}else{
		$query = "UPDATE tb_pelanggan SET 
			alamat_pelanggan = '$alamat_pelanggan',
			lat_pelanggan = '$lat_pelanggan',
			ltg_pelanggan = '$ltg_pelanggan',
			telp_hp_pelanggan = '$telp_hp_pelanggan' 
			WHERE id_speedy = '$id_speedy'";
	}
	
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

}else if($action == 'Checklist'){

	$id_kunjungan = $data->id_kunjungan;
	$ket = strtoupper($data->ket_kunjungan);
	$jam = date('H:i:s');
	$status = $data->status_kunjungan;

	$query = "UPDATE tb_kunjungan SET ket_kunjungan = '$ket',
			jam_kunjungan = '$jam',
			status_kunjungan = '$status'
			WHERE id_kunjungan = '$id_kunjungan'";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
}else if($action == 'Edit_Data_Pegawai'){
	$id_user = $data->id_user;
	$id_pegawai = $data->id_pegawai;
	$alamat_pegawai = strtoupper($data->alamat_pegawai);
	$email_pegawai = strtoupper($data->email_pegawai);
	$kontak = $data->telp_hp_pegawai;
	$pass = $data->pass;

	if($alamat_pegawai != ''){
		$query1 = "UPDATE tb_pegawai SET 
			alamat_pegawai = '$alamat_pegawai'
			WHERE id_pegawai = '$id_pegawai'";

	}else if($email_pegawai != ''){
		$query1 = "UPDATE tb_pegawai SET 
			email_pegawai = '$email_pegawai'
			WHERE id_pegawai = '$id_pegawai'";
	}else{
		$query1 = "UPDATE tb_pegawai SET 
			telp_hp_pegawai = '$kontak'
			WHERE id_pegawai = '$id_pegawai'";
	}
	$result1 = $mysqli->query($query1) or die($mysqli->error.__LINE__);

	$query2 = "UPDATE tb_user SET password = '$pass' WHERE id_user= '$id_user'";
	$result2 = $mysqli->query($query2) or die($mysqli->error.__LINE__);

}else if($action == 'Logout'){
	$logout_time = date('Y-m-d H:i:s');
	$id = $data->id;

	$query = "SELECT id_login FROM tb_login WHERE id_user='$id' ORDER BY id_login DESC LIMIT 1";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	while($row = $result->fetch_array()){
		$id_log = $row['id_login'];
		$update = "UPDATE tb_login SET logout = '$logout_time' WHERE id_login = '$id_log'";
		$ru = $mysqli->query($update) or die($mysqli->error.__LINE__);
	}
}else if($action == 'getDataPegawai'){
	$id = $data->id;
	$query = "SELECT * FROM tb_pegawai a INNER JOIN tb_user b ON a.email_pegawai = b.email_pegawai WHERE a.id_pegawai = '$id'";
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);

	$arr = array();
	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$arr[] = $row;
		}
	}

	echo json_encode($arr);
}else{
	echo 'There is No Current Action, Not Found!';
}
?>