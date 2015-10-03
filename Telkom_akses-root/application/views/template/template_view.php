<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->

       	<title><?php echo $title; ?></title>           
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
	    
	    <link rel="icon" href="<?php echo base_url(); ?>assets/favicon.ico"type="image/x-icon" />
	    <!-- END META SECTION -->
	    
	    <!-- CSS INCLUDE -->        
	    <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>assets/css/theme-default.css"/>
	    <!-- EOF CSS INCLUDE -->
        <style type="text/css" media="screen">
            .img-center{
                margin:0 auto;
            }
        </style>
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
            
            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">

                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="#">ATLANT</a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>

                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="<?php echo base_url();?>assets/images/<?php echo $imgPegawai[0]->img_pegawai_small;?>" alt="<?php echo $pengguna->nama_pegawai;?>"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="<?php echo base_url();?>assets/images/<?php echo $imgPegawai[0]->img_pegawai_small;?>" alt="<?php echo $pengguna->nama_pegawai;?>"/>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name"><?php echo $imgPegawai[0]->nama_pegawai; ?></div>
                                <div class="profile-data-title"><?php echo $imgPegawai[0]->jabatan_pegawai; ?></div>
                            </div>
                            <div class="profile-controls">
                            	<?php echo anchor('setting/',"<span class='fa fa-gear'></span>",array('class'=>'profile-control-left')); ?>
                            </div>
                        </div>                                                                        
                    </li>

                    <li class="xn-title">Navigasi Menu</li>
                    <li>
                    	<?php echo anchor('beranda/view_beranda',"<span class='fa fa-desktop'></span><span class='xn-text'>Beranda</span>"); ?>                       
                    </li>                    
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Data</span></a>
                        <ul>
                            <li>
                            	<?php echo anchor('data/view_data',"Pegawai"); ?>
                            </li>
                            <li>
                            	<?php echo anchor('data/pelanggan',"Pelanggan"); ?>
                            </li>                           
                        </ul>
                    </li>
                    <?php  
                    if($pengguna->jabatan_pegawai == 'KEPALA TEKNISI' || $pengguna->jabatan_pegawai == 'MANAGER'){
                    ?>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Alat</span></a>
                        <ul>
                            <li>
                                <?php echo anchor('alat/view_alat',"Evaluasi"); ?>
                            </li>
                            <li>
                                <?php echo anchor('alat/kelola_keluhan',"Kelola Keluhan"); ?>
                            </li>
                            <li>
                                <?php echo anchor('alat/kelola_pengguna',"Kelola Pengguna"); ?>
                            </li>     
                        </ul>
                    </li>
                    <?php
                    }else if($pengguna->jabatan_pegawai == 'KARYAWAN'){
                    ?>
                    <li class="xn-openable">
                        <a href="#"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Alat</span></a>
                        <ul>
                            <li>
                                <?php echo anchor('alat/view_alat',"Evaluasi"); ?>
                            </li>
                            <li>
                                <?php echo anchor('alat/kelola_keluhan',"Kelola Keluhan"); ?>
                            </li>   
                        </ul>
                    </li>
                    <?php
                    }else{
                    ?>
                    <li>
                        <?php echo anchor('alat/view_alat',"<span class='fa fa-bar-chart-o'></span> <span class='xn-text'>Evaluasi</span>"); ?>                       
                    </li>
                    <?php    
                    }
                    ?>
                    <li>
                    	<?php echo anchor('tentang/view_tentang',"<span class='fa fa-globe'></span><span class='xn-text'>Tentang</span>"); ?>                       
                    </li>   
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">

                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->

                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                    </li> 
                    <!-- END SIGN OUT -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">                   
                    <?php  
                    if($active == '' && $title2 == ''){
                    ?>
                        <li class="active"><?= $title ?></li>
                    <?php
                    }else if($title2 != '' && $active == ''  ){
                    ?>
                        <li><a href="#"><?= $title ?></a></li>                    
                        <li class="active"><?= $title2 ?></li>
                    <?php
                    }else{
                    ?>
                        <li><a href="#"><?= $title ?></a></li>   
                        <li><a href="#"><?= $title2 ?></a></li>                  
                        <li class="active"><?= $active ?></li>
                    <?php
                    }
                    ?>
                </ul>
                <!-- END BREADCRUMB -->

                <!-- PAGE TITLE -->
                <div class="page-title">                    
                    <h2><?= $pengguna->jabatan_pegawai == 'Teknisi'?$title_sub2:$title_sub1; ?></h2>
                </div>
                <!-- END PAGE TITLE -->                         
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap"> 
                    <!--isikan data anda disini-->
                    <?= $contents ?>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                    <div class="mb-content">
                        <p>Apakah Anda Yakin Untuk Melakukan Logout?</p>                    
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                        	<?php echo anchor("login/logout/$pengguna->id_user","Ya",array('class'=>'btn btn-success btn-lg')); ?>
                            <button class="btn btn-default btn-lg mb-control-close">Tidak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->   

        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" id="mb-remove-row">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Hapus <strong>Data</strong> ?</div>
                    <div class="mb-content">
                        <p>Apakah Anda Yakin Untuk Menghapus Data Ini?</p>                    
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button class="btn btn-success btn-lg mb-control-yes">Ya</button>
                            <button class="btn btn-default btn-lg mb-control-close">Tidak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MESSAGE BOX-->            

        <!-- START MODAL PEGAWAI PREVIEW -->
        <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img id="img_pegawai" class="img-thumbnail"/> 
                            </div>
                            <div class="col-md-8">
                                <ul class="list-group border-bottom">
                                    <table class="table">
                                        <tr>
                                            <td><i>Id Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="id_pegawai_o"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Nama Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="nama_pegawai"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Jabatan Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><p id="jabatan_pegawai"></p></td>
                                        </tr>
                                        <tr>
                                            <td><i>Alamat Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="alamat_pegawai"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Email Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="email_pegawai"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Telepon HP Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="telp_hp_pegawai"></span></td>
                                        </tr>
                                    </table>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Keluar</button>                       
                    </div>
                </div>
            </div>
        </div>      
        <!-- END MODAL PEGAWAI PREVIEW -->


        <!-- START MODAL PELANGGAN PREVIEW -->
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- START GOOGLE MAP WITH MARKER -->
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-map">
                                    <div id="google_ptm_map" style="width: 100%; height: 300px;"></div>
                                </div>
                            </div>
                            <!-- END GOOGLE MAP WITH MARKER -->                       
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group border-bottom">
                                    <table class="table">
                                        <tr>
                                            <td width="30%"><i>Id Speedy</i></td>
                                            <td align="center">:</td>
                                            <td><span id="id_speedy"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Jalur Jaringan</i></td>
                                            <td align="center">:</td>
                                            <td><span id="id_msan"></span><br>
                                                <span id="id_dp"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i>Nama Pelanggan</i></td>
                                            <td align="center">:</td>
                                            <td><span id="nama_pelanggan"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Alamat Pelanggan</i></td>
                                            <td align="center">:</td>
                                            <td><p id="alamat_pelanggan"></p></td>
                                        </tr>
                                        <tr>
                                            <td><i>Telepon Rumah Pelanggan</i></td>
                                            <td align="center">:</td>
                                            <td><span id="telp_rumah_pelanggan"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Telepon HP Pelanggan</i></td>
                                            <td align="center">:</td>
                                            <td><span id="telp_hp_pelanggan"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Status</i></td>
                                            <td align="center">:</td>
                                            <td><span id="status_pelanggan"></span></td>
                                        </tr>
                                    </table>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Keluar</button>                       
                    </div>
                </div>
            </div>
        </div>      
        <!-- END MODAL PELANGGAN PREVIEW -->

        <!-- START MODAL KELUHAN PREVIEW -->
        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group border-bottom">
                                    <table class="table">
                                        <tr>
                                            <td><i>Id Speedy</i></td>
                                            <td align="center">:</td>
                                            <td><span id="id_speedy_1"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Nama Pelanggan</i></td>
                                            <td align="center">:</td>
                                            <td><span id="nama_pelanggan_1"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Alamat Pelanggan</i></td>
                                            <td align="center">:</td>
                                            <td><p id="alamat_pelanggan_1"></p></td>
                                        </tr>
                                        <tr>
                                            <td><i>Keterangan Keluhan</i></td>
                                            <td align="center">:</td>
                                            <td><span id="ket_keluhan_1"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Tanggal Laporan</i></td>
                                            <td align="center">:</td>
                                            <td><span id="tgl_laporan_1"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Jam Laporan</i></td>
                                            <td align="center">:</td>
                                            <td><span id="jam_laporan_1"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Tanggal Pengerjaan</i></td>
                                            <td align="center">:</td>
                                            <td><span id="tgl_pengerjaan_1"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Keterangan Kunjungan</i></td>
                                            <td align="center">:</td>
                                            <td><span id="ket_kunjungan_1"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Status</i></td>
                                            <td align="center">:</td>
                                            <td><span id="status_pengerjaan_1"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Teknisi</i></td>
                                            <td align="center">:</td>
                                            <td><span id="teknisi_1"></span></td>
                                        </tr>

                                    </table>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Keluar</button>                       
                    </div>
                </div>
            </div>
        </div>      
        <!-- END MODAL KELUHAN PREVIEW -->

        <!-- START MODAL RIWAYAT PEGAWAI PREVIEW -->
        <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
 					<div class="modal-body">
                        <div class="row">
                        	<div class="col-md-12">
                                <ul class="list-group border-bottom">
                                    <table class="table">
                                        <tr>
                                            <td width="30%"><i>Id Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="id_pegawai_x"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Nama Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="nama_pegawai_x"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Pekerjaan</i></td>
                                            <td align="center">:</td>
                                            <td><p id="jml_pekerjaan_x"></p></td>
                                        </tr>
                                        <tr>
                                            <td><i>Bulan</i></td>
                                            <td align="center">:</td>
                                            <td>
                                                <select name="selectRiwayat" id="selectRiwayat" class="form-control select">
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
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group border-bottom">
                                    <table class="table" id='table_riwayat'>
                                        <thead>
                                        	<tr>
                                        		<th>Id Speedy</th>
                                        		<th>Nama Pelanggan</th>
                                        		<th>Jenis Keluhan</th>
                                        		<th>Tanggal Laporan</th>
                                        		<th>Tanggal Pengerjaan</th>
                                                <th>Tanggal Kunjungan</th>
                                        		<th>Jam Kunjungan</th>
                                        		<th>Status</th>
                                        	</tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Keluar</button>                       
                    </div>
                </div>
            </div>
        </div>      
        <!-- END MODAL RIWAYAT PEGAWAI PREVIEW -->

        <!-- START MODAL RIWAYAT EVALUASI PEGAWAI PREVIEW -->
        <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group border-bottom">
                                    <table class="table">
                                        <tr>
                                            <td width="30%"><i>Id Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="id_pegawai_y"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Nama Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="nama_pegawai_y"></span></td>
                                        </tr>
                                    </table>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group border-bottom">
                                    <table class="table" id='table_RE'>
                                        <thead>
                                            <tr>
                                                <th>Id Speedy</th>
                                                <th>Nama Pelanggan</th>
                                                <th>Jenis</th>
                                                <th>Tanggal Laporan</th>
                                                <th>Tanggal Pengerjaan</th>
                                                <th>Tanggal Kunjungan</th>
                                                <th>Jam Kunjungan</th>
                                                <th>Status</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Keluar</button>                       
                    </div>
                </div>
            </div>
        </div>      
        <!-- END MODAL RIWAYAT EVALUASI PEGAWAI PREVIEW -->

        <!-- START MODAL RIWAYAT LOG PREVIEW -->
        <div class="modal fade" id="myModal5" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group border-bottom">
                                    <table class="table">
                                        <tr>
                                            <td width="30%"><i>Id Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="id_pegawai_s"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Nama Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="nama_pegawai_s"></span></td>
                                        </tr>                                        
                                        <tr>
                                            <td><i>Jabatan Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="jabatan_pegawai_s"></span></td>
                                        </tr>          
                                        <tr>
                                            <td><i>Email Pegawai</i></td>
                                            <td align="center">:</td>
                                            <td><span id="email_pegawai_s"></span></td>
                                        </tr>
                                        <tr>
                                            <td><i>Bulan</i></td>
                                            <td align="center">:</td>
                                            <td>
                                                <select name="selectLogin" id="selectLogin" class="form-control select">
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
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group border-bottom">
                                    <table class="table" id='table_L'>
                                        <thead>
                                            <tr>
                                                <th rowspan="2">No</th>
                                                <th colspan="2">Login</th>
                                                <th colspan="2">Logout</th>
                                            </tr>
                                            <tr>
                                            	<th>Tanggal Login</th>
                                            	<th>Jam Login</th>
                                            	<th>Tanggal Logout</th>
                                            	<th>Jam Logout</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Keluar</button>                       
                    </div>
                </div>
            </div>
        </div>      
        <!-- END MODAL RIWAYAT LOG PREVIEW -->

         <!-- START MODAL SETTING CHANGE IMAGE -->
        <div class="modal fade" id="modalSetting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                       <div id="cropContainerEyecandy"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="close-setting-img">Keluar</button>                       
                    </div>
                </div>
            </div>
        </div>      
        <!-- END MODAL SETTING CHANGE IMAGE PREVIEW -->


    	<!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
    
        <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/plugins/icheck/icheck.min.js'></script>        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/scrolltotop/scrolltopcontrol.js"></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/morris/raphael-min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/morris/morris.min.js"></script>                
        <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap-datepicker.js'></script>                
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/owl/owl.carousel.min.js"></script> 

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap-colorpicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>                
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/jquery-mousewheel/jquery.mousewheel.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/croppic/croppic.min.js"></script>
        <!-- END THIS PAGE PLUGINS-->        

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/datatables/jquery.dataTables.min.js"></script>            
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins.js"></script>        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/actions.js"></script>
        <script type='text/javascript' src='<?php echo base_url(); ?>assets/js/plugins/jquery-validation/jquery.validate.js'></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/plugins/fileinput/fileinput.min.js"></script>
        <!-- END TEMPLATE -->
    	<!-- END SCRIPTS --> 
        <script type="text/javascript">
            var form_alamat = $('#form_alamat').validate({
                ignore:[],
                rules:{
                    alamat_pegawai:{
                        required: true,
                        minlength: 10,
                        maxlength: 100
                    }
                }
            });
            var form_telp = $('#form_telp').validate({
                ignore:[],
                rules:{
                    telepon_pegawai:{
                        required: true,
                        maxlength:12,
                        minlength:11,
                        number:true
                    }
                }
            });
            var form_email = $('#form_email').validate({
                ignore:[],
                rules:{
                    email_pegawai:{
                        required: true,
                        email: true
                    }
                }
            });
            var form_pass = $('#form_pass_setting').validate({
                ignore:[],
                rules:{
                    pass_pegawai_change:{
                        required: true
                    },
                    pass_pegawai_confirm:{
                        required:true,
                        equalTo:'#pass_pegawai_change'
                    },
                    pass_pegawai_ago:{
                        required:true
                    }
                }
            });

            //rules validation pegawai
            var jvalidate = $("#jvalidate").validate({
                ignore: [],
                rules: {                                            
                        id_pegawai: {
                                required: true,
                                minlength: 11,
                                maxlength: 11,
                                number:true
                        },
                        id_speedy:{
                                required:true,
                                minlength:11,
                                maxlength:12,
                                number:true
                        },
                        nama_pelanggan:{
                                required: true,
                                minlength: 6
                        },
                        nama_pegawai: {
                                required: true,
                                minlength: 6
                        },
                        alamat_pegawai: {
                                required: true,
                                minlength: 10,
                                maxlength: 100
                        },
                        alamat_pelanggan:{
                                required: true,
                                minlength: 10,
                                maxlength: 100
                        },
                        email_pegawai: {
                                required: true,
                                email: true
                        },
                        telp_hp_pegawai: {
                                required: true,
                                maxlength:12,
                                minlength:11,
                                number:true
                        },
                        telp_hp_pelanggan:{
                                required: true,
                                maxlength:12,
                                minlength:11,
                                number:true
                        },
                        telp_rumah_pelanggan:{
                                required: true,
                                maxlength:12,
                                minlength:11,
                                number:true
                        },
                        img_pegawai: {
                                required: true
                        },
                        ket_keluhan :{
                                required:true,
                                minlength:10
                        }
                    }                                        
            });
        
        var croppicContainerEyecandyOptions = {
            uploadUrl:'change_img_pegawai',
            cropUrl:'image_cropping',
            imgEyecandy:false,
            modal:false,
            doubleZoomControls:false,
            rotateControls: false,              
            loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
            onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
            onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
            onImgDrag: function(){ console.log('onImgDrag') },
            onImgZoom: function(){ console.log('onImgZoom') },
            onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
            onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
            onError:function(errormessage){ console.log('onError:'+errormessage) }
        }
        var cropContainerEyecandy = new Croppic('cropContainerEyecandy', croppicContainerEyecandyOptions);


        </script>    
    </body>
</html>






