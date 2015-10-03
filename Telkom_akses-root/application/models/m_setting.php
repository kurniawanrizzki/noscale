<?php  
class M_Setting extends CI_Model{

	function select_profil($id){
		$query = $this->db->query("SELECT id_pegawai,img_pegawai_small,nama_pegawai,jabatan_pegawai,alamat_pegawai,email_pegawai,telp_hp_pegawai 
				FROM tb_pegawai WHERE id_pegawai = '$id' ");
		return $query->result();
	}

	function confirm_change($email,$pass){
		$query = $this->db->query("SELECT email_pegawai,password FROM tb_user WHERE email_pegawai = '$email' AND password = '$pass'");
		return $query->result();
	}

	function update_display($id,$img){
		$this->db->where('id_pegawai',$id);
		$this->db->update('tb_pegawai',$img);
	}

	function update_display_small($id,$img_small){
		$this->db->where('id_pegawai',$id);
		$this->db->update('tb_pegawai',$img_small);
	}

	function update_alamat($id,$alamat){
		$this->db->where('id_pegawai',$id);
		$this->db->update('tb_pegawai',$alamat);
	}

	function update_kontak($id,$kontak){
		$this->db->where('id_pegawai',$id);
		$this->db->update('tb_pegawai',$kontak);
	}

	function update_email($id,$email){
		$this->db->where('id_pegawai',$id);
		$this->db->update('tb_pegawai',$email);
	}

	function update_password($id_user,$pass){
		$this->db->where('id_user',$id_user);
		$this->db->update('tb_user',$pass);
	}
}
?>