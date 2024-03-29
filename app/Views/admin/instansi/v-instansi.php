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
                        <a class="btn btn-sm btn-outline-info float-right" tabindex="1" href="<?= base_url('') ?>/admin/instansi/new" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i> Add Data
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-primary float-right mr-1" tabindex="2" id="refresh" data-rel="tooltip" data-placement="top" data-container=".content" title="Reload Tabel"><i class="fa fa-retweet"></i>&ensp;Reload</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachInstan" id="seachInstan" type="text" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <table id="instan_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Instansi</th>
                                    <th>Provinsi</th>
                                    <th>Kota/Kabupaten</th>
                                    <th>Kecamatan</th>
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
        /*-- DataTable To Load Data Instansi --*/
        var url_destination = "<?= base_url('Admin/Instansi/load_data') ?>";
        var instan = $('#instan_data').DataTable({
            "sDom": 'lrtip',
            "lengthChange": false,
            "order": [],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": {
                "url": url_destination,"type": 'POST',
                "data": {"csrf_token_name": $('input[name=csrf_token_name]').val()},
                "data": function(data) {data.csrf_token_name = $('input[name=csrf_token_name]').val()},
                "dataSrc": function(response) {$('input[name=csrf_token_name]').val(response.csrf_token_name);return response.data;},
                "timeout": 15000,"error": handleAjaxError
            },
            "columnDefs": [{"targets": 0,"orderable": false,"width": "3%"}, {"targets": -1,"orderable": false,"class": "text-center","width": "10%"}, ],
        });

        function handleAjaxError(xhr, textStatus, error) { // handle error datatables
            if (textStatus === 'timeout') {
                Swal.fire({ // show sweetalert2 if error timeout
                    icon: 'error',title: 'Oops...',
                    text: 'The server took too long to send the data.',showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i>&ensp;Refresh',
                }).then((result) => {if (result.isConfirmed) {location.reload();}});
            } else {
                Swal.fire({ // show sweetalert2 if error load data
                    icon: 'error',title: 'Oops...',
                    text: 'Error while loading the table data. Please refresh',showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i>&ensp;Refresh',
                }).then((result) => {if (result.isConfirmed) {location.reload();}});
            }
        }
        $('#seachInstan').keyup(function() {instan.search($(this).val()).draw();}); // because we make custom search we need Initialize it
        $("#refresh").on('click', function() {document.getElementById("seachInstan").value = "";instan.search("").draw();}); // refresh the table
        /*-- /. DataTable To Load Data Instansi --*/

        $(document).on('click', '.delete', function() { // ajax proccess delete
            swalWithBootstrapButtons.fire({ // show order confirmation delete in sweetalert2
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) { // process if we click delete or confirm == true
                    var id = $(this).data('id');
                    var url_destination = "<?= base_url('Admin/Instansi/Delete') ?>";
                    $.ajax({
                        url: url_destination,method: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()}, // send id & csrftoken
                        dataType: "JSON",
                        success: function(data) {
                            $('input[name=csrf_token_name]').val(data.csrf_token_name) // new token controller send to us
                            if (data.success) { // if success delete it
                                swalWithBootstrapButtons.fire({
                                    icon: 'success',title: 'Deleted!',text: data.msg,
                                    showConfirmButton: true,timer: 4000
                                });
                                $('#instan_data').DataTable().ajax.reload(null, false);
                            } else { // if fail delete
                                swalWithBootstrapButtons.fire({
                                    icon: 'error',title: 'Not Deleted!',text: data.msg,
                                    showConfirmButton: true,timer: 4000
                                });
                                $('#instan_data').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                    });
                }
            })
        })

    })
</script>
<?= $this->endSection() ?>
