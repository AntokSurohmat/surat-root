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
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachPangol" id="seachPangol" type="text" placeholder="Search By Kode / Nama Pangkat & Golongan" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- <input type="text" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" class="form-control" /> -->
                        <table id="pangol_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Pangkat & Golongan</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                            </thead>
                            <!-- <tbody>
                                <tr>
                                    <td>Trident</td>
                                    <td>Internet
                                        Explorer 4.0
                                    </td>
                                    <td>
                                        <a style="margin-right:5px;" href="javascript:void(0)" id="" data-rel="tooltip" data-placement="top" title="[ Detail Data ]"><i class="fas fa-info-circle text-info"></i></a>
                                        <a style="margin-right:5px;" href="javascript:void(0)" id="" data-rel="tooltip" data-placement="top" title="[ Update Data ]"><i class="fas fa-edit text-warning"></i></a>
                                        <a style="margin-right:5px;" href="javascript:void(0)" id="" data-rel="tooltip" data-placement="top" title="[ Delete Data ]"><i class="fas fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                            </tbody> -->
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
                            <?= csrf_field() ?>
                            <div class="form-group row">
                                <label for="kdPangol" class="col-sm-4 col-form-label">Kode</label>
                                <div class="col-sm-7">
                                    <input type="number" name="kd_pangol" class="form-control" id="kdPangol" placeholder="Kode Pangkat& Golongan" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="10" />
                                    <span id="kd_pangol_error" class="text-danger"></span>
                                </div>
                                <span>
                                    <button type="button" class="btn btn-default" data-rel="tooltip" title="Generate kode" id="generate-kode" onclick="generate_kode()"> <i class="fa fa-retweet" aria-hidden="true"></i> </button>
                                </span>
                            </div>
                            <div class="form-group row">
                                <label for="namaPangol" class="col-sm-4 col-form-label">Nama Pangkat & Golongan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nama_pangol" id="namaPangol" placeholder="Nama Pangkat & Golongan" />
                                    <span id="nama_pangol_error" class="text-danger"></span>
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
    $(function() {

        // var meta = document.getElementsByTagName("meta")[2];
        // var tokenHash = meta.content;
        // $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
        //     jqXHR.setRequestHeader('X-CSRF-Token', tokenHash);
        // });

        /*$.ajaxSetup({
            headers: {
                'X-CSRF-Token' : tokenHash
            }
        });*/

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
                    'csrf_token_name':$('meta[name=csrf_token_name]').attr("content")
                },
                dataSrc: function ( response ) {
                        if(response.csrf_token_name !== undefined) $('meta[name=csrf_token_name]').attr("content", response.csrf_token_name);
                        return response.data;
                },
                "dataSrc": function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return response.data;
                }
            },
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                },
                {
                    class: "text-center",
                    targets: [3]
                },
            ]
        });
        $('#seachPangol').keyup(function() {
            pangol.search($(this).val()).draw();
        });
        /*-- /. DataTable To Load Data Pangol --*/

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

            $.ajax({
                url: "<?= base_url('Admin/PangolController/Create') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");
                    $('#submit-btn').prop('disabled', true);
                },
                success: function(data) {
                    $('submit-btn').val('Add');
                    $('#submit-btn').attr('disabled', false);
                    if (data.error == true) {
                        $.each(data.messages, function(key, value) {
                            var element = $('#' + key);
                            element.closest('.form-control')
                                .removeClass('is-invalid')
                                .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');
                            element.closest('div.form-group').find('.text-danger')
                                .remove();
                            element.after(value);
                        });
                    } else {

                    }
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>
