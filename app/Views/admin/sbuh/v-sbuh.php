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

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title pt-1">Data <?= ucwords(strtolower($title)) ?></h3>
                        <a class="btn btn-sm btn-outline-info float-right" tabindex="1" href="<?= base_url('') ?>/admin/sbuh/new" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i> Add Data
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-primary float-right mr-1" tabindex="2" id="refresh" data-rel="tooltip" data-placement="top" data-container=".content" title="Reload Tabel"><i class="fa fa-retweet"></i>&ensp;Reload</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachSbuh" id="seachSbuh" type="text" placeholder="Search By NIM / Nama" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <table id="sbuh_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Provinsi</th>
                                    <th>Kota/Kabupaten</th>
                                    <th>Kecamatam</th>
                                    <th>Jenis Wilayah</th>
                                    <th>Zonasi</th>
                                    <th>Pangkat</th>
                                    <th>Uang Harian</th>
                                    <th>Aksi</th>
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
 $(document).ready(function() {
        /*-- DataTable To Load Data Wilayah --*/
        var url_destination = "<?= base_url('Admin/Sbuh/load_data') ?>";
        var sbuh = $('#sbuh_data').DataTable({
            "sDom": 'lrtip',
            "lengthChange": false,
            "order": [],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": {
                "url": url_destination,
                "type": 'POST',
                "data": {
                    "csrf_token_name": $('input[name=csrf_token_name]').val()
                },
                "data": function(data) {
                    data.csrf_token_name = $('input[name=csrf_token_name]').val()
                },
                "dataSrc": function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return response.data;
                },
                "timeout": 15000,
                "error": handleAjaxError
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }, {
                "targets": [9],
                "orderable": false,
                "class": "text-center",
            }, ],
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
                        document.getElementById("seachSbuh").value = "";
                        sbuh.search("").draw();
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
                        document.getElementById("seachSbuh").value = "";
                        sbuh.search("").draw();
                    }
                });
            }
        }
        $('#seachSbuh').keyup(function() {
            sbuh.search($(this).val()).draw();
        });
        $("#refresh").on('click', function() {
            document.getElementById("seachSbuh").value = "";
            sbuh.search("").draw();
        });
        /*-- /. DataTable To Load Data Wilayah --*/

        $(document).on('click', '.delete', function() {
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    var url_destination = "<?= base_url('Admin/Sbuh/Delete') ?>";
                    $.ajax({
                        url: url_destination,
                        method: "POST",
                        data: {
                            id: id,
                            csrf_token_name: $('input[name=csrf_token_name]').val()
                        },
                        dataType: "JSON",
                        success: function(data) {
                            $('input[name=csrf_token_name]').val(data.csrf_token_name)
                            if (data.success) {
                                swalWithBootstrapButtons.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: data.msg,
                                    showConfirmButton: true,
                                    timer: 4000
                                });
                                $('#sbuh_data').DataTable().ajax.reload(null, false);
                            } else {
                                swalWithBootstrapButtons.fire({
                                    icon: 'error',
                                    title: 'Not Deleted!',
                                    text: data.msg,
                                    showConfirmButton: true,
                                    timer: 4000
                                });
                                $('#sbuh_data').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            })
        })

    })
</script>
<?= $this->endSection() ?>
