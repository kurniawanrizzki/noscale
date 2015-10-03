<!--DATA VIEW PEGAWAI-->

<div class="row">
    <div class="col-md-12">

        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">                                
                <h3 class="panel-title">Data Pegawai</h3>
                <ul class="panel-controls">
                	<!-- fungsi tambah hanya berlaku pada kepala teknisi dan manager -->
                	<?php  
                	if($pengguna->jabatan_pegawai == 'KEPALA TEKNISI' || $pengguna->jabatan_pegawai == 'MANAGER'){
                	?>
					<li><a href="../data/add_pegawai" class="panel-plus"><span class="fa fa-plus"></span></a></li>
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
                            <th width="12%">Id Pegawai</th>
                            <th width="19%">Nama Pegawai</th>
                            <th width="32%">Alamat Pegawai</th>
                            <th width="15%">Jabatan Pegawai</th>
                            <th width="22%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
						
						foreach ($pegawai as $ap) {
							//data user tidak akan ditampilkan
							if($ap->id_pegawai != $pengguna->id_pegawai){
								# code...
								$hitungRiwayat = count($this->m_data->getRiwayatPerUser($ap->id_pegawai));
								//hanya berlaku pada kepala teknisi dan manager terdapat fungsi delete dan edit pegawai 
								if ($pengguna->jabatan_pegawai == 'KEPALA TEKNISI') {
									if($hitungRiwayat > 0){
						?>
										<tr id="<?= $ap->id_pegawai ?>">
											<td><?= $ap->id_pegawai ?></td>
											<td><?= $ap->nama_pegawai ?></td>
											<td><?= $ap->alamat_pegawai ?></td>
											<td><?= $ap->jabatan_pegawai ?></td>
											<td>
											<button type="button" class="open-detailModal btn btn-primary" data-toggle="modal" data-target="#myModal" data-id="<?= $ap->id_pegawai ?>" data-backdrop=""><i class='glyphicon glyphicon-info-sign'></i></button>
											<button type="button" class="open-detailRModal btn btn-info" data-toggle="modal" data-target="#myModal3" data-id="<?= $ap->id_pegawai ?>" data-backdrop=""><i class='fa fa-clock-o'></i></button>
											<?php  
											if($ap->jabatan_pegawai == 'TEKNISI'){
												echo anchor("data/update_pegawai/".$ap->id_pegawai,"<i class='glyphicon glyphicon-pencil'></i>",array('class'=>'btn btn-warning'));
											?>
												<button class="btn btn-danger" onClick="delete_row_on_tb_pegawai('<?= $ap->id_pegawai ?>');"><i class='glyphicon glyphicon-trash'></i></button>
											<?php
											}
											?>
											</td>
										</tr>

									<?php  
									}else{
									?>
										<tr id="<?= $ap->id_pegawai ?>">
											<td><?= $ap->id_pegawai ?></td>
											<td><?= $ap->nama_pegawai ?></td>
											<td><?= $ap->alamat_pegawai ?></td>
											<td><?= $ap->jabatan_pegawai ?></td>
											<td>
											<button type="button" class="open-detailModal btn btn-primary" data-toggle="modal" data-target="#myModal" data-id="<?= $ap->id_pegawai ?>" data-backdrop=""><i class='glyphicon glyphicon-info-sign'></i></button>
											<?php 
											if($ap->jabatan_pegawai == 'TEKNISI'){
												echo anchor("data/update_pegawai/".$ap->id_pegawai,"<i class='glyphicon glyphicon-pencil'></i>",array('class'=>'btn btn-warning'));
											?>
												<button class="btn btn-danger" onClick="delete_row_on_tb_pegawai('<?= $ap->id_pegawai ?>');"><i class='glyphicon glyphicon-trash'></i></button>
											<?php
											}
											?>
											</td>
										</tr>
									<?php
									}
								}else if($pengguna->jabatan_pegawai == 'MANAGER'){
									if($hitungRiwayat > 0){
								?>
										<tr id="<?= $ap->id_pegawai ?>">
											<td><?= $ap->id_pegawai ?></td>
											<td><?= $ap->nama_pegawai ?></td>
											<td><?= $ap->alamat_pegawai ?></td>
											<td><?= $ap->jabatan_pegawai ?></td>
											<td>
											<button type="button" class="open-detailModal btn btn-primary" data-toggle="modal" data-target="#myModal" data-id="<?= $ap->id_pegawai ?>" data-backdrop=""><i class='glyphicon glyphicon-info-sign'></i></button>
											<button type="button" class="open-detailRModal btn btn-info" data-toggle="modal" data-target="#myModal3" data-id="<?= $ap->id_pegawai ?>" data-backdrop=""><i class='fa fa-clock-o'></i></button>
											<?=  
											anchor("data/update_pegawai/".$ap->id_pegawai,"<i class='glyphicon glyphicon-pencil'></i>",array('class'=>'btn btn-warning'));
											?>
											<button class="btn btn-danger" onClick="delete_row_on_tb_pegawai('<?= $ap->id_pegawai ?>');"><i class='glyphicon glyphicon-trash'></i></button>
											</td>
										</tr>

									<?php  
									}else{
									?>
										<tr id="<?= $ap->id_pegawai ?>">
											<td><?= $ap->id_pegawai ?></td>
											<td><?= $ap->nama_pegawai ?></td>
											<td><?= $ap->alamat_pegawai ?></td>
											<td><?= $ap->jabatan_pegawai ?></td>
											<td>
											<button type="button" class="open-detailModal btn btn-primary" data-toggle="modal" data-target="#myModal" data-id="<?= $ap->id_pegawai ?>" data-backdrop=""><i class='glyphicon glyphicon-info-sign'></i></button>
											<?=  
											anchor("data/update_pegawai/".$ap->id_pegawai,"<i class='glyphicon glyphicon-pencil'></i>",array('class'=>'btn btn-warning'));
											?>
											<button class="btn btn-danger" onClick="delete_row_on_tb_pegawai('<?= $ap->id_pegawai ?>');"><i class='glyphicon glyphicon-trash'></i></button>
											</td>
										</tr>
									<?php
									}
								}else{
								//untuk karaywan dan teknisi
									if($hitungRiwayat > 0){
								?>
										<tr>
											<td><?= $ap->id_pegawai ?></td>
											<td><?= $ap->nama_pegawai ?></td>
											<td><?= $ap->alamat_pegawai ?></td>
											<td><?= $ap->jabatan_pegawai ?></td>
											<td>									
											<button type="button" class="open-detailModal btn btn-primary" data-toggle="modal" data-target="#myModal" data-id="<?= $ap->id_pegawai ?>" data-backdrop=""><i class='glyphicon glyphicon-info-sign'></i></button>
											<button type="button" class="open-detailRModal btn btn-info" data-toggle="modal" data-target="#myModal3" data-id="<?= $ap->id_pegawai ?>" data-backdrop=""><i class='fa fa-clock-o'></i></button></td>
										</tr>
								<?php
									}else{
								?>
										<tr>
											<td><?= $ap->id_pegawai ?></td>
											<td><?= $ap->nama_pegawai ?></td>
											<td><?= $ap->alamat_pegawai ?></td>
											<td><?= $ap->jabatan_pegawai ?></td>
											<td>
											<button type="button" class="open-detailModal btn btn-primary" data-toggle="modal" data-target="#myModal" data-id="<?= $ap->id_pegawai ?>" data-backdrop=""><i class='glyphicon glyphicon-info-sign'></i></button>
											</td>
										</tr>
								<?php		
									}
								}
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
