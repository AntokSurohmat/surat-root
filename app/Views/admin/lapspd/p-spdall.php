<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Print SPt No <?= $kode ?></title>
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
		}

		.table thead th {
			vertical-align: bottom;
			border-bottom: 2px solid #dee2e6;
		}

		.table tbody+tbody {
			border-top: 2px solid #dee2e6;
		}

		p {
			margin-top: 0;
			margin-bottom: 0;
		}
		ul , ul > li {
			list-style: none;
		}
		.page_break { page-break-before: always; }
	</style>
</head>

<body>
	<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
	<table border="0" width=100% cellpadding=2 cellspacing=0 style="margin-top: 5px; text-align:center">
		<tr>
			<td width=15%>
				<img src="assets/custom/img/logo.png" alt="" style="height:100px;">
			</td>
			<td width=85%>
				<p style="font-size:18px;text-align:center;line-height: 1em;font-weight:500;margin-block-start: 0em;margin-block-end: 0em;" class="mb-0 mr-5">PEMERINTAH KABUPATEN CIREBON</p>
				<p style="font-size:18px;text-align:center;line-height: 1em;font-weight:800;margin-bottom:3px;" class=" mr-5">DINAS PERDAGANGAN DAN PERINDUSTRIAN</p>
				<p style="font-size:15px;text-align:center;line-height: 16px;" class="mb-0 mr-5">Jl. Sunan Kalijaga Nomor 10</p>
				<p style="font-size:15px;text-align:center;line-height: 16px;margin-bottom:3px;" class="mr-5">Pusat Pemerintah Cirebon Telp.(0231) 321495 - 321073</p>
				<table width=100%>
					<tr>
						<td width=80% style="font-size:18px;text-align:center;line-height: 1em;font-weight:800">SUMBER</td>
						<td width=20% style="text-align: right;">45611</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div width=100%>
		<hr class="s5 mb-0 mt-0">
	</div>
	<table border="0" width=100% style="padding-left:70%;margin-top:10px;margin-bottom:10px;" >
		<tbody>
			<tr>
				<td width=40% style="padding:5px 10px;">Lembaran</td>
				<td width=5% style="padding:5px;"> : </td>
				<td style="padding:5px 10px;"></td>
			</tr>
			<tr>
				<td width=40% style="padding:5px 10px;">Kode No</td>
				<td width=5% style="padding:5px;"> : </td>
				<td style="padding:5px 10px;"></td>
			</tr>
			<tr>
				<td width=40% style="padding:5px 10px;">Nomer</td>
				<td width=5% style="padding:5px"> : </td>
				<td style="padding:5px 10px;"><span> <?= $kode?></span></td>
			</tr>
		</tbody>
	</table>
	<table border="0" width=100% style="margin: 0 auto;">
		<tbody>
			<tr>
				<td  class="text-center">
					<p style="font-size:18px;text-align:center;line-height: 1.1em;font-weight:500;text-decoration: underline;" class="mb-0">SURAT PERJALANAN DINAS</p>
				</td>
			</tr>
			<tr>
				<td  class="text-center">
					<p style="font-size:18px;text-align:center;line-height: 1.1em;font-weight:500;" class="mb-0">(SPD)</p>
				</td>
			</tr>
		</tbody>
	</table>
	<table border="0" width=100% style="padding: 0 30px;margin-top:10px;">
		<tbody>
			<tr>
				<th style="width:5%;">1.</th>
				<td style="width:20%;padding:5px 10px;">Pejabat yang memberikan perintah</td>
				<td colspan="2" style="padding: 5px 10px;">: <?= $diperintah['nama']?></td>
			</tr>
			<tr>
				<th style="width:5%;">2.</th>
				<td style="width:20%;padding:5px 10px;">Nama pegawai yang diperintah</td>
				<td colspan="2" style="padding: 5px 10px;">: <?= $pegawai[0]->nama?></td>
			</tr>
			<tr>
				<th style="width:5%;vertical-align:top;padding-top:12px;">3.</th>
				<td style="width:20%;padding:0px 10px;">
					<ol type="a" style="margin: 0px;padding-top:5px;padding-bottom:5px;padding-left:18px;">
						<li style="padding-top: 5px;">Pangkat dan golongan</li>
						<li style="padding-top: 5px;">Jabatan/Instansi</li>
						<li style="padding-top: 5px;">Tingkat Biaya Perjalanan</li>
					</ol>
				</td>
				<td colspan="2">
					<ul style="margin: 0px;padding-top:5px;padding-bottom:5px;padding-left:10px;">
						<li style="padding-top: 5px;">: <?= $pegawai[0]->nama_pangol?></li>
						<li style="padding-top: 5px;">: <?= $pegawai[0]->nama_jabatan?> / <?= $instansi['nama_instansi']?></li>
						<li style="padding-top: 5px;">: <?= $tingkat_biaya?></li>
					</ul>
				</td>
			</tr>
			<tr>
				<th style="width:5%;">4.</th>
				<td style="width: 40%;padding:5px 10px;">Maksud perjalanan dinas</td>
				<td colspan="2" style="padding: 5px 10px;">: <?= $untuk?></td>
			</tr>
			<tr>
				<th style="width:5%;">5.</th>
				<td style="width: 40%;padding: 5px 10px;">Alat angkutan yang dipergunakan</td>
				<td colspan="2" style="padding: 5px 10px;">: <?= $jenis_kendaraan?></td>
			</tr>
			<tr>
				<th style="width:5%;vertical-align:top;padding-top:8px;">6.</th>
				<td style="width:20%;padding:0 10px;">
					<ol type="a" style="margin: 0px;padding-top:0px;padding-bottom:0px;padding-left:20px;">
						<li style="padding-top: 5px;">Tempat berangkat</li>
						<li style="padding-top: 5px;">Tempat tujuan</li>
					</ol>
				</td>
				<td colspan="2">
					<ul style="margin: 0px;padding-top:0px;padding-bottom:0px;padding-left:10px;">
						<li style="padding-top: 5px;">: Sumber</li>
						<li style="padding-top: 5px;">: <?= $instansi['nama_instansi']?></li>
					</ul>
				</td>
			</tr>
			<tr>
				<th style="width:5%;vertical-align:top;padding-top:8px;">7.</th>
				<td style="width:20%;padding:0 10px;">
					<ol type="a" style="margin: 0px;padding-top:2px;padding-bottom:2px;padding-left:20px;">
						<li style="padding-top: 5px;">Lama perjalanan dinas</li>
						<li style="padding-top: 5px;">Tanggal berangkat</li>
						<li style="padding-top: 5px;">Tanggal harus kembali</li>
					</ol>
				</td>
				<td colspan="2">
				<ul style="margin: 0px;padding-top:2px;padding-bottom:2px;padding-left:10px;">
					<li style="padding-top: 5px;">: <?= $lama?> Hari</li>
					<li style="padding-top: 5px;">: <?= date('d-m-Y', strtotime($awal))?></li>
					<li style="padding-top: 5px;">: <?= date('d-m-Y', strtotime($akhir))?></li>
				</ul>
				</td>
			</tr>
			<tr>
				<th style="width:5%;">8.</td>
				<td style="width: 40%;padding: 5px 10px;">Pengikut</td>
				<td style="width: 25%;padding: 5px 10px;">Tanggal Lahir</td>
				<td style="width: 25%;padding: 5px 10px;">Keterangan</td>
			</tr>
			<?php foreach($looping as $pegawailooping) :?>
				<tr>
					<td style="width: 5%;"></td>
					<td style="width:20%;padding-top:5px;padding-left:10px;"><?= $pegawailooping->nama?></td>
					<td style="width:25%;padding-top:5px;padding-left:10px;"><?= date('d-m-Y', strtotime($pegawailooping->tgl_lahir))?></td>
					<td style="width:25%;padding-top:5px;padding-left:10px;" id="ketPengikutModalView"><?= $pegawailooping->nama_jabatan?></td>
				</tr>
				<?php endforeach?>
			<tr>
				<th style="width:5%;vertical-align:top;padding-top:6px;">9.</td>
				<td style="width:20%;padding:0 10px;">
					<ul style="margin: 0px;padding-top:5px;padding-bottom:0px;padding-left:0px;">
						<li>
						Pembebanan anggaran
						</li>
						<li>
							<ol type="a" style="margin: 0px;padding-top:5px;padding-bottom:0px;padding-left:20px;">
								<li style="padding-top: 5px;">Instansi</li>
								<li style="padding-top: 5px;">Mata anggaran/kode rekening</li>
							</ol>
						</li>
					</ul>
				</td>
				<td colspan="2">
					<ul	ul style="margin: 0px;padding-top:2px;padding-bottom:2px;padding-left:10px;">
						<li><br></li>
						<li>
							<ul style="margin: 0px;padding-top:2px;padding-bottom:2px;padding-left:0px;">
								<li style="padding-top: 5px;">: --</li>
								<li style="padding-top: 5px;">: <?= $kode_rekening?></li>
							</ul>
						</li>
					</ul>
				</td>
			</tr>
			<tr>
				<th style="width:5%;">10.</th>
				<td style="width:20%;padding:5px 10px;">Keterangan</td>
				<td colspan="2" style="padding:5px 10px;">: <?= $keterangan?></td>
			</tr>
		</tbody>
	</table>
	<div width=100% style="padding: 0 6%;margin-top:10px;">
		<p>
			Demikian pemerintah tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.
		</p>
	</div>
	<table border="0" width="100%" class="table" style="padding-left:50%;margin-top:10px;">
		<tr>
			<td style="width:50%;text-align:center;padding:5px;">Dikeluarkan di</td>
			<td style="padding:5px;width:2%"> : </td>
			<td style="padding:5px;">Sumber</td>
		</tr>
		<tr>
			<td style="width:50%;text-align:center;padding:5px;">Pada Tanggal</td>
			<td style="padding:5px;width:2%"> : </td>
			<td style="padding:5px;"><?= date_indo(date('Y-m-d', strtotime($created_at)))?></td>
		</tr>
		<tr>
			<td colspan="3" style="padding:0">
				<hr class="s9" style="margin:0;margin-bottom:0px;margin-top:0px;">
			</td>
		</tr>
		<tr>
			<td colspan="3" style="height:80px;"></td>
		</tr>
		<tr>
			<td colspan="3" style="padding:4px;text-align:center"><span style="font-weight: 800;font-size:16px"><?= $diperintah['nama']?></span><br>(<?= $diperintah['nip']?>)</td>
		</tr>
	</table>
	<div class="page_break"></div>
	<table class="table" border="1" width=100% style="margin-top:15px;padding: 0 30px;">
		<tr>
			<td style="width: 50%; padding:2px;">
			</td>
			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<tr>
						<th width=10% style="padding:4px 10px;">I.</th>
						<td style="padding:4px 10px;width:40%;">SPD No</td>
						<td style="padding:4px 10px;width: 2%;">:</td>
						<td style="padding:4px 10px;"><?= $kode?></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px 10px;"></th>
						<td style="padding:4px 10px;width:40%;">Berangkat dari</td>
						<td style="padding:4px 10px;width: 2%;">:</td>
						<td style="padding:4px 10px;">Sumber</td>
					</tr>
					<tr>
						<th width=10% style="padding:4px 10px;"></th>
						<td style="padding:4px 10px;width:40%;">Pada Tanggal</td>
						<td style="padding:4px 10px;width: 2%;">:</td>
						<td style="padding:4px 10px;"><?= date('d-m-Y', strtotime($awal))?></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px 10px;"></th>
						<td style="padding:4px 10px;width:40%;">Ke</td>
						<td style="padding:4px 10px;width: 2%;">:</td>
						<td style="padding:4px 10px;"><?= $instansi['nama_instansi']?></td>
					</tr>
					<tr>
						<td colspan="4" style="padding:4px 10px;text-align:center;height:60px;">Pejabat yang memberikan perintah</td>
					</tr>
					<tr>
						<td colspan="4" style="padding:4px 10px;text-align:center;"><span style="font-weight: 800;"><?= $diperintah['nama']?></span><br>(<?= $diperintah['nip']?>)</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<?php foreach($json as $key => $looping) :?>
						<?php if($key == 0) : ?>
							<?php foreach($looping as $row => $content) :?>
								<?php if($row == 'tibadi'): ?>
								<tr>
									<th width=10% style="padding:4px;">II.</th>
									<td style="padding:4px;width:40%;">Tiba di</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tanggaltiba'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tanggal Tiba</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'kepalatiba'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Kepala Tiba</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					<?php endforeach;?>
				</table>
			</td>

			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<?php foreach($json as $key => $looping) :?>
						<?php if($key == 0) : ?>
							<?php foreach($looping as $row => $content) :?>
								<?php if($row == 'berangkatdari'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Berangkat Dari</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tujuan'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tujuan</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tanggalberangkat'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tanggal Berangkat</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'kepalaberangkat'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Kepala Berangkat</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					<?php endforeach;?>
				</table>
			</td>
		</tr>

		<tr>
			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<?php foreach($json as $key => $looping) :?>
						<?php if($key == 1) : ?>
							<?php foreach($looping as $row => $content) :?>
								<?php if($row == 'tibadi'): ?>
								<tr>
									<th width=10% style="padding:4px;">III.</th>
									<td style="padding:4px;width:40%;">Tiba di</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tanggaltiba'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tanggal Tiba</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'kepalatiba'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Kepala Tiba</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					<?php endforeach;?>
				</table>
			</td>

			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<?php foreach($json as $key => $looping) :?>
						<?php if($key == 1) : ?>
							<?php foreach($looping as $row => $content) :?>
								<?php if($row == 'berangkatdari'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Berangkat Dari</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tujuan'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tujuan</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tanggalberangkat'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tanggal Berangkat</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'kepalaberangkat'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Kepala Berangkat</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					<?php endforeach;?>
				</table>
			</td>
		</tr>

		<tr>
			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<?php foreach($json as $key => $looping) :?>
						<?php if($key == 2) : ?>
							<?php foreach($looping as $row => $content) :?>
								<?php if($row == 'tibadi'): ?>
								<tr>
									<th width=10% style="padding:4px;">IV.</th>
									<td style="padding:4px;width:40%;">Tiba di</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tanggaltiba'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tanggal Tiba</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'kepalatiba'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Kepala Tiba</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					<?php endforeach;?>
				</table>
			</td>

			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<?php foreach($json as $key => $looping) :?>
						<?php if($key == 2) : ?>
							<?php foreach($looping as $row => $content) :?>
								<?php if($row == 'berangkatdari'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Berangkat Dari</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tujuan'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tujuan</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tanggalberangkat'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tanggal Berangkat</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'kepalaberangkat'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Kepala Berangkat</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					<?php endforeach;?>
				</table>
			</td>
		</tr>

		<tr>
			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<?php foreach($json as $key => $looping) :?>
						<?php if($key == 3) : ?>
							<?php foreach($looping as $row => $content) :?>
								<?php if($row == 'tibadi'): ?>
								<tr>
									<th width=10% style="padding:4px;">V.</th>
									<td style="padding:4px;width:40%;">Tiba di</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tanggaltiba'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tanggal Tiba</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'kepalatiba'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Kepala Tiba</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					<?php endforeach;?>
				</table>
			</td>

			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<?php foreach($json as $key => $looping) :?>
						<?php if($key == 3) : ?>
							<?php foreach($looping as $row => $content) :?>
								<?php if($row == 'berangkatdari'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Berangkat Dari</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tujuan'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tujuan</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'tanggalberangkat'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Tanggal Berangkat</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
								<?php if($row == 'kepalaberangkat'): ?>
								<tr>
									<th width=10% style="padding:4px;"></th>
									<td style="padding:4px;width:40%;">Kepala Berangkat</td>
									<td style="padding:4px;width: 2%;">:</td>
									<td style="padding:4px;width:40%;"><?= $content?></td>
								</tr>
								<?php endif;?>
							<?php endforeach;?>
						<?php endif;?>
					<?php endforeach;?>
				</table>
			</td>
		</tr>

		<tr>
			<td style="width: 50%; padding:2px;">
			<table width=100% border="0">
					<tr>
						<th width=10% style="padding:4px 10px;">IV.</th>
						<td style="padding:4px 10px;width:40%;">Tiba di</td>
						<td style="padding:4px 10px;width: 2%;">:</td>
						<td style="padding:4px 10px;">Sumber</td>
					</tr>
					<tr>
						<th width=10% style="padding:4px 10px;"></th>
						<td style="padding:4px 10px;width:40%;">Pada Tanggal</td>
						<td style="padding:4px 10px;width: 2%;">:</td>
						<td style="padding:4px 10px;"><?= date('d-m-Y', strtotime($akhir))?></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px 10px;"></th>
						<td style="padding:4px 10px;width:40%;">Kepala</td>
						<td style="padding:4px 10px;width: 2%;">:</td>
						<td style="padding:4px 10px;"><?= $pegawai[0]->nama_jabatan?></td>
					</tr>
					<tr>
						<td ></td>
					</tr>
					<tr>
						<td colspan="4" style="padding:4px 10px;text-align:center;height:60px;">Pejabat yang memberikan perintah</td>
					</tr>
					<tr>
						<td colspan="4" style="padding:4px 10px;text-align:center;"><span style="font-weight: 800;"><?= $diperintah['nama']?></span><br>(<?= $diperintah['nip']?>)</td>
					</tr>
				</table>
			</td>

			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<tr>
						<td style="text-align: justify;padding:4px 10px;">Telah diperiksa, dengan keterangan bahwa perjalanan dinas tersebut diatas benar dilakukan atas perintah dan semata-mata untuk kepentingan jabatan dalam waktu sesingkat-singkatnya.</td>
					</tr>
					<tr>
						<td colspan="4" class="text-center" style="height: 60px;">Pejabat yang memberikan perintah
						</td>
					</tr>
					<tr class="mt-5">
						<td colspan="4" style="padding:4px 10px;text-align:center;"><span style="font-weight: 800;"><?= $diperintah['nama']?></span><br>(<?= $diperintah['nip']?>)</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="height: 80px;"><b>VI.</b> CATATAN LAIN - LAIN</td>
		</tr>
		<tr>
			<td colspan="2" class="text-justify"><p><b>VII.</b> Pejabat yang berwenang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba serta Bendaharawan yang bertanggung jawab, berdasarkan pengaturan-pengaturan Keuangan Negara apabila Negara mendapatkan akibat kesalahan, kelupaannya.</p></td>
		</tr>
	</table>
</body>

</html>
