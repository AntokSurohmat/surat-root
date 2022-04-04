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
	<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
	<table border="0" width=100% cellpadding=2 cellspacing=0 style="margin-top: 5px; text-align:center">
		<tr>
			<td width=10%>
				<img src="assets/custom/img/logo.png" alt="" style="height:120px;">
			</td>
			<td width=50%>
				<p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800;margin-block-start: 0em;margin-block-end: 0em;" class="mb-0 mr-5">PEMERINTAH KABUPATEN CIREBON</p>
				<p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800;margin-bottom:8px;" class="mb-0 mr-5">DINAS PERDAGANGAN DAN PERINDUSTRIAN</p>
				<p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800;" class="mb-3 mr-5">KABUPATEN CIREBON</p>
				<hr class="s5 mb-3 mt-0">
			</td>
			<td width="30%">
				<table border="0" class="table nopadding">
					<tr>
						<td style="width: 40%;text-align:right;font-size:20px;font-weight:800">MODEL. U</td>
						<td style="font-size:20px;text-align:center;font-weight:800">XVI</td>
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
		<p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800;text-decoration:underline" class="mb-0 mr-5">KUITANSI (TANDA BEMBAYARAN)</p>
	</div>
	<br>
	<table border="0" class="table minimpadding" style="font-size: 14px;width:80%">
		<tbody>
			<tr>
				<td style="width:20%;">TELAH DITERIMA DARI</td>
				<td style="width:1%;">:</td>
				<td> Bendahara Pengeluaran Pembantu Disperdagin Kabupaten Cirebon</td>
			</tr>
			<tr>
				<td style="width:20%;">BANYAKNYA</td>
				<td style="width:1%;">:</td>
				<td style="border: 1px solid;" id="banyaknyaKuitansiModalView"><?= terbilang($jumlah_uang) ?></td>
			</tr>
			<tr>
				<td colspan="3" style="width: 20%;">Rp. <span><?= $jumlah_uang ?></span> ,-</td>
			</tr>
			<tr>
				<td style="width: 20%;">Yaitu Untuk</td>
				<td style="width: 1%;">:</td>
				<td>
					<p>Biaya Perjalanan Dinas <span><?= $wilayah['jenis_wilayah'] ?></span> dalam rangka <span><?= $untuk ?></span> di <span><?= $instansi['nama_instansi'] ?></span> selama <span><?= $lama ?></span> hari pada tanggal <span><?= date('d-m-Y', strtotime($awal)) ?></span> sampai <span><?= date('d-m-Y', strtotime($akhir)) ?></span> a/n <span><?= $pegawai['nama'] ?></span> </p>
				</td>
			</tr>
		</tbody>
	</table>
	<table border="1" class="table" style="font-size: 14px;">
		<thead>
			<tr>
				<th style="vertical-align:middle;text-align:center;">Mengetahui/Menyetujui :</br>Kuasa Pengguna Anggaran</td>
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
					<table border="0" class="table nopadding">
						<tr>
							<td style="width: 40%;">Jabatan</td>
							<td style="text-align: left;">: <?= $jabatan['nama_jabatan'] ?></td>
						</tr>
						<tr>
							<td style="width: 40%;">Sat. Kerja</td>
							<td style="text-align: left;">: Disperdagin Kab. Cirebon</td>
						</tr>
						<tr>
							<td style="height: 50px;"></td>
						</tr>
					</table>
					<span><?= $kepala['nama'] ?></span><br>(<?= $kepala['nip'] ?>)
				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>
