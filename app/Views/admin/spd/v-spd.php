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
                    <a class="btn btn-sm btn-outline-info float-right" tabindex="1" href="<?= base_url('') ?>/Admin/Spd/new" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i> Add Data
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-primary float-right mr-1" tabindex="2" id="refresh" data-rel="tooltip" data-placement="top" data-container=".content" title="Reload Tabel"><i class="fa fa-retweet"></i>&ensp;Reload</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachSpd" id="seachSpd" type="text" placeholder="Search By NIM / Nama" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <table id="spd_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No SPD</th>
                                    <th>Pejabat Yang Memberikan Perintah</th>
                                    <th>Pegawai Yang Diperintah</th>
                                    <th>Maksud Perjalanan Dinas</th>
                                    <th>Kendaraan</th>
                                    <th>Keterangan</th>
                                    <th style="width: 10%;">Aksi</th>
                                    <th>Status</th>
                                </tr>
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
        var url_destination = "<?= base_url('Admin/Spd/load_data') ?>";
        var spd = $('#spd_data').DataTable({
            "sDom": 'lrtip',"lengthChange": false,"order": [],
            "processing": true,"responsive": true,"serverSide": true,
            "ajax": {"url": url_destination,"type": 'POST',
                "data": {"csrf_token_name": $('input[name=csrf_token_name]').val()},
                "data": function(data) {data.csrf_token_name = $('input[name=csrf_token_name]').val()},
                "dataSrc": function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return response.data;
                },
                "timeout": 15000,"error": handleAjaxError
            },
            "columnDefs": [
                {"targets": [0],"orderable": false},
                {"targets": [6],"orderable": false,"class": "text-center"},
                {"targets": [7],"class": "text-center"}
            ],
        });

        function handleAjaxError(xhr, textStatus, error) {
            if (textStatus === 'timeout') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'The server took too long to send the data.',
                    showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i>&ensp;Refresh',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("seachSpd").value = "";
                        spd.search("").draw();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error while loading the table data. Please refresh',
                    showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i>&ensp;Refresh',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("seachSpd").value = "";
                        spd.search("").draw();
                    }
                });
            }
        }
        $('#seachSpd').keyup(function() {
            spd.search($(this).val()).draw();
        });
                $("#refresh").on('click', function() {
            document.getElementById("seachSpd").value = "";
            spd.search("").draw();
        });
        /*-- /. DataTable To Load Data Mahasiswa --*/
    })
</script>
<?= $this->endSection() ?>
