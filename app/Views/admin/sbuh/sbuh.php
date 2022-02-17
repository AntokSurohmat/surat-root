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
                        <h3 class="card-title pt-1">DataTable with minimal features & hover style</h3>
                        <a class="btn btn-sm btn-outline-info float-right" href="#">
                            <i class="fas fa-plus"></i> Add Data
                        </a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachJbt" id="seachJbt" type="text" placeholder="Search By NIM / Nama" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <table id="jbt_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Pangkat</th>
                                    <th>jabatan</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Foto</th>
                                    <th>Pelaksana Teknik Kegiatan</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Level Akses</th>
                                    <th>Aksi</th>
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
                                    <td>
                                        <a style="margin-right:10px" href="#" title="Detail"><i class="fas fa-info-circle text-info"></i></a>
                                        <a style="margin-right:10px" href="#" title="Edit"><i class="fa-solid fa-user-pen text-warning"></i></a>
                                        <a style="margin-right:10px" href="#" id="" title="Delete"><i class="fas fa-trash text-danger"></i></a>
                                    </td>
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

<script type="text/javascript">
    window.onload = function() {
        /*-- DataTable To Load Data Mahasiswa --*/
        var jbt = $('#jbt_data').DataTable({

            "sDom": 'lrtip',
            "lengthChange": false,
            "processing": true,
            "responsive": true

        });
        $('#seachJbt').keyup(function() {
            jbt.search($(this).val()).draw();
        });
        /*-- /. DataTable To Load Data Mahasiswa --*/

    }
</script>

<?= $this->endSection() ?>
