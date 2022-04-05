<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Print SPt No | </title>
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
	<?php
	        echo "<pre>";
			print_r($spt);
			echo "</pre>";
			die();
	?>
	<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
	<table border="0" width=100% cellpadding=2 cellspacing=0 style="margin-top: 5px; text-align:center">
		<tr>
			<td width=15%>
				<img src="assets/custom/img/logo.png" alt="" style="height:120px;">
			</td>
			<td width=85%>
				<p style="font-size:20px;text-align:center;line-height: 1em;font-weight:500;margin-block-start: 0em;margin-block-end: 0em;" class="mb-0 mr-5">PEMERINTAH KABUPATEN CIREBON</p>
				<p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800;margin-bottom:8px;" class=" mr-5">DINAS PERDAGANGAN DAN PERINDUSTRIAN</p>
				<p style="font-size:16px;text-align:center;line-height: 16px;" class="mb-0 mr-5">Jl. Sunan Kalijaga Nomor 10</p>
				<p style="font-size:16px;text-align:center;line-height: 16px;margin-bottom:8px;" class="mr-5">Pusat Pemerintah Cirebon Telp.(0231) 321495 - 321073</p>
				<table width=100%>
					<tr>
						<td width=80% style="font-size:20px;text-align:center;line-height: 1em;font-weight:800">SUMBER</td>
						<td width=20% style="text-align: right;">45611</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<div width=100%>
		<hr class="s5 mb-3 mt-0">
	</div>
	<table style="margin: 0 auto;margin-top: 5px; text-align:center" border="0" cellpadding=2 cellspacing=0>
		<tbody>
			<tr>
				<td style="font-size:20px;text-align:center;line-height: 1.1em;font-weight:500;text-decoration: underline;text-align:center;">
					SURAT PERINTAH TUGAS
				</td>
			</tr>
			<tr style="text-align: center;">
				<td>Nomer : 090/ <b><span></span></b> /Bid.ML</td>
			</tr>
		</tbody>
	</table>
	<br>
</body>

</html>
