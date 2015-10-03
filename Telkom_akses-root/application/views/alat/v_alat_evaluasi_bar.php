<div class="row">
    <div class="col-md-12">
        
        <div class="panel panel-default">
            <div class="panel-body">
                <p>Gunakan search box dibawah ini untuk melihat evaluasi keluhan dan pegawai berdasarkan bulan dan tahun.</p>
                <div class="form-group">
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-search"></span>
                            </div>
                            <input class="form-control" type="text" name="tgl_select" id="SelectDatePicker">
                        </div>
                    </div>
                </div>                                   
            </div>
        </div>
        
    </div>
</div>

<div class="row" id="row_alert_keluhan">
    <div class="col-md-12" id="span-alert-keluhan">
        <div class="alert alert-info push-down-20">
            <span style="color: #FFF500;">Perhatian!</span> Tidak Ada Laporan / Evaluasi Keluhan Yang Masuk Dari Pelanggan Speedy</i>.
        </div>
    </div>
</div>

<div class="row" id="row_data_keluhan">
    <div class="col-md-4">

        <!-- START VISITORS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Evaluasi Keluhan</h3>
                    <span>Chart Keluhan Pelanggan</span>
                </div>
            </div>
            <div class="panel-body padding-0">
                <div class="chart-holder" id="chart-keluhan" style="height: 200px;"></div>
            </div>
        </div>
        <!-- END VISITORS BLOCK -->
    
    </div>

    <div class="col-md-8">

        <!-- START VISITORS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Evaluasi Keluhan</h3>
                    <span>Data Keluhan Pelanggan</span>
                </div>
            </div>
            <div class="panel-body">
                <table class="table" id="tb_ek">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Jenis Keluhan</th>
                            <th>Jumlah Keluhan</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END VISITORS BLOCK -->
    
    </div>
</div>

<div class="row" id="row_alert_pegawai">
    <div class="col-md-12" id="span-alert-pegawai">
        <div class="alert alert-info push-down-20">
            <span style="color: #FFF500;">Perhatian!</span> Tidak Ada Laporan / Evaluasi Pengerjaan Yang Masuk Dari Pegawai Speedy </i>.
        </div>
    </div>
</div>

<div class="row" id="row_data_pegawai">
    <div class="col-md-4" id="chart-col-pegawai">
    
        <!-- START VISITORS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Evaluasi Pekerjaan Pegawai</h3>
                    <span>Chart Pekerjaan Pegawai</span>
                </div>
            </div>
            <div class="panel-body padding-0">
                <div class="chart-holder" id="chart-pegawai" style="height: 200px;"></div>
            </div>
        </div>
        <!-- END VISITORS BLOCK -->
    
    </div>

    <div class="col-md-8" id="tb-col-pegawai">

        <!-- START VISITORS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Evaluasi Pekerjaan Pegawai</h3>
                    <span>Data Pekerjaan Pegawai</span>
                </div>
            </div>
            <div class="panel-body">
                <table class="table" id="tb_ep">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Teknisi</th>
                            <th>Jumlah Pekerjaan(Menunggu)</th>
                            <th>Aksi</th> 
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END VISITORS BLOCK -->
    
    </div>
</div>

