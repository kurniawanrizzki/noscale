<!-- VIEW BERANDA -->
<div class="row">
<?php  
if($pengguna->jabatan_pegawai == 'MANAGER'){ 
    //digunakan manager
	if(count($pegawai) > 0){
		foreach ($pegawai as $dp) {
    # code...
    ?>
		    <div class="col-md-12">
		        <!-- CONTACT ITEM -->
		        <div class="panel panel-default">
		            <div class="panel-body profile">
		                <div class="profile-image">
		                    <img src="<?php echo base_url();?>assets/images/<?php echo $dp->img_pegawai_small;?>" alt="<?php echo $dp->nama_pegawai;?>"/>
		                </div>
		                <div class="profile-data">
		                    <div class="profile-data-name"><?= $dp->nama_pegawai ?></div>
		                    <div class="profile-data-title"><?= $dp->jabatan_pegawai ?></div>
		                </div>
		            </div> 

		            <div class="panel-body">                                    
		                <div class="contact-info">
		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                            <div class="panel-title-box">
		                                <h3>Jadwal Pekerjaan</h3>
		                                <span>Rincian Jadwal Pekerjaan</span>
		                            </div>                                    
		                            <ul class="panel-controls" style="margin-top: 2px;">
		                                <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>                                     
		                            </ul>
		                        </div>

		                        <div class="panel-body panel-body-table">
		                            
		                            <div class="table-responsive">
		                                <table class="table table-bordered table-striped">
		                                    <thead>
		                                        <tr>
		                                            <th width="10%">Id Speedy</th>
		                                            <th width="20%">Nama</th>
		                                            <th width="30%">Alamat</th>
		                                            <th width="10%">Telepon</th>
		                                            <th width="10%">Jenis</th>
		                                            <th width="5%">Status</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                        <?php
		                                        //digunakan untuk mendapatkan jadwal per pegawai 
		                                        $jadwal = $this->m_beranda->getJadwal($dp->id_pegawai);
		                                        $jpp = count($jadwal); 
		                                        if($jpp != null){    
		                                            foreach ($jadwal as $jd) {
		                                                # code...
		                                            ?>
													<tr>
		                                            <td><?= $jd->id_speedy ?></td>
		                                            <td><?= $jd->nama_pelanggan ?></td>
		                                            <td><?= $jd->alamat_pelanggan ?></td>
		                                            <td><?= $jd->telp_hp_pelanggan ?></td>
		                                            <td><?= $jd->jenis_keluhan ?></td>
		                                            <td>
		                                            <?php
		                                                if($jd->status_kunjungan == 'SELESAI'){
		                                            ?>
		                                                <span class="label label-success">SELESAI</span>
		                                            <?php
		                                                }else{
		                                            ?>
		                                                <span class="label label-warning">MENUNGGU</span>
		                                            <?php
		                                                } 
		                                            ?></td>
													</tr>
		                                            <?php
		                                            }
		                                        ?>
		                                        <?php
		                                        }else{
		                                        ?>
		                                            <td colspan="7"><strong>Tidak Ada Pekerjaan Yang Aktif</strong></td>
		                                        <?php
		                                        } ?>
		                                    </tbody>
		                                </table>
		                            </div>
		                            
		                        </div>
		                    </div>
		                    <!-- END PROJECTS BLOCK -->                                 
		                </div>
		            </div>                                
		        </div>
		        <!-- END CONTACT ITEM -->
		    </div>
    <?php
    	}
	}else{
	?>
    	<div class="col-md-12">
	        <div class="alert alert-info push-down-20">
	            <span style="color: #FFF500;">Perhatian!</span> Tidak ada teknisi yang aktif. Untuk Menambahkan Pegawai/Teknisi Silahkan Ke Menu <i><strong><?= anchor('data/','Data Pegawai');?></strong></i>.
	        </div>
	    </div>
	<?php
	}

}else if($pengguna->jabatan_pegawai == 'KEPALA TEKNISI' || $pengguna->jabatan_pegawai == 'KARYAWAN'){
//digunakan untuk kepala teknisi dan karyawan 
    if(count($pegawai)>0){
    	foreach ($pegawai as $dp) {
    		# code...
    ?>
		   	<div class="col-md-12">
		        <!-- CONTACT ITEM -->
		        <div class="panel panel-default">
		            <div class="panel-body profile">
		                <div class="profile-image">
		                    <img src="<?php echo base_url();?>assets/images/<?php echo $dp->img_pegawai_small;?>" alt="<?php echo $dp->nama_pegawai;?>"/>
		                </div>
		                <div class="profile-data">
		                    <div class="profile-data-name"><?= $dp->nama_pegawai ?></div>
		                    <div class="profile-data-title"><?= $dp->jabatan_pegawai ?></div>
		                </div>
		                <!--<div class="profile-controls">
		                    <a href="#" class="profile-control-left"><span class="fa fa-info"></span></a>
		                    <a href="#" class="profile-control-right"><span class="fa fa-eye"></span></a>
		                </div> -->
		            </div>                                
		            <div class="panel-body">                                    
		                <div class="contact-info">
		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                            <div class="panel-title-box">
		                                <h3>Jadwal Pekerjaan</h3>
		                                <span>Rincian Jadwal Pekerjaan</span>
		                            </div>                                    
		                            <ul class="panel-controls" style="margin-top: 2px;">
		                                <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>                                     
		                            </ul>
		                        </div>
		                        <div class="panel-body panel-body-table">
		                            
		                            <div class="table-responsive">
		                                <table class="table table-bordered table-striped">
		                                    <thead>
		                                        <tr>
		                                            <th width="10%">Id Speedy</th>
		                                            <th width="20%">Nama</th>
		                                            <th width="30%">Alamat</th>
		                                            <th width="10%">Telepon</th>
		                                            <th width="10%">Jenis</th>
		                                            <th width="5%">Status</th>
		                                            <th width="5%">Aksi</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                        <?php 
		                                        //digunakan untuk menampilkan jadwal per pegawai
		                                        $jadwal = $this->m_beranda->getJadwal($dp->id_pegawai);
		                                        $jpp = count($jadwal); 
		                                        if($jpp != null){    
		                                            foreach ($jadwal as $jd) {
		                                                # code...
		                                            ?>
		                                            <tr id="<?=$jd->id_kunjungan?>">
		                                                <td><?= $jd->id_speedy ?></td>
		                                                <td><?= $jd->nama_pelanggan ?></td>
		                                                <td><?= $jd->alamat_pelanggan ?></td>
		                                                <td><?= $jd->telp_hp_pelanggan ?></td>
		                                                <td><?= $jd->jenis_keluhan ?></td>
			                                            <td>
			                                            <?php
			                                                if($jd->status_kunjungan == 'SELESAI'){
			                                            ?>
			                                                <span class="label label-success">SELESAI</span>
			                                            <?php
			                                                }else{
			                                            ?>
			                                                <span class="label label-warning">MENUNGGU</span>
			                                            <?php
			                                                } 
			                                            ?></td>
		                                                <td>
		                                                    <button class="btn btn-danger" onClick="delete_row_on_tb_jadwal('<?= $jd->id_kunjungan ?>,<?= $jd->id_jadwal ?>');"><i class='glyphicon glyphicon-trash'></i></button>
		                                                </td>
		                                            </tr>
		                                            <?php
		                                            }
		                                        ?>
		                                        <?php
		                                        }else{
		                                        ?>  <tr>
		                                                <td colspan="7"><strong>Tidak Ada Pekerjaan Yang Aktif</strong><?= anchor('beranda/add_jadwal_by_id/'.$dp->id_pegawai,', <strong><i>Tambahkan Jadwal Hari Ini</i></strong>'); ?></td>
		                                            </tr>
		                                        <?php
		                                        } ?>
		                                    </tbody>
		                                </table>
		                            </div>
		                            
		                        </div>
		                    </div>
		                    <!-- END PROJECTS BLOCK -->                                 
		                </div>
		            </div>                                
		        </div>
		        <!-- END CONTACT ITEM -->
		    </div>
	    <?php
    	}
    }else{
    ?>
    	<div class="col-md-12">
	        <div class="alert alert-info push-down-20">
	            <span style="color: #FFF500;">Perhatian!</span> Tidak ada teknisi yang aktif. Untuk Menambahkan Pegawai/Teknisi Silahkan Ke Menu <i><strong><?= anchor('data/','Data Pegawai');?></strong></i>.
	        </div>
	    </div>
    <?php
    }
  
}else{
//digunakan untuk teknisi
?>
    <div class="col-md-12">
        <!-- CONTACT ITEM -->
        <div class="panel panel-default">
            <div class="panel-body profile">
                <div class="profile-image">
                    <img src="<?php echo base_url();?>assets/images/<?php echo $imgPegawai[0]->img_pegawai_small;?>" alt="<?php echo $imgPegawai[0]->nama_pegawai;?>"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name"><?php echo $imgPegawai[0]->nama_pegawai;?></div>
                    <div class="profile-data-title"><?php echo $imgPegawai[0]->jabatan_pegawai;?></div>
                </div>

            </div>                                
            <div class="panel-body">                                    
                <div class="contact-info">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title-box">
                                <h3>Jadwal Pekerjaan</h3>
                                <span>Rincian Jadwal Pekerjaan</span>
                            </div>                                    
                            <ul class="panel-controls" style="margin-top: 2px;">
                                <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>                                      
                            </ul>
                        </div>
                        <div class="panel-body panel-body-table">
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="10%">Id Speedy</th>
                                            <th width="20%">Nama</th>
                                            <th width="30%">Alamat</th>
                                            <th width="10%">Telepon</th>
                                            <th width="10%">Jenis</th>
                                            <th width="5%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        //digunakan untuk menampilkan jadwal per pegawai
                                        $jadwal = $this->m_beranda->getJadwal($pengguna->id_pegawai);
                                        $jpp = count($jadwal); 
                                        if($jpp != null){    
                                            foreach ($jadwal as $jd) {
                                                # code...
                                            ?>
											<tr>
                                            <td><?= $jd->id_speedy ?></td>
                                            <td><?= $jd->nama_pelanggan ?></td>
                                            <td><?= $jd->alamat_pelanggan ?></td>
                                            <td><?= $jd->telp_hp_pelanggan ?></td>
                                            <td><?= $jd->jenis_keluhan ?></td>
                                            <td>
                                            <?php
                                                if($jd->status_kunjungan == 'SELESAI'){
                                            ?>
                                                <span class="label label-success">SELESAI</span>
                                            <?php
                                                }else{
                                            ?>
                                                <span class="label label-warning">MENUNGGU</span>
                                            <?php
                                                } 
                                            ?></td>
                                            </tr>
                                            <?php
                                            }
                                        ?>
                                        <?php
                                        }else{
                                        ?>
                                            <td colspan="7"><strong>Tidak Ada Pekerjaan Yang Aktif</strong></td>
                                        <?php
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!-- END PROJECTS BLOCK -->                                 
                </div>
            </div>                                
        </div>
        <!-- END CONTACT ITEM -->
    </div>
<?php   
}
?>
</div>






