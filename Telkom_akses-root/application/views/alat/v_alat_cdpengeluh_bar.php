<!--CARI PELANGGAN VIEW-->

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
                            <th>Id Speedy</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat Pelanggan</th>
                            <th>Telepon Selular Pelanggan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php 
						
						foreach ($pelanggan as $ap) {
						?>
						<tr>
							<td><?= $ap->id_speedy ?></td>
							<td><?= $ap->nama_pelanggan ?></td>
							<td><?= $ap->alamat_pelanggan ?></td>
							<td><?= $ap->telp_hp_pelanggan ?></td>
							<td><?= anchor('alat/view_to_insert_keluhan/'.$ap->id_speedy,"<span class='fa fa-plus'></span> Tambah Keluhan",array('class'=>'btn btn-success btn-block')); ?></td>
						</tr>
						<?php
						}
						?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->
    </div>
</div>

