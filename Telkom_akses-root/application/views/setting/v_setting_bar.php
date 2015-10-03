<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		    <div class="panel-body setting">
		        <div class="setting-image">

		        	<div class="image">                              
	                    <img src="<?php echo base_url();?>assets/images/<?=$settingData[0]->img_pegawai_small?>" alt="<?=strtoupper($settingData[0]->nama_pegawai)?>"/>                                       
	                    <ul class="setting-image-controls">
	                        <li><span id="edit_image"><i class="fa fa-pencil open-settingModal" data-toggle="modal" data-target="#modalSetting" data-id="<?=strtoupper($settingData[0]->id_pegawai)?>" data-backdrop=""></i></span></li>
	                    </ul>                                                                    
	                </div>
		   
		        </div>
		        <div class="setting-data">
		            <div class="setting-data-name"><?=strtoupper($settingData[0]->nama_pegawai)?></div>
		            <div class="setting-data-title"><?=strtoupper($settingData[0]->jabatan_pegawai)?></div>
		        </div>                                   
		    </div>                                
		    <div class="panel-body list-group border-bottom">
				<table class="table">
					<tr>
						<td>Id Pegawai</td>
						<td>&nbsp;</td>
						<td><?=strtoupper($settingData[0]->id_pegawai)?></td>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td>Nama Pegawai</td>
						<td>&nbsp;</td>
						<td><?=strtoupper($settingData[0]->nama_pegawai)?></td>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<td>Jabatan</td>
						<td>&nbsp;</td>
						<td><?=strtoupper($settingData[0]->jabatan_pegawai)?></td>
						<td colspan="3">&nbsp;</td>
					</tr>
					<tr>
						<?php echo form_open($action,array('class'=>'form-horizontal','id'=>'form_alamat')) ?>
						<td>Alamat</td>
						<td>&nbsp;</td>
						<td class="edit_default_alamat_pegawai"><?=strtoupper($settingData[0]->alamat_pegawai)?></td>
						<td class="edit_default_alamat_pegawai"><img src="<?= base_url()?>assets/img/spinner.gif" class="loading_spinner2">&nbsp;<a href="#" id="edit_alamat_pegawai"><i class="fa fa-edit" id="sunting-2"></i> Sunting</a></td>
						<td bgcolor="#F6F7F8" class="edit_form_alamat_pegawai"><textarea name="alamat_pegawai" class="form-control" id="alamat_pegawai_setting"  cols="50" rows="5"><?=strtoupper($settingData[0]->alamat_pegawai)?></textarea><br><br><?php echo form_submit('submit','Simpan',"class='btn btn-primary pull-right edit_submit_alamat_pegawai'"); ?></td>
						<td bgcolor="#F6F7F8" class="edit_form_alamat_pegawai"><a href="#" id="close_alamat_pegawai"><i class="fa fa-times"> Tutup</i></a></td>
						<?= form_close() ?>
					</tr>
					<tr>
						<?php echo form_open($action,array('class'=>'form-horizontal','id'=>'form_telp')) ?>
						<td>Kontak</td>
						<td>&nbsp;</td>
						<td class="edit_default_telepon_pegawai"><?=strtoupper($settingData[0]->telp_hp_pegawai)?></td>
						<td class="edit_default_telepon_pegawai"><img src="<?= base_url()?>assets/img/spinner.gif" class="loading_spinner3">&nbsp;<a href="#" id="edit_telepon_pegawai"><i class="fa fa-edit" id="sunting-3"></i> Sunting</a></td>
						<td bgcolor="#F6F7F8" class="edit_form_telepon_pegawai"><input type="text" name="telepon_pegawai" class="form-control" id="telepon_pegawai_setting" maxlength="12" value="<?=strtoupper($settingData[0]->telp_hp_pegawai)?>"><br><br><?php echo form_submit('submit','Simpan',"class='btn btn-primary pull-right edit_submit_telepon_pegawai'"); ?></td>
						<td bgcolor="#F6F7F8" class="edit_form_telepon_pegawai"><a href="#" id="close_telepon_pegawai"><i class="fa fa-times"> Tutup</i></a></td>
						<?= form_close() ?>
					</tr>
					<tr>
						<?php echo form_open($action,array('class'=>'form-horizontal','id'=>'form_email')) ?>
						<td>Email</td>
						<td>&nbsp;</td>
						<td class="edit_default_email_pegawai"><?=strtoupper($settingData[0]->email_pegawai)?></td>
						<td class="edit_default_email_pegawai"><img src="<?= base_url()?>assets/img/spinner.gif" class="loading_spinner4">&nbsp;<a href="#" id="edit_email_pegawai"><i class="fa fa-edit" id="sunting-4"> </i> Sunting</a></td>
						<td bgcolor="#F6F7F8" class="edit_form_email_pegawai"><input type="text" name="email_pegawai" id="email_pegawai_setting" class="form-control" value="<?=strtoupper($settingData[0]->email_pegawai)?>"><br><br><?php echo form_submit('submit','Simpan',"class='btn btn-primary pull-right edit_submit_email_pegawai'"); ?></td>
						<td bgcolor="#F6F7F8" class="edit_form_email_pegawai"><a href="#" id="close_email_pegawai"><i class="fa fa-times"> Tutup</i></a></td>
						<?= form_close() ?>
					</tr>
					<tr>
						<?php echo form_open($action,array('class'=>'form-horizontal','id'=>'form_pass')) ?>
						<td>Password</td>
						<td>&nbsp;</td>
						<td bgcolor="#F6F7F8" class="edit_default_pass_pegawai"><i>Rubah password dengan menekan tombol sunting.</i></td>
						<td class="edit_default_pass_pegawai"><img src="<?= base_url()?>assets/img/spinner.gif" class="loading_spinner5">&nbsp;<a href="#" id="edit_pass_pegawai"><i class="fa fa-edit" id="sunting-5"></i> Sunting</a></td>
						<td bgcolor="#F6F7F8" class="edit_form_pass_pegawai">
						<input type="password" name="pass_pegawai_change" maxlength="30" id="pass_pegawai_change" class="form-control pass_pegawai_setting" placeholder="Isikan Sandi Baru"><br><br>
						<input type="password" name="pass_pegawai_confirm"  maxlength="30" id="pass_pegawai_confirm" class="form-control pass_pegawai_setting" placeholder="Isikan Kembali Sandi Baru"><br><br>
						<input type="password" name="pass_pegawai_ago"  maxlength="30" id="pass_pegawai_ago" class="form-control pass_pegawai_setting" placeholder="Isikan Konfirmasi Sandi Lama"><br><br>
						<?php echo form_submit('submit','Simpan',"class='btn btn-primary pull-right edit_submit_pass_pegawai'"); ?></td>
						<td bgcolor="#F6F7F8" class="edit_form_pass_pegawai"><a href="#" id="close_pass_pegawai"><i class="fa fa-times"> Tutup</i></a></td>
						<?= form_close() ?>
					</tr>
				</table>
		    </div>
		</div>
	</div>
</div>