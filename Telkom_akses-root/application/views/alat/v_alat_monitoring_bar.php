<!--about_view-->
<html>
	<head>
		<title><?php echo $title; ?></title>
		<style type="text/css">
			body{
				background-color: #FFF;
				margin:40px;
				font:13px/20px normal helvetica, Arial, sans-serif;
			}

			a{
				color:#003399;
				background-color: transparent;
				font-weight: normal; 
			}

			h1{
				color:#444;
				background-color: transparent;
				border-bottom: 1px solid #D0D0D0;
				font-size:  16px;
				padding: 3px 15px 10px 15px;
				font-weight: bold;
			}

			h2{
				padding: 3px 15px 10px 15px;
			}

			#body{
				margin: 0 15px 0 15px;
				border-bottom: 1px solid #D0D0D0;
			}

			p.footer{
				text-align: right;
				font-size: 11px;
				border-top: 1px solid #D0D0D0;
				line-height: 32px;
				padding: 0 10px 0 10px;
			}

			#container{
				margin: 10px;
				border: 1px solid #D0D0D0;
				-webkit-box-shadow:0 0 8px #D0D0D0;
			}
			.data{
				color:#444;
				background-color: transparent;
				font-size:  16px;
				margin: 3px 0;
				padding: 3px 15px 10px 15px;
				font-weight: bold;
			}

			td{
				font-weight: bold;
				font-size: 12px;
			}
			.head{
				padding: 3px 15px 10px 15px;
				float: right;
			}
		</style>
	</head>
	<body>
		<div id="container">
			<h1><?php echo $title; ?></h1>
			<div class="head"><?php echo 'Selamat Datang '.$pengguna->nama_pegawai.'! | '.$pengguna->jabatan_pegawai; ?></div>
			<div id="body">
				<ul>
					<li><?php echo anchor('Beranda','Beranda'); ?></li>
					<li><?php echo anchor('Data','Data'); ?></li>
					<li><?php echo anchor('Alat','Alat'); ?></li>
					<li><?php echo anchor('Tentang','Tentang'); ?></li>
					<li><?php echo anchor('Login/Logout','Log Out'); ?></li>
				</ul>
			</div>

			<h2>Data Monitoring</h2>
			<table class="data">
				<?php 
				foreach ($user as $us) {
					# code...
				?>
				<tr>
					<td>Id Pegawai</td>
					<td>:</td>
					<td><?php echo $us->id_pegawai; ?></td>
				</tr>
				<tr>
					<td>Nama Pegawai</td>
					<td>:</td>
					<td><?php echo $us->nama_pegawai; ?></td>
				</tr>
				<tr>
					<td>Jabatan Pegawai</td>
					<td>:</td>
					<td><?php echo $us->jabatan_pegawai; ?></td>
				</tr>
				<tr>
					<td>Email Pegawai</td>
					<td>:</td>
					<td><?php echo $us->email_pegawai; ?></td>
				</tr>
				<tr>
					<td colspan="3">&nbsp</td>
				</tr>
				<?php
				}
				?>
			</table>
			<br>
			<table class="data">
						<tr>
							<th>No</th>
							<th>Login</th>
							<th>Logout</th>
						</tr>
				<?php  
				if(count($login)>0){
					$no = 0;
					foreach ($login as $lg) {
						
				?>
						<tr>
							<td><?php echo ++$no; ?></td>
							<td><?php echo $lg->login; ?></td>
							<td align="center"><?php echo $lg->logout == '0000-00-00 00:00:00'?'ONLINE':$lg->logout; ?></td>
						</tr>
				<?php
					} 
				}else{
				?>
					<tr>
						<td><strong><i>Belum Ada Log Terdata</i></strong></td>
					</tr>
				<?php	
				}
				?>
			</table>
			<div class="data">
			<?php 
				echo $link_back;
			?>
			</div>
			<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
		</div>
	</body>
</html>