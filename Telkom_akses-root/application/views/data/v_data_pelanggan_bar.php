<!--DATA VIEW PELANGGAN-->

<div class="row">
    <div class="col-md-12">

        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">                                
                <h3 class="panel-title">Data Pelanggan</h3>
                <ul class="panel-controls">
                	<?php  
                	if($pengguna->jabatan_pegawai == 'KEPALA TEKNISI' || $pengguna->jabatan_pegawai == 'KARYAWAN'){
                	?>
                	<li><a href="../data/add_pelanggan" class="panel-plus"><span class="fa fa-plus"></span></a></li>
                	<?php
                	}
                	?>
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                </ul>                                
            </div>
            <div class="panel-body">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th width="12%">Id Speedy</th>
                            <th width="19%">Nama Pelanggan</th>
                            <th width="32%">Alamat Pelanggan</th>
                            <th width="12%">Telepon Selular</th>
							<th width="8%">Status</th>
                            <th width="17%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
						
						foreach ($pelanggan as $pl) {
							# code...
							if ($pengguna->jabatan_pegawai == 'KEPALA TEKNISI' || $pengguna->jabatan_pegawai == 'KARYAWAN') {
						?>
									<tr id="<?= $pl->id_speedy ?>">
										<td><?= $pl->id_speedy ?></td>
										<td><?= $pl->nama_pelanggan ?></td>
										<td><?= $pl->alamat_pelanggan ?></td>
										<td><?= $pl->telp_hp_pelanggan ?></td>
										<td><?php echo anchor('data/changeStatusPelanggan/'.$pl->id_speedy,$pl->status_pelanggan,array('class'=>'changePelanggan')); ?></td>
										<td>
										<button type="button" class="open-detailPModal btn btn-primary" data-toggle="modal" data-target="#myModal1" data-id="<?= $pl->id_speedy ?>" data-backdrop=""><i class='glyphicon glyphicon-info-sign'></i></button>
										<?=  
										$pl->status_pelanggan == 'ON'?anchor("data/update_Pelanggan/".$pl->id_speedy,"<i class='glyphicon glyphicon-pencil'></i>",array('class'=>'btn btn btn-warning')):'';
										?>
										<button class="btn btn-danger" onClick="delete_row_on_tb_pelanggan('<?= $pl->id_speedy ?>');"><i class='glyphicon glyphicon-trash'></i></button>
										</td>
									</tr>

								<?php  
							}else if($pengguna->jabatan_pegawai == 'TEKNISI'){
							?>
									<tr>
										<td><?= $pl->id_speedy ?></td>
										<td><?= $pl->nama_pelanggan ?></td>
										<td><?= $pl->alamat_pelanggan ?></td>
										<td><?= $pl->telp_hp_pelanggan ?></td>
										<td><?php echo anchor('data/changeStatusPelanggan/'.$pl->id_speedy,$pl->status_pelanggan,array('class'=>'changePelanggan')); ?></td>
										<td>
										<button type="button" class="open-detailPModal btn btn-primary" data-toggle="modal" data-target="#myModal1" data-id="<?= $pl->id_speedy ?>" data-backdrop=""><i class='glyphicon glyphicon-info-sign'></i></button>
										<?=  
										$pl->status_pelanggan == 'ON'?anchor("data/update_pelanggan/".$pl->id_speedy,"<i class='glyphicon glyphicon-pencil'></i>",array('class'=>'btn btn btn-warning')):'';
										?>
										</td>
									</tr>
							<?php
							}else{
							?>
									<tr>
										<td><?= $pl->id_speedy ?></td>
										<td><?= $pl->nama_pelanggan ?></td>
										<td><?= $pl->alamat_pelanggan ?></td>
										<td><?= $pl->telp_hp_pelanggan ?></td>
										<td><?= $pl->status_pelanggan ?></td>
										<td>
										<button type="button" class="open-detailPModal btn btn-primary" data-toggle="modal" data-target="#myModal1" data-id="<?= $pl->id_speedy ?>" data-backdrop=""><i class='glyphicon glyphicon-info-sign'></i></button>
										</td>
									</tr>
							<?php
							}
						}
						?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->
    </div>
</div>
