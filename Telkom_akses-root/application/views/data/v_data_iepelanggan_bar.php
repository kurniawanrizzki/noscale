<!--INSERT UPDATE PELANGGAN-->

 <div class="row">
    <div class="col-md-12">
        
        <?php echo form_open_multipart($action,array('class'=>'form-horizontal','id'=>'jvalidate')) ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title form_title"><strong>FORM <?= $type;?> PEGAWAI</strong></h3>
            </div>
            <div class="panel-body form-group-separated">
                
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">ID Speedy</label>
                    <div class="col-md-6 col-xs-12">                                            
                    <?php  
                    if($type == 'TAMBAH'){
                    ?>
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php echo set_value('id_speedy'); ?>" name="id_speedy" id="id_pelanggan_input" maxlength="12"/>
                            <span class="help-block" id="cross2">Tidak Tersedia</span>
                        </div>                                            
                        <span class="help-block">Isikan Id Speedy</span>
                    <?php
                    }else{
                    ?>
                        <label class="control-label"><?php echo $pelanggan[0]->id_speedy; ?>  </label>     
                    <?php
                    }
                    ?>
                    </div>
                </div>

               	<div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Select</label>
                    <div class="col-md-6 col-xs-12">                                                                                            
                        <select class="form-control select" name="id_dp">

							<?php 
							if($type == 'EDIT'){
							?>
							<option value="<?php echo $pelanggan[0]->id_dp;?>"><?php echo $pelanggan[0]->nama_msan.'-'.$pelanggan[0]->nama_dp;?></option>
							<?php
							}
							foreach($dataJalur as $dj){
							?>
							<option value="<?php echo $dj->id_dp;?>"><?php echo $dj->nama_msan.'-'.$dj->nama_dp;?></option>
							<?php
							}
							?>

                        </select>
                        <span class="help-block">Pilih DP dan MSAN Terdekat dari Wilayah Pelanggan</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Nama Pelanggan</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php echo $type != 'EDIT'?set_value('nama_pelanggan'):$pelanggan[0]->nama_pelanggan; ?>" name="nama_pelanggan"/>
                        </div>                                            
                        <span class="help-block">Isikan Nama Pelanggan</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Alamat Pelanggan</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <textarea class="form-control" rows="5" name="alamat_pelanggan"><?php echo $type != 'EDIT'?set_value('alamat_pelanggan'):$pelanggan[0]->alamat_pelanggan; ?></textarea>
                        <span class="help-block">Isikan Alamat Pelanggan</span>
                    </div>
                </div>              

                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Telepon Selular Pelanggan</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php echo $type != 'EDIT'?set_value('telp_hp_pelanggan'):$pelanggan[0]->telp_hp_pelanggan; ?>" name="telp_hp_pelanggan" maxlength="12"/>
                        </div>                                            
                        <span class="help-block">Isikan Telepon Selular Pelanggan</span>
                    </div>
                </div>

                <?php  
                if($pengguna->jabatan_pegawai != 'TEKNISI'){
                ?>
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Telepon Rumah Pelanggan</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php echo $type != 'EDIT'?set_value('telp_rumah_pelanggan'):$pelanggan[0]->telp_rumah_pelanggan; ?>" name="telp_rumah_pelanggan" id="telp_rumah_pelanggan" maxlength="12"/>
                        </div>                                            
                        <span class="help-block">Isikan Telepon Rumah Pelanggan</span>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <div class="panel-footer">                                   
                    <input type="submit" name="submit" value="Simpan" class='btn btn-primary pull-right' id=" addedit-pelanggan" disabled=""> 
            </div>
        </div>
		<?php echo form_close(); ?>
        
    </div>
</div>                    