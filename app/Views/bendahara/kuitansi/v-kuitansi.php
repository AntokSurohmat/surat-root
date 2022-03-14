<?= $this->extend('bendahara/layouts/default') ?>

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
                        <a class="btn btn-sm btn-outline-info float-right" href="javascript:void(0)" data-rel="tooltip" data-placement="left" title="Tambah Data Baru">
                            Add Data  <i class="fas fa-plus"></i> 
                        </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachKuit" id="seachKuit" type="text" placeholder="Search By NIM / Nama" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <table id="kui_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No SPD</th>
                                    <th>Nama Pegawai</th>
                                    <th>Pegawai Yang Diperintah</th>
                                    <th>Nama Instansi</th>
                                    <th>Tanggal Pergi</th>
                                    <th>Tanggal Kembali</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
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
        var kui = $('#kui_data').DataTable({

            "sDom": 'lrtip',
            "lengthChange": false,
            "processing": true,
            "responsive": true

        });
        $('#seachKuit').keyup(function() {
            kui.search($(this).val()).draw();
        });
        /*-- /. DataTable To Load Data Mahasiswa --*/
    })
</script>
<?= $this->endSection() ?>
