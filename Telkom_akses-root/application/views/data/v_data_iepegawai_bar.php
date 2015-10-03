<!--INSERT UPDATE PEGAWAI-->
 <div class="row">
    <div class="col-md-12">
        
        <?php echo form_open_multipart($action,array('class'=>'form-horizontal','id'=>'jvalidate')) ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title form_title"><strong>FORM <?= $type;?> PEGAWAI</strong></h3>
            </div>
            <div class="panel-body form-group-separated">
                
                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">ID Pegawai</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <?php  
                        if($type == 'TAMBAH'){
                        ?>
                            <div class="input-group">
                                <input type="text" value="<?php echo set_value('id_pegawai');?>" name="id_pegawai" id="id_pegawai_input" class="form-control" maxlength="11"/>
                                <!-- <span class="help-block" id="tick">Tersedia</span> -->
                                <span class="help-block" id="cross">Tidak Tersedia</span>
                            </div>                                           
                            <span class="help-block">Isikan Id Pegawai</span>
                        <?php
                        }else{
                        ?>
                            <label class="control-label"><?php echo $pegawai[0]->id_pegawai; ?>  </label>                                     
                        <?php
                        }
                        ?>
                    </div>
                </div>
                
				<div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Nama Pegawai</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <input type="text" value="<?php echo $type != 'EDIT'?set_value('nama_pegawai'):$pegawai[0]->nama_pegawai; ?>" name="nama_pegawai" id="nama_pegawai_input" class="form-control"/>
                        </div>                                            
                        <span class="help-block">Isikan Nama Pegawai</span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Jabatan Pegawai</label>
                    <div class="col-md-6 col-xs-12">                                                                                            
                        <?php
                        if($pengguna->jabatan_pegawai == 'MANAGER'){
                        ?>
                            <select name="jabatan_pegawai" class="form-control select">
                                <?php 
                                if($pegawai[0]->jabatan_pegawai == 'MANAGER'){ 
                                ?>
                                    <option value="Manager" selected="">Manager</option>
                                    <option value="Kepala Teknisi">Kepala Teknisi</option>
                                    <option value="Karyawan">Karyawan</option>
                                    <option value="Teknisi">Teknisi</option>
                                <?php
                                }else if($pegawai[0]->jabatan_pegawai =='TEKNISI'){
                                ?>
                                    <option value="Manager">Manager</option>
                                    <option value="Kepala Teknisi">Kepala Teknisi</option>
                                    <option value="Karyawan">Karyawan</option>
                                    <option value="Teknisi"  selected="">Teknisi</option>
                                <?php
                                }else if($pegawai[0]->jabatan_pegawai =='KARYAWAN'){
                                ?>
                                    <option value="Manager">Manager</option>
                                    <option value="Kepala Teknisi">Kepala Teknisi</option>
                                    <option value="Karyawan" selected="">Karyawan</option>
                                    <option value="Teknisi">Teknisi</option>
                                <?php
                                }else{ 
                                ?>
                                    <option value="Manager">Manager</option>
                                    <option value="Kepala Teknisi"  selected="">Kepala Teknisi</option>
                                    <option value="Karyawan">Karyawan</option>
                                    <option value="Teknisi">Teknisi</option>
                                <?php  
                                }
                                ?>
                            </select>
                            <span class="help-block">Pilih Salah Satu Jabatan Pegawai</span>
                        <?php    
                        }else{
                        ?>
                            <input type="hidden" value="Teknisi" name="jabatan_pegawai"> Teknisi
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Alamat Pegawai</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <textarea class="form-control" rows="5" name="alamat_pegawai" id= "alamat_pegawai_input"><?php echo $type != 'EDIT'?set_value('alamat_pegawai'):$pegawai[0]->alamat_pegawai; ?></textarea>
                        <span class="help-block">Isikan Alamat Pegawai</span>
                    </div>
                </div>
                    
               	<div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Email Pegawai</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <?php  
                        if($type == 'TAMBAH'){
                        ?>
                            <div class="input-group">
                                <input type="text" value="<?php echo set_value('email_pegawai'); ?>" name="email_pegawai" id="email_pegawai_input" class="form-control"/>
                                <!-- <span class="help-block" id="tick">Tersedia</span> -->
                                <span class="help-block" id="cross1">Tidak Tersedia</span>
                            </div>                                            
                            <span class="help-block">Isikan Email Pegawai</span>
                        <?php
                        }else{
                        ?>
                            <label class="control-label"><?php echo $pegawai[0]->email_pegawai; ?>  </label> 
                        <?php    
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-3 col-xs-12 control-label">Telepon Selular Pegawai</label>
                    <div class="col-md-6 col-xs-12">                                            
                        <div class="input-group">
                            <input type="text" value="<?php echo $type != 'EDIT'?set_value('telp_hp_pegawai'):$pegawai[0]->telp_hp_pegawai; ?>" name="telp_hp_pegawai" id="telp_hp_pegawai_input" class="form-control" maxlength="12"/>
                        </div>                                            
                        <span class="help-block">Isikan Telepon Selular Pegawai</span>
                    </div>
                </div>
            </div>
            <div class="panel-footer">                                   
                <input type="submit" name="submit" value="Simpan" class='btn btn-primary pull-right' id=" addedit-pegawai" disabled=""> 
            </div>
        </div>
        <?php echo form_close(); ?>
        
    </div>
</div>                    	