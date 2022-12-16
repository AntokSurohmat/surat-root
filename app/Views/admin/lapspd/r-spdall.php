<!DOCTYPE html>
<html lang="en">
<!-- print All recap SPD -->
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Print All Recap SPD </title>
	<!-- <link type="text/css"  href="assets/AdminLTE/dist/css/adminlte.min.css" rel="stylesheet"> -->
	<link type="text/css" href="assets/custom/css/style.css" rel="stylesheet">
	<style>
		body {
			margin: 0;
			font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
			font-size: 15px;
			font-weight: 400;
			line-height: 1;
			color: #212529;
			text-align: left;
			background-color: #fff;
		}

		.mb-0,
		.my-0 {
			margin-bottom: 0 !important;
		}

		.mb-3,
		.my-3 {
			margin-bottom: 1rem !important;
		}

		.mr-5,
		.mx-5 {
			margin-right: 3rem !important;
		}

		table {
			border-collapse: collapse;
		}

		th {
			text-align: inherit;
			text-align: -webkit-match-parent;
		}
		.table-line{
			width: 100%;
			color: #212529;
			background-color: transparent;
			border: 1px solid !important;
		}
		.table-line th,
		.table-line td {
			vertical-align: top;
			border: 1px solid !important;
		}
		.table {
			width: 100%;
			margin-bottom: 1rem;
			color: #212529;
			background-color: transparent;
		}

		.table th,
		.table td {
			padding: 0.75rem;
			vertical-align: top;
			border: 1px solid #212529;
		}

		.table thead th {
			vertical-align: bottom;
			border-bottom: 2px solid #212529;
		}

		.table tbody+tbody {
			border-top: 2px solid #dee2e6;
		}

		p {
			margin-top: 0;
			margin-bottom: 0;
		}
	</style>
</head>

<body>

	<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
	<table border="0" width=100% cellpadding=2 cellspacing=0 style="margin-top: 5px; text-align:center">
		<tr>
			<td width=15%>
				<img src="assets/custom/img/logo.png" alt="" style="height:120px;">
			</td>
			<td width=85%>
				<p style="font-size:18px;text-align:center;line-height: 1em;font-weight:500;margin-block-start: 0em;margin-block-end: 0em;" class="mb-0 mr-5">PEMERINTAH KABUPATEN CIREBON</p>
				<p style="font-size:18px;text-align:center;line-height: 1em;font-weight:800;margin-bottom:8px;" class=" mr-5">DINAS PERDAGANGAN DAN PERINDUSTRIAN</p>
				<p style="font-size:16px;text-align:center;line-height: 16px;" class="mb-0 mr-5">Jl. Sunan Kalijaga Nomor 10</p>
				<p style="font-size:16px;text-align:center;line-height: 16px;margin-bottom:8px;" class="mr-5">Pusat Pemerintah Cirebon Telp.(0231) 321495 - 321073</p>
				<table width=100%>
					<tr>
						<td width=80% style="font-size:18px;text-align:center;line-height: 1em;font-weight:800;padding-left:20%;">SUMBER</td>
						<td width=20% style="text-align: right;">45611</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div width=100%>
		<hr class="s5 mt-0" style="margin-bottom: 10px;">
	</div>
	<table style="margin: 0 auto;margin-top: 5px; text-align:center" border="0" cellpadding=2 cellspacing=0>
		<tbody>
			<tr>
				<td style="font-size:18px;text-align:center;line-height: 1.1em;font-weight:500;text-align:center;">
					REKAPITULASI LAPORAN
				</td>
			</tr>
			<tr>
				<td style="font-size:18px;text-align:center;line-height: 1.1em;font-weight:500;text-align:center;">
					SURAT PERJALANAN DINAS
				</td>
			</tr>
		</tbody>
	</table>
	<table style="margin-top: 15px;" width=100% border="0" cellpadding=2 cellspacing=0>
		<tbody>
			<tr>
			<td width=33% style=vertical-align:top>
					<table border="0" width=100%>
						<tr>
							<td width=60% style="padding: 2px;">No. SPD</td>
							<td width=3% style="padding: 2px;">: </td>
							<td style="padding: 2px 10px;"> <?= $spd['kode']?> </td>
						</tr>

						<tr>
							<td width=60% style="padding: 2px;">Pejabat Yang Memerintah</td>
							<td width=3% style="padding: 2px;">: </td>
							<td style="padding: 2px 10px;"> 
								<?php foreach ($memerintah as $yang_key => $yang_value) {
										if($yang_key == 'nama'){
											echo $yang_value;
										}
									}?>
							</td>
						</tr>
						<tr>
							<td width=60% style="padding: 2px;">Pegai Yang diperintah</td>
							<td width=3% style="padding: 2px;">: </td>
							<td style="padding: 2px 10px;"> 
								<?php foreach ($diperintah as $diperin_key => $diperin_value) {
										if($diperin_key == 'nama'){
											echo $diperin_value;
										}
									}?>
							</td>
						</tr>
					</table>
				</td>
				<td width=33% style=vertical-align:top>
				<table border="0" width=100%>
						<tr>
							<td width=57% style="padding: 2px;">Nama Instansi</td>
							<td width=3% style="padding: 2px;">: </td>
							<td style="padding: 2px 10px;"> 
								<?php foreach ($instansi as $inst_key => $inst_value) {
									if($inst_key == 'nama_instansi'){
										echo $inst_value;
									}
								}?>
							</td>
						</tr>
						<tr>
							<td width=57% style="padding: 2px">Maksud Perjalanan Dinas</td>
							<td width=3% style="padding: 2px;">: </td>
							<td style="padding: 2px 10px;"><?= $spd['untuk']?></td>
						</tr>
					</table>
				</td>
				<td width=33% style="vertical-align: top;">

					<table border="0" width=100%>
						<tr>
							<td width=50% style="padding: 2px;">Tanggal Pergi</td>
							<td width=3% style="padding: 2px;">: </td>
							<td style="padding: 2px 10px;"> <?= date('d-m-Y', strtotime($spd['awal'])) ?> </td>
						</tr>
						<tr>
							<td width=50% style="padding: 2px;">Tanggal Kembali</td>
							<td width=3 style="padding: 2px;">: </td>
							<td style="padding: 2px 10px;"> <?= date('d-m-Y', strtotime($spd['akhir'])) ?> </td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>

	<table  width=100% border="1" style="margin-top:5px;">
		<thead>
			<tr>
				<th style="width: 5%;padding:2px;">No. SPD</th>
				<th>Pejabat Yang Memerintah</th>
				<th>Pegawai Yang Diperintah</th>
				<th>Tingkat Biaya Perjalanan</th>
				<th>Maksud Perjalanan Dinas</th>
				<th>Jenis Transportasi</th>
				<th style="width:90px;">Nama Instansi</th>
				<th style="width:80px;">Tanggal Pergi</th>
				<th style="width:80px;">Tanggal Kembali</th>
				<th>Pengikut</th>
			</tr>
		</thead>
		<tbody>
				<?php foreach($spd_all as $key_spd => $table_spd) :?>
					<tr>
						<td style="width: 5%;padding: 0px 10px;"><p><?= $table_spd->kode?></p></td>
						<td style="padding: 0px 10px;">
						<?php foreach($memerintah_all as $key_memerintah => $table_memerin) :?>
								<?php foreach($table_memerin as $meperintah_data) :?>
									<?php if($key_spd == $key_memerintah) :?>
										<?= $meperintah_data->nama?>
									<?php endif;?>
								<?php endforeach?>
							<?php endforeach;?>
						</td>
						<td style="padding: 0px 10px;">
						<?php foreach($diperintah_all as $key_diperintah => $table_diperin) :?>
								<?php foreach($table_diperin as $diperintah_data) :?>
									<?php if($key_spd == $key_diperintah) :?>
										<?= $diperintah_data->nama?>
									<?php endif;?>
								<?php endforeach?>
							<?php endforeach;?>
						</td>
						<td style="padding: 0px 10px;"><p><?= $table_spd->tingkat_biaya?></p></td>
						<td style="padding: 0px 10px;"><p><?= $table_spd->jenis_kendaraan?></p></td>
						<td style="padding: 0px 10px;"><p><?= $table_spd->untuk?></p></td>
						<td style="padding: 0px 10px;">
						<?php foreach($instansi_all as $key_insta => $table_insta) :?>
								<?php foreach($table_insta as $instansi_data) :?>
									<?php if($key_spd == $key_insta) :?>
										<?= $instansi_data->nama_instansi?>
									<?php endif;?>
								<?php endforeach?>
							<?php endforeach;?>
						</td>
						<td style="padding: 0px 10px;text-algin:center;width:80px"><p><?= date('d-m-Y', strtotime($table_spd->awal))?></p></td>
						<td style="padding: 0px 10px;text-algin:center;width:80px"><p><?= date('d-m-Y', strtotime($table_spd->akhir))?></p></td>
						<td style="width: 15%;padding: 0px 10px;word-wrap: break-word">
						<table width=100% border="0">
							<?php foreach($pegawai_all as $key_pegawai => $table_pegawai) :?>
								<?php foreach($table_pegawai as $pegawai_data) :?>
									<?php foreach($pegawai_data as $valueData) :?>
										<?php if($key_spd == $key_pegawai) :?>
											<tr>
												<td><?= $valueData->nama?>,</td>
											</tr>
										<?php endif;?>
									<?php endforeach?>
								<?php endforeach?>
							<?php endforeach;?>
											
						</table>
						</td>
	
					</tr>

				<?php endforeach;?>
		</tbody>
	</table>

	<table width=100% border="0" style="margin-top: 25px;">
		<tr>
			<td width=50% style="vertical-align: top;">
				<table border="0" style="padding-left: 25px;">
					<tr>
						<td style="padding:5px;">Jumlah Surat</td>
						<td style="padding:5px;width:2%">:</td>
						<td style="padding:5px;"><?= count($spd_all);?></td>
					</tr>
				</table>
			</td>
			<td width=50%>
				<table border="0" style="margin: 0 auto;">
					<tr>
						<td style="padding:2px;">Dikeluarkan di</td>
						<td style="padding:2px;width:2%">:</td>
						<td style="padding:2px;">Sumber</td>
					</tr>
					<tr>
						<td style="padding:2px;">Pada Tanggal</td>
						<td style="padding:2px;width:2%">:</td>
						<td style="padding:2px;"><?= date_indo(date('Y-m-d'))?></td>
					</tr>
					<tr>
						<td colspan="3" style="padding-top: 20px;text-align:center">Kepala Bidang Metrologi Legal</td>
					</tr>
					<tr>
						<td colspan="3" style="height: 80px;text-align:center;vertical-align:bottom;">
							<span style="font-weight: 800;"><?= $pejabat['nama'] ?></span><br>
							(<?= $pejabat['nip']?>)
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<br>
</body>

</html>
