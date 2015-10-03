<!--DATA VIEW KELOLA PENGGUNA-->

<div class="row">
    <div class="col-md-12">

        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">                                
                <h3 class="panel-title">Data Pelanggan</h3>
                <ul class="panel-controls">
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                </ul>                                
            </div>
            <div class="panel-body">
                <table class="table datatable">
                    <thead>
					    <tr>
                            <th>Id Pegawai</th>
                            <th>Nama Pegawai</th>
                            <th>Jabatan Pegawai</th>
                            <th>Id Email</th>
                            <th>Aktivasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php  
						foreach ($penggunay as $pgn) {
							# code...
							if($pengguna->jabatan_pegawai == 'KEPALA TEKNISI'){
							?>
							<tr>
								<td><?= $pgn->id_pegawai ?></td>
								<td><?= $pgn->nama_pegawai ?></td>
								<td><?= $pgn->jabatan_pegawai ?></td>
								<td><?= $pgn->email_pegawai ?></td>
								<td>
								<?php  
									if($pgn->jabatan_pegawai == 'TEKNISI'){
										echo anchor('alat/grant_user/'.$pgn->id_user,$pgn->grant_status,array('class'=>'grant'));
									}else{
										echo $pgn->grant_status;	
									}
								?>
								</td>
								<td><?php
								if($pgn->grant_status == 'ON' AND $pgn->jml_login != 0){
								?>	
									<a href="#" class="open-detailLModal btn btn-primary" data-toggle="modal" data-target="#myModal5" data-id="<?= $pgn->id_user ?>" data-backdrop="">Lihat Log</a>
								<?php
									if($pgn->jabatan_pegawai == 'TEKNISI'){
										echo anchor('alat/default_password/'.$pgn->id_user,'Pemulihan Sandi',array('class'=>'btn btn-primary'));		
									}
								}else{
									echo '---';
								}
								?></td>
							</tr>
							<?php
							}else{
							?>
							<tr>
								<td><?= $pgn->id_pegawai ?></td>
								<td><?= $pgn->nama_pegawai ?></td>
								<td><?= $pgn->jabatan_pegawai ?></td>
								<td><?= $pgn->email_pegawai ?></td>
								<td>
								<?php  
									echo anchor('alat/grant_user/'.$pgn->id_user,$pgn->grant_status,array('class'=>'grant'));
								?>
								</td>
								<td><?php
								if($pgn->grant_status == 'ON' AND $pgn->jml_login != 0){
								?>	
									<a href="#" class="open-detailLModal btn btn-primary" data-toggle="modal" data-target="#myModal5" data-id="<?= $pgn->id_user ?>" data-backdrop="">Lihat Log</a>
								<?php
									echo anchor('alat/default_password/'.$pgn->id_user,'Pemulihan Sandi',array('class'=>'btn btn-primary'));		
								}else{
									echo '---';
								}
								?></td>
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














