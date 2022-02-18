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

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Horizontal Form</h3>
                    </div>


                    <form class="form-horizontal">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="lapsptNoSpt" class="col-sm-3 col-form-label">No SPT</label>
                                            <div class="col-sm-9">
                                                <select name="no_skt" id="lapsptNoSpt" class="form-control">
                                                    <option value="">Masukkan No SPT</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lapsptNama" class="col-sm-3 col-form-label">Nama</label>
                                            <div class="col-sm-9">
                                                <select name="nama_peg" id="lapsptNama" class="form-control">
                                                    <option value="">Masukkan Nama Pegawai</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="lapsptTglPergi" class="col-sm-3 col-form-label">Tanggal Pergi</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" name="tglpergi" id="lapsptTglPergi">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lapsptTglKembali" class="col-sm-3 col-form-label">Tanggal Kembali</label>
                                            <div class="col-sm-9">
                                                <input type="date" class="form-control" name="tglkembali" id="lapsptTglKembali">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="lapsptInstansi" class="col-sm-3 col-form-label">Instansi</label>
                                            <div class="col-sm-9">
                                                <select name="instansi" id="lapsptInstansi" class="form-control">
                                                    <option value="">Masukkan Nama Instansi</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-outline-danger" data-rel="tooltip" data-placement="top" title="Reset Form">Reset</button>
                            <button type="submit" class="btn btn-outline-info" tabindex="1" data-rel="tooltip" data-placement="top" title="Cari Data Berdasarkan Kategori Yang Dimasukkan">Cari</button>
                        </div>

                    </form>
                </div>

                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title pt-1">Data <?= ucwords(strtolower($title)) ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="lapspt_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th>No SPT</th>
                                    <th>Nama Pegawai</th>
                                    <th>Dasar</th>
                                    <th>Maksud Perjalanan Dinas</th>
                                    <th>Nama Instansi</th>
                                    <th>Tanggal Pergi</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Lama</th>
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
                                    <td>
                                        <a style="margin-right:5px;" href="javascript:void(0)" id="" data-rel="tooltip" data-placement="top" title="[ Detail Data ]"><i class="fas fa-eye text-info"></i></a>
                                        <a style="margin-right:5px;" href="javascript:void(0)" id="" data-rel="tooltip" data-placement="top" title="[ Print Data ]"><i class="fas fa-print text-warning"></i></a>
                                        <a style="margin-right:5px;" href="javascript:void(0)" id="" data-rel="tooltip" data-placement="top" title="[ Print Data ]"><i class="fas fa-download text-danger"></i></a>
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
    <div class="container col-sm-6">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">



                    <form class="form-horizontal">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="cetakSeSurat" class="col-sm-9 col-form-label">Cetak Semua Surat</label>
                                            <div class="col-sm-3">
                                                <button class="btn btn-default" id="cetakSeSurat" data-rel="tooltip" data-placement="top" title="Cetak Semua Surat"><i class="fas fa-print"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="CetakReSurat" class="col-sm-9 col-form-label">Cetak Rekap Surat</label>
                                            <div class="col-sm-3">
                                                <button class="btn btn-default" id="CetakReSurat" data-rel="tooltip" data-placement="top" title="Cetak Rekap Surat"><i class="fas fa-print"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="downSeSurat" class="col-sm-9 col-form-label">Download Semua Surat</label>
                                            <div class="col-sm-3">
                                                <button class="btn btn-default" id="downSeSurat" data-rel="tooltip" data-placement="top" title="Download Semua Surat"><i class="fas fa-download"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="downReSurat" class="col-sm-9 col-form-label">Download Rekap Surat</label>
                                            <div class="col-sm-3">
                                                <button class="btn btn-default" id="downReSurat" data-rel="tooltip" data-placement="top" title="Download Rekap Surat"><i class="fas fa-download"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div><!-- /.container -->

</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(function() {
        /*-- DataTable To Load Data --*/
        var lapspt = $('#lapspt_data').DataTable({

            "searching": false,
            "lengthChange": false,
            "processing": true,
            "responsive": true

        });
        /*-- /. DataTable To Load Data --*/
    })
</script>
<?= $this->endSection() ?>
