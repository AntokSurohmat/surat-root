<?= $this->extend('admin/layouts/default') ?>

<?= $this->section('content') ?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0"><?= $title ?></h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

    <div class="row">
            <div class="col-12">

                <div class="card card-outline card-info">
                    <div class="card-header">
                    <h3 class="card-title pt-1">Data <?= ucwords(strtolower($title)) ?></h3>
                        <a class="btn btn-sm btn-outline-info float-right" href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="Tambah Data Baru">
                            Add Data  <i class="fas fa-plus"></i> 
                        </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachInst" id="seachInst" type="text" placeholder="Search By NIM / Nama" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <table id="spd_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th>No SPD</th>
                                    <th>Pejabat Yang Memberikan Perintah</th>
                                    <th>Pegawai Yang Diperintah</th>
                                    <th>Tingkat Biaya Perjalanan Dinas</th>
                                    <th>Maksud Perjalanan Dinas</th>
                                    <th>Jenis Transportasi</th>
                                    <th>Nama Instansi</th>
                                    <th>Tanggal Pergi</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Lama</th>
                                    <th>Pengikut</th>
                                    <th>Kode Rekening</th>
                                    <th>Aksi</th>
                                    <th>Keterangn</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Trident</td>
                                    <td>Internet
                                        Explorer 4.0
                                    </td>
                                    <td>Win 95+</td>
                                    <td> 4</td>
                                    <td>X</td>
                                    <td>X</td>
                                    <td>X</td>
                                    <td>X</td>
                                    <td>X</td>
                                    <td>X</td>
                                    <td>X</td>
                                    <td>X</td>
                                    <td>
                                        <a style="margin-right:5px;" href="javascript:void(0)" id="" data-toggle="tooltip" data-placement="top" title="[ Detail Data ]"><i class="fas fa-info-circle text-info"></i></a>
                                        <a style="margin-right:5px;" href="javascript:void(0)" id="" data-toggle="tooltip" data-placement="top" title="[ Update Data ]"><i class="fas fa-edit text-warning"></i></a>
                                        <a style="margin-right:5px;" href="javascript:void(0)" id="" data-toggle="tooltip" data-placement="top" title="[ Delete Data ]"><i class="fas fa-trash text-danger"></i></a>
                                    </td>
                                    <td>X</td>      
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
        </div>

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(function() {
        /*-- DataTable To Load Data Mahasiswa --*/
        var spd = $('#spd_data').DataTable({

            "sDom": 'lrtip',
            "lengthChange": false,
            "processing": true,
            "responsive": true

        });
        $('#seachInst').keyup(function() {
            spd.search($(this).val()).draw();
        });
        /*-- /. DataTable To Load Data Mahasiswa --*/
    })
</script>
<?= $this->endSection() ?>
