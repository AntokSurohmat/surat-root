<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Print All Recap SPT</title>
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

<?php

// echo '<pre>';
// // // // print_r($spt);
// // // // print_r($spt_all);
// // print_r($pegawai_all);
// // // print_r($pegawai);
// // // // print_r($instansi);
// print_r($pejabat);
// echo '</pre>';
// die();
?>
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
					SURAT PERINTAH TUGAS
				</td>
			</tr>
		</tbody>
	</table>
	<table style="margin-top: 15px;" width=100% border="0" cellpadding=2 cellspacing=0>
		<tbody>
			<tr>
				<td >
					<table border="0">
						<tr>
							<td width=40% style="padding: 2px 10px;">No. SPT</td>
							<td width=3% style="padding: 2px 10px;">: </td>
							<td style="padding: 2px 10px;"> <?= $spt['kode']?> </td>
						</tr>
						<tr>
						<td width=40% style="padding: 2px 10px;">Nama</td>
							<td width=3% style="padding: 2px 10px;">: </td>
							<td style="padding: 2px 10px;">
								<?php foreach ($pegawai as $pegawai_key => $pegawai_value) {
									$data_pegawai[] = $pegawai_value->nama;
								}?>
								<?php 
								echo str_replace(
									array('"','[',']'),
									array("", "", ""),
									json_encode($data_pegawai)
								);
								?>
							</td>
						</tr>
					</table>
				</td>
				<td width=33%>
					<table border="0">
						<tr>
							<td width=40% style="padding: 2px 10px;">Tanggal Pergi</td>
							<td width=3% style="padding: 2px 10px;">: </td>
							<td style="padding: 2px 10px;"> <?= date('d-m-Y', strtotime($spt['awal'])) ?> </td>
						</tr>
						<tr>
							<td width=40% style="padding: 2px 10px;">Tanggal Kembali</td>
							<td width=3 style="padding: 2px 10px;">: </td>
							<td style="padding: 2px 10px;"> <?= date('d-m-Y', strtotime($spt['akhir'])) ?> </td>
						</tr>
					</table>
				</td>
				<td width=33% style="vertical-align: top;">
					<table border="0">
						<tr>
							<td width=40% style="padding: 2px 10px;">Nama Instansi</td>
							<td width=3% style="padding: 2px 10px;">: </td>
							<td style="padding: 2px 10px;"> 
								<?php foreach ($instansi as $inst_key => $inst_value) {
									if($inst_key == 'nama_instansi'){
										echo $inst_value;
									}
								}?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</tbody>
	</table>

	<table  width=100% border="1" style="margin-top:5px;">
		<thead>
			<tr>
				<th style="width: 5%;padding:2px;">No. SPT</th>
				<th style="width: 15%;padding:2px;">NIP</th>
				<th style="width: 15%;padding:2px;">Nama</th>
				<th>Dasar</th>
				<th>Maksud Perjalanan Dinas</th>
				<th>Nama Instansi</th>
				<th>Tanggal Pergi</th>
				<th>Tanggal Kembali</th>
			</tr>
		</thead>
		<tbody>
				<?php foreach($spt_all as $key_spt => $table_spt) :?>
					<tr>
						<td style="width: 5%;padding: 0px 10px;"><p><?= $table_spt->kode?></p></td>
						<td style="width: 15%;padding: 0px 10px;word-wrap: break-word">
						<table width=100% border="0">
							<?php foreach($pegawai_all as $key_pegawai => $table_pegawai) :?>
								<?php foreach($table_pegawai as $pegawai_data) :?>
									<?php if($key_spt == $key_pegawai) :?>
										<tr>
											<td><?= $pegawai_data->nip?>,</td>
										</tr>
									<?php endif;?>
								<?php endforeach?>
							<?php endforeach;?>
											
						</table>
						</td>
						<td style="width: 15%;padding: 0px 10px;word-wrap: break-word">
						<table width=100% border="0">
							<?php foreach($pegawai_all as $key_pegawai => $table_pegawai) :?>
								<?php foreach($table_pegawai as $pegawai_data) :?>
									<?php if($key_spt == $key_pegawai) :?>
										<tr>
											<td><?= $pegawai_data->nama?>,</td>
										</tr>
									<?php endif;?>
								<?php endforeach?>
							<?php endforeach;?>
											
						</table>		
						</td>
						<td style="padding: 0px 10px;"><p><?= $table_spt->dasar?></p></td>
						<td style="padding: 0px 10px;">
						<?php foreach($tujuan_all as $key_tujuan => $table_tujuan) :?>
								<?php foreach($table_tujuan as $tujuan_data) :?>
									<?php if($key_spt == $key_tujuan) :?>
										<?= $tujuan_data->tujuan?>
									<?php endif;?>
								<?php endforeach?>
							<?php endforeach;?>
						</td>
						</td>
						<td style="padding: 0px 10px;">
						<?php foreach($instansi_all as $key_insta => $table_insta) :?>
								<?php foreach($table_insta as $instansi_data) :?>
									<?php if($key_spt == $key_insta) :?>
										<?= $instansi_data->nama_instansi?>
									<?php endif;?>
								<?php endforeach?>
							<?php endforeach;?>
						</td>
						<td style="padding: 0px 10px;text-algin:center"><p><?= date('d-m-Y', strtotime($table_spt->awal))?></p></td>
						<td style="padding: 0px 10px;text-algin:center"><p><?= date('d-m-Y', strtotime($table_spt->akhir))?></p></td>
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
						<td style="padding:5px;"><?= count($spt_all);?></td>
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
