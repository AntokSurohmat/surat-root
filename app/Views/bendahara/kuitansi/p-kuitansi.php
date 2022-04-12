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
		font-size: 11px;
		font-weight: 400;
		line-height: 1.5;
		color: #212529;
		text-align: left;
		background-color: #fff;
		margin-top: -10px;
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
			border-top: 1px solid;
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
	<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
	<table border="0" width=100% cellpadding=2 cellspacing=0 style="margin-top: 5px; text-align:center">
		<tr>
			<td width=10%>
				<img src="assets/custom/img/logo.png" alt="" style="height:70px;width:70px;padding:0px;margin-top:-40px;">
			</td>
			<td width=50%>
				<p style="font-size:14px;text-align:center;line-height: 1em;font-weight:800;margin-block-start: 0em;margin-block-end: 0em;" class="mb-0 ">PEMERINTAH KABUPATEN CIREBON</p>
				<p style="font-size:14px;text-align:center;line-height: 1em;font-weight:800;margin-bottom:8px;" class="mb-0 ">DINAS PERDAGANGAN DAN PERINDUSTRIAN</p>
				<p style="font-size:14px;text-align:center;line-height: 1em;font-weight:800;" class="mb-3 ">KABUPATEN CIREBON</p>
				<hr class="s5 mb-1 mt-0">
			</td>
			<td width="30%">
				<table border="0" class="table nopadding" style="margin-top:-20px;">
					<tr>
						<td style="width: 40%;text-align:right;font-size:14px;font-weight:800">MODEL. U</td>
						<td style="font-size:14px;text-align:center;font-weight:800">XVI</td>
					</tr>
					<tr>
						<td colspan="2">
							<hr class="s9" style="margin:0;margin-bottom:0px;margin-top:0px;">
						</td>
					</tr>
					<tr>
						<td style="width: 40%;padding-left: 10px;">Tanggal</td>
						<td>: <?= date('d-m-Y', strtotime($created_at)) ?></td>
					</tr>
					<tr>
						<td style="width: 40%;padding-left: 10px;">No. BKU</td>
						<td id="bkuKuitansiModalView">: </td>
					</tr>
					<tr>
						<td style="width: 40%;padding-left: 10px;">Kode Rekening</td>
						<td>: <?= $kode_rekening ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div width=100%>
		<p style="font-size:14px;text-align:center;font-weight:800;text-decoration:underline;margin-top:-30px;">KUITANSI (TANDA BEMBAYARAN)</p>
	</div>
	<table border="0" class="table minimpadding" style="font-size: 12px;width:80%">
		<tbody>
			<tr>
				<td style="width:30%;">TELAH DITERIMA DARI</td>
				<td style="width:1%;">:</td>
				<td> Bendahara Pengeluaran Pembantu Disperdagin Kabupaten Cirebon</td>
			</tr>
			<tr he>
				<td style="width:30%;">BANYAKNYA</td>
				<td style="width:1%;">:</td>
				<td style="border:2px solid !important;" id="banyaknyaKuitansiModalView"><span style=""><?=  ucwords(terbilang($jumlah_uang)) ?></span></td>
			</tr>
			<tr>
				<td colspan="3" style="width: 20%;">Rp. <span><?= $jumlah_uang ?></span> ,-</td>
			</tr>
			<tr>
				<td style="width: 30%;">Yaitu Untuk</td>
				<td style="width: 1%;">:</td>
				<td>
					<p>Biaya Perjalanan Dinas <span><?= $wilayah['jenis_wilayah'] ?></span> dalam rangka <span><?= $untuk ?></span> di <span><?= $instansi['nama_instansi'] ?></span> selama <span><?= $lama ?></span> hari pada tanggal <span><?= date('d-m-Y', strtotime($awal)) ?></span> sampai <span><?= date('d-m-Y', strtotime($akhir)) ?></span> a/n <span><?= $pegawai['nama'] ?></span> </p>
				</td>
			</tr>
		</tbody>
	</table>
	<table border="1"  style="font-size: 11px;">
		<thead>
			<tr>
				<th style="vertical-align:middle;text-align:center;">Mengetahui/Menyetujui : </br>Kuasa Pengguna Anggaran</td>
				<th style="vertical-align:middle;text-align:center;">Pejabat Pelaksana Teknis Kegiatan</th>
				<th style="vertical-align:middle;text-align:center;">Tanggal: <span><?= date('d-m-Y', strtotime($created_at)) ?></span><br>Lunas Dibayar: <br>Bendahara Pengeluaran Pembantu</th>
				<th style="vertical-align:middle;text-align:center;">Yang Menerima<br>Nama: <span><?= $pegawai['nama'] ?></span></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td style="vertical-align:bottom;text-align:center;width:25%;"><span><?= $bendahara['nama'] ?></span><br>(<?= $bendahara['nip'] ?>)</td>
				<td style="vertical-align:bottom;text-align:center;width:25%;"><span><?= $pejabat['nama'] ?></span><br>(<?= $pejabat['nip'] ?>)</td>
				<td style="vertical-align:bottom;text-align:center;width:25%;"><span><?= $bendahara['nama'] ?></span><br>(<?= $bendahara['nip'] ?>)</td>
				<td style="text-align:center;width:25%;">
					<table border="0" class="table nopadding" style="padding:2px;">
						<tr>
							<td style="text-align: right;width: 33%;">Jabatan</td>
							<td style="text-align: left;padding-left:5px;">: <?= $jabatan['nama_jabatan'] ?></td>
						</tr>
						<tr>
							<td style="text-align: right;width: 33%;">Sat. Kerja</td>
							<td style="text-align: left;padding-left:5px;">: Disperdagin Kab. Cirebon</td>
						</tr>
						<tr>
							<td style="height: 25px;"></td>
						</tr>
					</table>
					<span><?= $kepala['nama'] ?></span><br>(<?= $kepala['nip'] ?>)
				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>
