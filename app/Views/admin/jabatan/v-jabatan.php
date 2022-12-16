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
                        <a class="btn btn-sm btn-outline-info float-right" id="add-data" tabindex="1" href="javascript:void(0)" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i>&ensp;Add Data
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-primary float-right mr-1" tabindex="2" id="refresh" data-rel="tooltip" data-placement="top" data-container=".content" title="Reload Table"><i class="fa fa-retweet"></i>&ensp;Reload</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group mb-2">
                            <input class="form-control col-sm-12" name="searchJbtan" id="searchJbtan" type="text" placeholder="Search" aria-label="Search" autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>

                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <table id="jbtan_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Jabatan</th>
                                    <th>Aksi</th>
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
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="hidden" name="method" id="method" />
                            <input type="hidden" name="<?= csrf_token() ?>" value="<? csrf_hash() ?>">
                            <div class="form-group row">
                                <label for="kodeForm" class="col-sm-4 col-form-label">Kode</label>
                                <div class="col-sm-7">
                                    <input type="number" name="kodeAddEditForm" id="kodeForm" class="form-control" placeholder="Kode Jabatan" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" />
                                    <div class="invalid-feedback kodeErrorForm"></div>
                                </div>
                                <span>
                                    <button type="button" class="btn btn-default" data-rel="tooltip" data-placement="top" data-container=".content" title="Generate kode" id="generate-kode" > <i class="fa fa-retweet" aria-hidden="true"></i> </button>
                                </span>
                            </div>
                            <div class="form-group row">
                                <label for="jabatanForm" class="col-sm-4 col-form-label">Nama Jabatan</label>
                                <div class="col-sm-7">
                                    <input type="text" name="jabatanAddEditForm" id="jabatanForm" class="form-control" placeholder="Nama Jabatan" />
                                    <div class="invalid-feedback jabatanErrorForm"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="submit" id="submit-btn" class="btn btn-sm btn-success"><i class="fa fas-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal  -->

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {

        // (envent.code == 13) press enter
        // preventDefault to stay in modal when keycode 13 / when we press enter default activity is submit so we remove it make it false
        $('form input').keydown(function(event) {if (event.keyCode == 13) {event.preventDefault();return false;}});

        /*-- DataTable To Load Data --*/
        var url_destination = "<?= base_url('Admin/Jabatan/load_data') ?>";
        var jbtan = $('#jbtan_data').DataTable({
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
            "columnDefs": [{"targets": 0,"orderable": false, "width": "3%"}, {"targets": -1,"orderable": false,"class": "text-center","width": "13%"}, ],
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
        $('#searchJbtan').keyup(function() {jbtan.search($(this).val()).draw();}); // because we make custom search we need Initialize it
        $("#refresh").on('click', function() {document.getElementById("searchJbtan").value = "";jbtan.search("").draw();}); // refresh the table
        /*-- DataTable To Load Data --*/

        $('#modal-newitem').on('hidden.bs.modal', function() { // function run when modal close
            $(this).find('form')[0].reset();
            $("#kodeForm").empty();$("#kodeForm").removeClass('is-valid');$("#kodeForm").removeClass('is-invalid');
            $("#jabatanForm").empty();$("#jabatanForm").removeClass('is-valid');$("#jabatanForm").removeClass('is-invalid');
        });
        $('#modal-newitem').on('shown.bs.modal', function() { // function run when modal open
            $("#kodeForm").focus();
            $('#kodeForm').keydown(function(event) {if (event.keyCode == 13) {$('#jabatanForm').focus();}});
            $('#jabatanForm').keydown(function(event) {if (event.keyCode == 13) {$('#submit-btn').focus();}});
        });
        $('#add-data').click(function() { // button to trigger modal open new insert
            var option = {backdrop: 'static',keyboard: true,}
            $('#modal-newitem').modal(option);
            $('#form-addedit')[0].reset();$('#method').val('New');
            $('#submit-btn').html('<i class="fas fa-save"></i>&ensp;Submit');$('#modal-newitem').modal('show');
        })

        $(document).on('click', '.edit', function() { // function run when modal open update data
            var id = $(this).data('id');var url_destination = "<?= base_url('Admin/Jabatan/single_data') ?>";
            $.ajax({
                url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#kodeForm').val(data.kode);$('#jabatanForm').val(data.nama_jabatan);
                    $('.modal-title').text('Edit Data ' + data.nama_jabatan);$('.modal-title').css("font-weight", "900");
                    $('#method').val('Edit');$('#hidden_id').val(id);
                    $('#submit-btn').html('<i class="fas fa-save"></i>&ensp;Update');$('#submit-btn').removeClass("btn-success");
                    $('#submit-btn').addClass("btn-warning text-white");$('#modal-newitem').modal('show');
                }
            })
        })

        $(document).on('click', '.delete', function() { // ajax proccess delete
            swalWithBootstrapButtons.fire({ // show order confirmation delete in sweetalert2
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) { // process if we click delete or confirm == true
                    var id = $(this).data('id');
                    var url_destination = "<?= base_url('Admin/Jabatan/Delete') ?>";
                    $.ajax({
                        url: url_destination,method: "POST",
                        data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()}, // send id & csrftoken
                        dataType: "JSON",
                        success: function(data) {
                            $('input[name=csrf_token_name]').val(data.csrf_token_name) // new token controller send to us
                            $('#jbtan_data').DataTable().ajax.reload(null, false); // reload the table without reload the page
                            if (data.success) { // if success delete it
                                swalWithBootstrapButtons.fire({
                                    icon: 'success',title: 'Deleted!',text: data.msg,
                                    showConfirmButton: true,timer: 3000
                                })
                            } else { // if fail delete
                                $('#jbtan_data').DataTable().ajax.reload(null, false);
                                swalWithBootstrapButtons.fire({
                                    icon: 'error',title: 'Not Deleted!',text: data.msg,
                                    showConfirmButton: true,timer: 3000
                                })
                            }
                        },
                        error: function(xhr, ajaxOptions, throwError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + throwError);}
                    });
                }
            })
        })

        $('#form-addedit').on('submit', function(event) { // insert and update submit here send to conttoller using ajax
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Jabatan/Save') ?>"; // url save
            $.ajax({
                url: url_destination,type: "POST",data: $(this).serialize(), // serialize the data
                dataType: "JSON",
                beforeSend: function() {  // function before send data
                    $('#submit-btn').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-btn').prop('disabled', true);
                },
                complete: function() { // function run when data has been send and complete
                    $('#submit-btn').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-btn').prop('disabled', false);
                },
                success: function(data) { // function when send succesfully
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) { // while error processing or data not complited yet
                        Object.keys(data.error).forEach((key, index) => { // display error Form
                            $("#" + key + 'Form').addClass('is-invalid');$("." + key + "ErrorForm").html(data.error[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                    }
                    if (data.success == true) { // show notication using sweetalert2
                        $("#modal-newitem").modal('hide'); // hide the modal
                        Swal.fire({
                            icon: 'success',title: 'Berhasil..',text: data.msg,
                            showConfirmButton: false,timer: 2000
                        });
                        $('#jbtan_data').DataTable().ajax.reload(null, false);
                    } else { // error while proccessing the data 
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("nama_", "");
                            $("#" + remove + 'Form').addClass('is-invalid');
                            $("." + remove + "ErrorForm").html(data.msg[key]);
                            var element = $('#' + remove + 'Form');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        if (data.msg != "") {
                            toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"](data.error, "Informasi");
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);} // error ajax
            });
            return false;
        })

        $('#generate-kode').click(function() { // generate code
            var url_destination = "<?= base_url('Admin/Jabatan/generator') ?>";
            $.ajax({
                url: url_destination,type: "POST",data: {csrf_token_name: $('input[name=csrf_token_name]').val()},
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);$('#kodeForm').val(data.kode);
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>
