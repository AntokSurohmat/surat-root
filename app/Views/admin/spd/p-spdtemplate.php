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

	</table>
</body>

</html>

