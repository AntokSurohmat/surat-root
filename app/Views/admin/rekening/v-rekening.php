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
                        <a class="btn btn-sm btn-outline-info float-right" id="add-data" tabindex="1" href="javascript:void(0)" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i>&ensp;Add Data
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-primary float-right mr-1" tabindex="2" id="refresh" data-rel="tooltip" data-placement="top" data-container=".content" title="Reload Tabel"><i class="fa fa-retweet"></i>&ensp;Reload</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachRkning" id="seachRkning" type="text" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <table id="rkning_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Jenis Wilayah</th>
                                    <th>Nomer Rekening</th>
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

        <!--add/edit-->
        <div id="modal-newitem" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AddEditModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add/Edit Modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" role="form" id="form-addedit" autocomplete="off" onsubmit="return false">
                        <div class="modal-body">
                            <input type="hidden" id="hidden_id" name="hidden_id" />
                            <input type="hidden" id="method" name="method" />
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <div class="form-group row">
                                <label for="kodeForm" class="col-sm-4 col-form-label">Kode</label>
                                <div class="col-sm-7">
                                    <input type="number" name="kodeAddEditForm" class="form-control" id="kodeForm" placeholder="Kode Rekening" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" />
                                    <div class="invalid-feedback kodeErrorForm"></div>
                                </div>
                                <span>
                                    <button type="button" class="btn btn-default" data-rel="tooltip" data-placement="top" data-container=".content" title="Generate kode" id="generate-kode" > <i class="fa fa-retweet" aria-hidden="true"></i> </button>
                                </span>
                            </div>
                            <div class="form-group row">
                                <label for="jenisWilayahForm" class="col-sm-4 col-form-label">Jenis Wilayah</label>
                                <div class="col-sm-8">
                                    <select name="jenisWilayahAddEditForm" id="jenisWilayahForm" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Jenis Wilayah ---</option>
                                    </select>
                                    <div class="invalid-feedback jenisWilayahErrorForm"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="rekeningForm" class="col-sm-4 col-form-label">Nomer Rekening</label>
                                <div class="col-sm-8">
                                    <input type="number" name="rekeningAddEditForm" class="form-control" id="rekeningForm" placeholder="Nomer Rekening" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="12" />
                                    <div class="invalid-feedback rekeningErrorForm"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="submit" id="submit-btn" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal -->

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {

        // preventDefault to stay in modal when keycode 13
        $('form input').keydown(function(event) {if (event.keyCode == 13) {event.preventDefault();return false;}});

        /*-- DataTable To Load Data Rekening --*/
        var url_destination = "<?= base_url('Admin/Rekening/load_data') ?>";
        var rkning = $('#rkning_data').DataTable({
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
            "columnDefs": [{"targets": 0,"orderable": false,"width":"3%"}, {"targets": -1,"orderable": false,"class": "text-center","width":"10%"}, ],
        });

        function handleAjaxError(xhr, textStatus, error) {
            if (textStatus === 'timeout') {
                Swal.fire({
                    icon: 'error',title: 'Oops...',
                    text: 'The server took too long to send the data.',showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i>&ensp;Refresh',
                }).then((result) => {if (result.isConfirmed) {location.reload();}});
            } else {
                Swal.fire({
                    icon: 'error',title: 'Oops...',
                    text: 'Error while loading the table data. Please refresh',showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i>&ensp;Refresh',
                }).then((result) => {if (result.isConfirmed) {location.reload();}});
            }
        }
        $('#seachRkning').keyup(function() {rkning.search($(this).val()).draw();});
        $("#refresh").on('click', function() {document.getElementById("seachRkning").value = "";rkning.search("").draw();});
        /*-- /. DataTable To Load Data Rekening --*/

        $('#modal-newitem').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#kodeForm").empty();$("#kodeForm").removeClass('is-valid');$("#kodeForm").removeClass('is-invalid');
            $("#jenisWilayahForm").empty();$("#jenisWilayahForm").removeClass('is-valid');$("#jenisWilayahForm").removeClass('is-invalid');
            $("#rekeningForm").empty();$("#rekeningForm").removeClass('is-valid');$("#rekeningForm").removeClass('is-invalid');
        });
        $('#modal-newitem').on('shown.bs.modal', function() {
            $('#kodeForm').focus();
            $('#kodeForm').keydown(function(event) {if (event.keyCode == 13) {$('#jenisWilayahForm').select2('open');}});
            $('#jenisWilayahForm').on('select2:select', function(e) {$('#rekeningForm').focus();});
            $('#rekeningForm').keydown(function(event) {if (event.keyCode == 13) {$('#submit-btn').focus();}});
        });
        $('#add-data').click(function() {
            var option = {backdrop: 'static',keyboard: true};
            $('#modal-newitem').modal(option);
            $('#form-addedit')[0].reset();$('#method').val('New');
            $('#submit-btn').html('<i class="fas fa-save"></i>&ensp;Submit');$('#modal-newitem').modal('show');
        });

        $(document).on('click', '.edit', function() {
            var id = $(this).data('id');
            var url_destination = "<?= base_url('Admin/Rekening/single_data') ?>";
            $.ajax({
                url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#kodeForm').val(data.kode);
                    $("#jenisWilayahForm").append($("<option selected='selected'></option>")
                    .val(data.jenis.kode).text(data.jenis.jenis_wilayah)).trigger('change');
                    $('#rekeningForm').val(data.nomer_rekening);
                    $('.modal-title').text('Edit Data ' + data.nomer_rekening);$('.modal-title').css("font-weight:", "900");
                    $('#method').val('Edit');$('#hidden_id').val(id);
                    $('#submit-btn').removeClass("btn-success");$('#submit-btn').addClass("btn-warning text-white");
                    $('#submit-btn').html('<i class="fas fa-save"></i>&ensp;Update');$('#modal-newitem').modal('show');
                }
            })
        })


        // Initialize select2
        var url_destination = '<?= base_url('Admin/Rekening/getJenis') ?>';
        $("#jenisWilayahForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Jenis Wilayah ---',
            ajax: {
                url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data,};
                },
                cache: true
            }
        });

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
                    var url_destination = "<?= base_url('Admin/Rekening/Delete') ?>";
                    $.ajax({
                        url: url_destination,method: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                        dataType: "JSON",
                        success: function(data) {
                            $('input[name=csrf_token_name]').val(data.csrf_token_name)
                            if (data.success) {
                                swalWithBootstrapButtons.fire({
                                    icon: 'success',title: 'Deleted!',text: data.msg,
                                    showConfirmButton: true,timer: 4000
                                });
                                $('#rkning_data').DataTable().ajax.reload(null, false);
                            } else {
                                swalWithBootstrapButtons.fire({
                                    icon: 'error',title: 'Not Deleted!',text: data.msg,
                                    showConfirmButton: true,timer: 4000
                                });
                                $('#rkning_data').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                    });
                }
            })
        })

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Rekening/Save') ?>";
            console.log($(this).serialize());
            $.ajax({
                url: url_destination,type: "POST",data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-btn').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-btn').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key).addClass('is-invalid');
                            $("." + key + "ErrorForm").html(data.error[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                    } 
                    if (data.success==true) {
                        $("#modal-newitem").modal('hide');
                        Swal.fire({
                            icon: 'success',title: 'Berhasil..',text: data.msg,
                            showConfirmButton: false,timer: 3000
                        });
                        $('#rkning_data').DataTable().ajax.reload(null, false);
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("kode_jenis_wilayah", "jenisWilayah");
                            var remove = key.replace("nomer_", "");
                            $("#" + remove + 'Form').addClass('is-invalid');
                            $("." + remove + "ErrorForm").html(data.msg[key]);
                            var element = $('#' + remove + 'Form');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        if(data.msg != ""){
                            toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"](data.error, "Informasi");
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
            });
            return false;
        })

        $('#generate-kode').click(function() {
            var url_destination = "<?= base_url('Admin/Rekening/generator') ?>";
            $.ajax({url: url_destination,type: "POST",data: {csrf_token_name: $('input[name=csrf_token_name]').val()},
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);$('#kodeForm').val(data.kode);
                }
            })
        })

    })
</script>
<?= $this->endSection() ?>
