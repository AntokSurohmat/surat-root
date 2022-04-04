<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Print Kuitansi No <?= $kode_spd ?></title>
	<!-- <link type="text/css"  href="assets/AdminLTE/dist/css/adminlte.min.css" rel="stylesheet"> -->
	<link type="text/css" href="assets/custom/css/style.css" rel="stylesheet">
	<style>
		body {
			margin: 0;
			font-family: "Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
			font-size: 15px;
			font-weight: 400;
			line-height: 1.5;
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
			border-top: 1px solid #dee2e6;
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
	</style>
</head>

<body>

	<table border="0" width=100% cellpadding=0 cellspacing=0 style="margin-top: 5px; text-align:center">
		<tr>
			<td width=50%>
				<p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800" class="mb-0">RINCIAN BIAYA PERJALANAN DINAS</p>
				<p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800;margin-bottom:8px;" class="mb-0">DINAS PERDAGANGAN DAN PERINDUSTRIAN</p>
				<p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800;" class="mb-3">KABUPATEN CIREBON</p>
				<hr class="s5 mb-3 mt-0">
			</td>
		</tr>
	</table>
	<table border="0" class="table nopadding">
		<tr>
			<td style="width: 30%;padding-left: 10px;">Lampiran SPD Nomor</td>
			<td id="lampiranSpdNomor">: <?= $kode_spd ?></td>
		</tr>
		<tr>
			<td style="width: 30%;padding-left: 10px;">Tanggal</td>
			<td id="tanggalBepergian">: <?= date('d-m-Y', strtotime($awal)) ?> s/d <?= date('d-m-Y', strtotime($akhir)) ?></td>
		</tr>
	</table>
	<br>
	<table border="1" width=100% class="table nopadding">

		<thead>
			<tr>
				<th style="width: 5%;" style="text-align:center;">No</th>
				<th>Rincian Biaya</th>
				<th>Jumlah</th>
				<th style="width: 30%;">Keteranganan</th>
			</tr>
		</thead>
		<tbody id="dataTableRincianModalView">
			<tr>
				<td style="text-align:center;">1</td>
				<td style="padding: 0 10px;"><?= $rincian_sbuh ?></td>
				<td style="padding: 0 10px;">Rp. <?= $jumlah_uang ?> ,-</td>
				<td style="padding: 0 10px;">Kwitansi</td>
			</tr>

			<?php foreach ($json as $index => $items) : ?>
				<tr>
					<?php
					$m_angka = array("2", "3", "4", "5", "6");
					foreach ($items as $row => $content) : ?>
						<?php if ($row == 'rincian_biaya') : ?>
							<td style="text-align:center;"><?= $m_angka[$index] ?></td>
							<?php if ($content != NULL) : ?>
								<td style="padding: 0 10px;"><?= $content ?></td>
							<?php else : ?>
								<td></td>
							<?php endif ?>
						<?php elseif ($row == 'jumlah_biaya') : ?>
							<?php if ($content != NULL) : ?>
								<td style="padding: 0 10px;">Rp. <?= number_format($content) ?> , -</td>
							<?php else : ?>
								<td></td>
							<?php endif ?>
						<?php else : ?>
							<?php if ($content != NULL) : ?>
								<td style="padding: 0 10px;">Lembar Bukti</td>
							<?php elseif (strlen($content) == 0) : ?>
								<td></td>
							<?php else : ?>
								<td>Kosong</td>
							<?php endif; ?>
						<?php endif; ?>
						<!-- <td id="jumlahDataTableRincianModalView3"></td>
						<td id="keteranganDataTableRincianModalView3"></td> -->
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>

			<tr>
				<td></td>
				<td colspan="3" style="padding: 0 10px;font-weight:800;">TOTAL : Rp. <?= number_format($sum) ?>, -</td>
			</tr>
			<tr><td></td>
				<td colspan="3" style="padding: 0 10px;font-weight:800;">TERBILANG : <span style="font-size:14px;"> <?= ucwords(terbilang($sum)) ?></span></td>
			</tr>
		</tbody>
	</table>

	<table border="0" class="table nopadding mt-2">
		<tr>
			<td width=50%>
				<table class="table nopadding mt-2">
					<tr>
						<td style="text-align:center;font-weight:800;height:80px; vertical-align:bottom;">Bendahara</td>
					</tr>
					<tr>
						<td style="text-align:center;height:100px;"></td>
					</tr>
					<tr>
						<td style="text-align:center" id="bendaharaNamaTTD"><b style="text-decoration:underline"><?= $bendahara['nama']?></b><br>(<?= $bendahara['nip']?>)</td>
					</tr>
				</table>
			</td>
			<td width=50%>
				<table class="table nopadding mt-2">
					<tr>
						<td style="text-align:center;font-weight:800;height:80px; vertical-align:bottom;">Kuasa Penggunaan Anggaran,<br>Kepala Bidang Metrologi Legal<br>Kabupaten Cirebon</td>
					</tr>
					<tr>
						<td style="text-align:center;height:100px;"></td>
					</tr>
					<tr>
						<td style="text-align:center" id="kepalaBidangNamaTTD"><b style="text-decoration:underline"><?= $kepala['nama']?></b><br>(<?= $kepala['nip']?>)</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</body>

</html>
