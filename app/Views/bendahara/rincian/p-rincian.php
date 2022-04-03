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
		font-size: 1rem;
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
			<td id="lampiranSpdNomor">: <?= $kode_spd?></td>
		</tr>
		<tr>
			<td style="width: 30%;padding-left: 10px;">Tanggal</td>
			<td id="tanggalBepergian">: <?= date('d-m-Y', strtotime($awal))?> s/d  <?= date('d-m-Y', strtotime($akhir))?></td>
		</tr>
	</table>
	<br>
	<table border="1" width=100% class="table nopadding">

		<thead>
			<tr>
				<th style="width: 5%;" style="text-align:center;">No</th>
				<th >Rincian Biaya</th>
				<th>Jumlah</th>
				<th style="width: 30%;">Keteranganan</th>
			</tr>
		</thead>
		<tbody id="dataTableRincianModalView">
			<tr>
				<td style="text-align:center;">1</td>
				<td style="padding: 0 10px;"><?= $rincian_sbuh?></td>
				<td style="padding: 0 10px;">Rp. <?= $jumlah_uang?> ,-</td>
				<td style="padding: 0 10px;">Kwitansi</td>
			</tr>
			<?php foreach($looping as $index => $items) :?>
				<?php foreach($items as $row => $content):?>
					<?php if($index == 0) :?>
							<td><?= ($row+2)?></td>
						<?php elseif($index == 1) :?>
							<td><?= $content?></td>
							<td><?= $content?></td>
						<?php else :?>
							<td><?= $content?></td>
						<?php endif;?>

						<?php endforeach;?>
			<?php endforeach;?>
			<!-- <tr>
				<td id="indexDataTableRincianModalView3" style="text-align:center;"></td>
				<td id="rincianDataTableRincianModalView3"></td>
				<td id="jumlahDataTableRincianModalView3"></td>
				<td id="keteranganDataTableRincianModalView3"></td>
			</tr>
			<tr>
				<td id="indexDataTableRincianModalView4" style="text-align:center;"></td>
				<td id="rincianDataTableRincianModalView4"></td>
				<td id="jumlahDataTableRincianModalView4"></td>
				<td id="keteranganDataTableRincianModalView4"></td>
			</tr>
			<tr>
				<td id="indexDataTableRincianModalView5" style="text-align:center;"></td>
				<td id="rincianDataTableRincianModalView5"></td>
				<td id="jumlahDataTableRincianModalView5"></td>
				<td id="keteranganDataTableRincianModalView5"></td>
			</tr>
			<tr>
				<td id="indexDataTableRincianModalView6" style="text-align:center;"></td>
				<td id="rincianDataTableRincianModalView6"></td>
				<td id="jumlahDataTableRincianModalView6"></td>
				<td id="keteranganDataTableRincianModalView6"></td>
			</tr> -->
			<!-- <tr>
				<td style="padding-left:10px;font-weight:800;">TOTAL</td>
				<td colspan="3" id="totalTableRincianModalView">: </td>
				<td></td>
			</tr>
			<tr>
				<td colspan="4" style="padding-left: 10px;font-weight:800;">TERBILANG : <span style="font-size:14px;" id="terbilangTableRincianModalView"></span></td>
			</tr> -->
		</tbody>
	</table>

</body>

</html>
