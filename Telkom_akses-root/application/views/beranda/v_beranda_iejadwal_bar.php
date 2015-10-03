<!--INSERT UPDATE VIEW-->
<div class="row">
    <div class="col-md-12">
        
        <?php echo form_open($action,array('class'=>'form-horizontal')) ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Form Jadwal</strong></h3>
            </div>
            <div class="panel-body form-group-separated">
                
                <div class="form-group">
                    <label class="col-md-1 col-xs-12 control-label">Pegawai</label>
                    <div class="col-md-3 col-xs-12">

						<?php  
						if($type=="Tambah"){
						?>
						<select name="id_pegawai" class="form-control select">
						<?php
							foreach ($pegawai as $pg) {
								# code...
						?>
							<option value="<?php echo $pg->id_pegawai;?>"><?php echo $pg->nama_pegawai;?></option>
						<?php
							}
						?>
						</select>
                        <span class="help-block">Pilih Pegawai Yang Akan Dijadwalkan</span>
						<?php
						}else{
						?>
						<input type="hidden" name="id_pegawai" value="<?= $pegawai[0]->id_pegawai; ?>"> <?php echo $pegawai[0]->nama_pegawai;?>
						<?php
						}
						?>
                    </div>
                </div>

               	<div class="form-group">
                    <label class="col-md-1 col-xs-12 control-label">Keluhan</label>
                    <div class="col-md-10 col-xs-12">                                                                                            
						<table class="table datatable">
						<thead>
							<tr>
								<th width="10%">Id Speedy</th>
								<th width="10%">Nama Pelanggan</th>
								<th width="10%">Alamat Pelanggan</th>
								<th width="10%">Keterangan Keluhan</th>
								<th width="5%">Jenis</th>
								<th width="3%">Jadwalkan</th>
								<th width="10%">Pengerjaan</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							foreach ($keluhan as $kl) {
								# code...
						?>
							<tr>
								<td><?php echo $kl->id_speedy; ?></td>
								<td><?php echo $kl->nama_pelanggan; ?></td>
								<td><?php echo $kl->alamat_pelanggan; ?></td>
								<td><?php echo $kl->ket_keluhan; ?></td>
								<td><?php echo $kl->jenis_keluhan; ?></td>
								<td align="center"><input type="checkbox" name="item[]" class="item" value="<?php echo $kl->id_keluhan; ?>">
								<input type="hidden" value="<?= $kl->id_jadwal?>" name="cek[]" />
								<input type="hidden" value="<?= $kl->log_j?>" name="log_j[]" /></td>
								<input type="hidden" value="<?= $kl->id_kunjungan?>" name="kunjungan[]" />
								<input type="hidden" value="<?= $kl->log_ks?>" name="log_ks[]" /></td>
								<td><input class="form-control datepicker" data-date-format="d-M-yy" type="text" name="tgl_pengerjaan[]" disabled="" id="datepicker"></td>	
							</tr>
						<?php
							}
						?>
						</tbody>
						</table>
                        <span class="help-block">Centang Checkbox Untuk Menjadwalkan Pekerjaan</span>
                    </div>
                </div>
              	
            </div>
            <div class="panel-footer">
                <input type="submit" name="submit" value="Simpan" class='btn btn-primary pull-right' id=" add-jadwal" disabled="">                          
            </div>
        </div>
        <?php echo form_close(); ?>
        
    </div>
</div>