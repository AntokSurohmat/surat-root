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
                        <a class="btn btn-sm btn-outline-info float-right" id="add-data" tabindex="1" href="#" data-rel="tooltip" data-placement="left" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i>&ensp;Add Data
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-primary float-right mr-1" tabindex="2" id="refresh" data-rel="tooltip" data-placement="top" title="Reload Tabel"><i class="fa fa-retweet"></i>&ensp;Reload</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <!-- <h2 class="text-center display-4">Search</h2>
                        <div class="row">
                            <div class="col-md-12">

                                    <div class="input-group">
                                        <input type="search" name="seachPangol" id="seachPangol" class="form-control form-control-lg" placeholder="Type your keywords here">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-lg btn-default">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>

                            </div>
                        </div> -->


                        <div class="input-group mb-2">
                            <input class="form-control col-sm-12" name="seachPangol" id="seachPangol" type="text" placeholder="Search By Kode / Nama Pangkat & Golongan" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="form-control" />
                        <table id="pangol_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Pangkat & Golongan</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
        </div>

        <!--add/edit-->
        <div id="modal-newitem" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AddEditPangol" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add/Edit Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" role="form" id="form-addedit" autocomplete="off">
                        <div class="modal-body">
                            <input type="hidden" id="hidden_id" name="hidden_id" />
                            <input type="hidden" id="method" name="action" />
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <div class="form-group row">
                                <label for="kode" class="col-sm-4 col-form-label">Kode</label>
                                <div class="col-sm-7">
                                    <input type="number" name="kode" class="form-control" id="kode" placeholder="Kode Pangkat& Golongan" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="10" />
                                    <div class="invalid-feedback kodeError"></div>
                                </div>
                                <span>
                                    <button type="button" class="btn btn-default" data-rel="tooltip" title="Generate kode" id="generate-kode" onclick="generate_kode()"> <i class="fa fa-retweet" aria-hidden="true"></i> </button>
                                </span>
                            </div>
                            <div class="form-group row">
                                <label for="nama_pangol" class="col-sm-4 col-form-label">Nama Pangkat & Golongan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nama_pangol" id="nama_pangol" placeholder="Nama Pangkat & Golongan" />
                                    <div class="invalid-feedback nama_pangolError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="submit" id="submit-btn" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {

        /*-- DataTable To Load Data Pangol --*/
        var pangol = $('#pangol_data').DataTable({

            "sDom": 'lrtip',
            "lengthChange": false,
            "order": [],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= base_url('Admin/PangolController/load_data') ?>",
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
            // "drawCallback": function(settings) {
            //     $('<li><a role="button" class="btn btn-outline-primary" data-rel="tooltip" data-placement="top" title="Reload Table" onclick="refresh_tab()" ><i class="fa fa-retweet"></i></a></li>').prependTo('div.dataTables_paginate ul.pagination');
            // },
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                },
                {
                    "targets": [3],
                    "orderable": false
                },
                {
                    "class": "text-center",
                    "targets": [3]
                },
            ],
        });

        function handleAjaxError(xhr, textStatus, error) {
            if (textStatus === 'timeout') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'The server took too long to send the data.',
                    showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i> Refresh',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("seachPangol").value = "";
                        pangol.search("").draw();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error while loading the table data. Please refresh',
                    showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i> Refresh',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("seachPangol").value = "";
                        pangol.search("").draw();
                    }
                });
            }
        }
        $('#seachPangol').keyup(function() {
            pangol.search($(this).val()).draw();
            // console.log($(this).val());
            // var value = $(this).val();
            // if(value.length == ''){
            //     console.log("OK");
            // }else{
            //     console.log("NOt null")
            // }

        });
        /*-- /. DataTable To Load Data Pangol --*/

        $("#refresh").on("click", function() {
            document.getElementById("seachPangol").value = "";
            pangol.search("").draw();
        });

        $('#modal-newitem').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#kdPangol").empty();
            $("#namaPangol").empty();
        });
        $('#modal-newitem').on('shown.bs.modal', function() {
            $('#kdPangol').focus();
        });

        $('#add-data').click(function() {
            var option = {
                backdrop: 'static',
                keyboard: true
            };
            $('#modal-newitem').modal(option);
            $('#form-addedit')[0].reset();
            $('#action').val('Add');
            $('#submit-btn').html('<i class="fas fa-save"></i>&ensp;Submit');
            $('#kd_pangol_error').text('');
            $('#nama_pangol_error').text('');
            $('#modal-newitem').modal('show');
        });

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();

            // console.log($(this).serialize());
            $.ajax({
                url: "<?= base_url('Admin/PangolController/Create') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");
                    $('#submit-btn').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn').html("<i class='fa fa-save'></i>&ensp;Submit");
                    $('#submit-btn').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    // console.log(data.error);
                    if (data.error) {
                        // if (data.error.kode) {
                        // $('#kode').addClass('is-invalid');
                        // $('.kodeError').html(data.error.kode);
                        // } else {
                        //     $('#kode').addClass('is-valid');
                        //     $('.kodeError').html();
                        // }

                        // const keys = Object.keys(data.error);
                        // console.log(keys);

                        // [ 'java', 'javascript', 'nodejs', 'php' ]

                        // iterate over object

                        Object.keys(data.error).forEach((key, index) => {
                            console.log(`${key}: ${data.error[key]} : ${key}Error`);
                            var element = $('#' + key);
                            $("#" + key).addClass('is-invalid');
                            $("." + key + "Error").html(data.error[key]);
                            // console.log(key);
                            var element = $('#' + key);
                            element.closest('.form-control')
                                .removeClass('is-invalid')
                                .addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                            // element.closest('div.form-group').find('.invalid-feedback')
                            //     .remove();
                            // element.after(value);
                            console.log(element);
                        });


                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        })
    })

    // function refresh_tab() {
    //     document.getElementById("seachPangol").value = "";
    //     pangol.search( "" ).draw();
    // }
</script>
<?= $this->endSection() ?>