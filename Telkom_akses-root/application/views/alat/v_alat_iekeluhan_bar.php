<!--insert update keluhan-->

<div class="row">
    <div class="col-md-12">
        
        <?php echo form_open_multipart($action,array('class'=>'form-horizontal','id'=>'jvalidate'));
        foreach ($pelanggan as $pg) {
        	# code...
        ?>
            <div class="panel panel-default">
	            <div class="panel-heading">
	                <h3 class="panel-title"><strong>Form Input/Edit Keluhan</strong></h3>
	            </div>
	            <div class="panel-body form-group-separated">
	                
	                <div class="form-group">
	                    <label class="col-md-3 col-xs-12 control-label">ID Speedy</label>
	                    <div class="col-md-6 col-xs-12">                                            
	                        <div class="input-group">
	                            <input type="text" class="form-control" name="id_speedy1" disabled="" value="<?php echo $pg->id_speedy; ?>"/>
	                            <input type="hidden" name="id_speedy"  value="<?php echo $pg->id_speedy; ?>">
	                        </div>                                
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="col-md-3 col-xs-12 control-label">Nama Pelanggan</label>
	                    <div class="col-md-6 col-xs-12">                                            
	                        <div class="input-group">
	                            <input type="text" class="form-control" name="nama_pelanggan" disabled="" value="<?php echo $pg->nama_pelanggan; ?>"/>
	                        </div>                                   
	                    </div>
	                </div>

	               	<div class="form-group">
	                    <label class="col-md-3 col-xs-12 control-label">Jalur Perangkat Pelanggan</label>
	                    <div class="col-md-6 col-xs-12">                                                                                            
							<select name="id_dp" class="form-control select" disabled="">
								<option value="<?php echo $pg->id_dp;?>" selected><?php echo $pg->nama_dp.'-'.$pg->nama_msan;?></option>
								<?php
								foreach ($jalur as $kt) {							  	
								?>
								<option value="<?php echo $kt->id_dp;?>"><?php echo $kt->nama_dp.'-'.$kt->nama_msan;?></option>
								<?php
								}  
								?>
							</select>
	                    </div>
	                </div>
	                
	                <div class="form-group">
	                    <label class="col-md-3 col-xs-12 control-label">Alamat Pelanggan</label>
	                    <div class="col-md-6 col-xs-12">                                            
	                        <textarea class="form-control" rows="5" disabled=""><?php echo $pg->alamat_pelanggan; ?></textarea>
	                    </div>
	                </div>           

	                <div class="form-group">
	                    <label class="col-md-3 col-xs-12 control-label">Telepon Selular Pelanggan</label>
	                    <div class="col-md-6 col-xs-12">                                            
	                        <div class="input-group">
	                            <input type="text" class="form-control" disabled="" value="<?php echo $pg->telp_hp_pelanggan; ?>" name="telp_hp_pelanggan"/>
	                        </div>                                            
	                    </div>
	                </div>
					
					<?php if($pg->telp_rumah_pelanggan != $pg->id_speedy){
					?>
						<div class="form-group">
		                    <label class="col-md-3 col-xs-12 control-label">Telepon Rumah Pelanggan</label>
		                    <div class="col-md-6 col-xs-12">                                            
		                        <div class="input-group">
		                            <input type="text" class="form-control" disabled="" value="<?php echo $pg->telp_rumah_pelanggan; ?>" name="telp_rumah_pelanggan" id="telp_rumah_pelanggan" disabled/>
		                        </div>                                         
		                    </div>
		                </div>
					<?php
					} ?>

					<div class="form-group">
	                    <label class="col-md-3 col-xs-12 control-label">Keterangan Keluhan</label>
	                    <div class="col-md-6 col-xs-12">                                            
	                        <textarea class="form-control" rows="5" name="ket_keluhan" id="ket_keluhan"><?php echo $type == 'EDIT'?$pg->ket_keluhan:' ' ?></textarea>
	                    </div>
	                </div>  
					
					<div class="form-group">
	                    <label class="col-md-3 col-xs-12 control-label">Jenis Keluhan</label>
	                    <div class="col-md-6 col-xs-12">                                                                                            
							<select name="kat_keluhan" class="form-control select">
								<?php  
									if($type == 'EDIT'){
									?>
									<option value="<?php echo $pg->id_kat_keluhan;?>"><?php echo $pg->jenis_keluhan;?></option>
									<?php
									}
									foreach ($kategori as $kat) {
										# code...
								?>
									<option value="<?php echo $kat->id_kat_keluhan;?>"><?php echo $kat->jenis_keluhan; ?></option>
								<?php
									}
								?>
							</select>
	                    </div>
	                </div>
	               

	            </div>
	            <div class="panel-footer">                                   
	                <?php echo form_submit('submit','Simpan',"class='btn btn-primary pull-right'"); ?>
	            </div>
	        </div>
	    <?php
        }
		echo form_close(); ?>
        
    </div>
</div>                    
