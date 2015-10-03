<!-- DATA VIEW KELUHAN -->

<div class="row">
    <div class="col-md-12">

        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">                                
                <h3 class="panel-title">Data Pelanggan</h3>
                <ul class="panel-controls">
                    <li><select name="selectBulan" id="SelectBulanKeluhan" class="form-control select">
                        <option value="0">Semua</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select></li>
                	<?php 
                    if($pengguna->jabatan_pegawai == 'KARYAWAN' || $pengguna->jabatan_pegawai == 'KEPALA TEKNISI'){ 
                    ?>
                    <li><a href="../alat/cari_data_pelanggan" class="panel-plus"><span class="fa fa-plus"></span></a></li>
                    <?php
                    }   
                    ?>
                    <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                </ul>                                
            </div>
            <div class="panel-body">
                <table class="table datatable" id="table_search">
                    <thead>
	                    <tr>
                            <th width="12%">Id Speedy</th>
                            <th width="20%">Nama Pelanggan</th>
                            <th width="13%">Jenis Keluhan</th>
                            <th width="20%">Teknisi</th>
                            <th width="15%">Status</th>
                            <th width="18%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <?php 
                    if($tot_unfinul != 0){
                     echo anchor('#',$tot_unfinul.' Keluhan <strong><i>Belum Terjadwal</i></strong> dan <strong><i>MENUNGGU</i></strong>',array('id'=>'preview-uf'));
                    }
                    echo " &nbsp;&nbsp;&nbsp; ";
                    if($tot_hari_ini != 0){
                     echo anchor('#',$tot_hari_ini.' Keluhan <strong><i>Hari Ini</i></strong>',array('id'=>'preview-hi'));
                    }
                ?>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default" id="data1" style="display:none">
            <div class="panel-heading">                                
                <h3 class="panel-title">Daftar Keluhan Yang <i>Belum Terjadwal</i> dan <i>MENUNGGU</i></h3>
                <ul class="panel-controls">
                    <li><a href="#" id="remove-uf"><span class="fa fa-times"></span></a></li>
                </ul>                                
            </div>
            <div class="panel-body">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th width="12%">Id Speedy</th>
                            <th width="20%">Nama Pelanggan</th>
                            <th width="13%">Jenis Keluhan</th>
                            <th width="20%">Teknisi</th>
                            <th width="12%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                        foreach ($keluhan_UF as $ku) {
                            # code...
                        ?>
                            <tr>
                                <td><?= $ku->id_speedy ?></td>
                                <td><?= $ku->nama_pelanggan ?></td>
                                <td><?= $ku->jenis_keluhan ?></td>
                                <td><?= $ku->teknisi == NULL?"<span class='label label-default'>Belum Terjadwal</span>":$ku->teknisi ?></td>
                                <td><?= $ku->teknisi == NULL?"<span class='label label-default'>Belum Terjadwal</span>":($ku->status_kunjungan == 'SELESAI'?"<span class='label label-success'>SELESAI</span>":"<span class='label label-warning'>MENUNGGU</span>") ?></td>
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
<div class="row">
    <div class="col-md-12">
        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default" id="data2" style="display:none">
            <div class="panel-heading">                                
                <h3 class="panel-title">Daftar Keluhan <i>Hari Ini</i></h3>
                <ul class="panel-controls">
                    <li><a href="#" id="remove-hi"><span class="fa fa-times"></span></a></li>
                </ul>                                
            </div>
            <div class="panel-body">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th width="12%">Id Speedy</th>
                            <th width="20%">Nama Pelanggan</th>
                            <th width="13%">Jenis Keluhan</th>
                            <th width="20%">Teknisi</th>
                            <th width="12%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                        foreach ($keluhan_HI as $kh) {
                            # code...
                        ?>
                            <tr>
                                <td><?= $kh->id_speedy ?></td>
                                <td><?= $kh->nama_pelanggan ?></td>
                                <td><?= $kh->jenis_keluhan ?></td>
                                <td><?= $kh->teknisi == NULL?"<span class='label label-default'>Belum Terjadwal</span>":$kh->teknisi ?></td>
                                <td><?= $kh->teknisi == NULL?"<span class='label label-default'>Belum Terjadwal</span>":($kh->status_kunjungan == 'SELESAI'?"<span class='label label-success'>SELESAI</span>":"<span class='label label-warning'>MENUNGGU</span>") ?></td>
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


