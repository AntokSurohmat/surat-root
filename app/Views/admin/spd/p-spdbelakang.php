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
					<tr>
						<th width=10% style="padding:4px;">II.</th>
						<td style="padding:4px;width:40%;">Tiba di</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tanggal Tiba</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Kepala Tiba</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
				</table>
			</td>

			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Berangkat Dari</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tujuan</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tanggal Berangkat</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Kepala Berangkat</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">

					<tr>
						<th width=10% style="padding:4px;">III.</th>
						<td style="padding:4px;width:40%;">Tiba di</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tanggal Tiba</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Kepala Tiba</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
				</table>
			</td>

			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Berangkat Dari</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tujuan</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tanggal Berangkat</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Kepala Berangkat</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<tr>
						<th width=10% style="padding:4px;">IV.</th>
						<td style="padding:4px;width:40%;">Tiba di</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tanggal Tiba</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Kepala Tiba</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
				</table>
			</td>

			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Berangkat Dari</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tujuan</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tanggal Berangkat</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Kepala Berangkat</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<tr>
						<th width=10% style="padding:4px;">V.</th>
						<td style="padding:4px;width:40%;">Tiba di</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tanggal Tiba</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Kepala Tiba</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
				</table>
			</td>

			<td style="width: 50%; padding:2px;">
				<table width=100% border="0">
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Berangkat Dari</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tujuan</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Tanggal Berangkat</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
					<tr>
						<th width=10% style="padding:4px;"></th>
						<td style="padding:4px;width:40%;">Kepala Berangkat</td>
						<td style="padding:4px;width: 2%;">:</td>
						<td style="padding:4px;width:40%;"></td>
					</tr>
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
					<td colspan="4" style="padding:4px 10px;text-align:center;height:60px;padding-top:20px;">Pejabat yang memberikan perintah</td>
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
					<td colspan="4" style="padding:4px 10px;text-align:center;height:60px;">Pejabat yang memberikan perintah
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

