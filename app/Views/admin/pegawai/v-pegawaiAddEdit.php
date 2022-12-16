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

                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title pt-1">Data <?= ucwords(strtolower($title)) ?></h3>
                        <!-- <a class="btn btn-sm btn-outline-info float-right" tabindex="1" href="#" data-rel="tooltip" data-placement="left" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i> Add Data
                        </a> -->
                    </div>
                    <!-- /.card-header -->


                    <form class="form-horizontal" role="form" id="form-addedit" autocomplete="off" onsubmit="return false" enctype="multipart/form-data">
                        <div class="card-body">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <input type="hidden" id="methodPage" value="<?= $method ?>" />
                            <input type="hidden" name="hiddenID" id="hiddenIDPage" value="<?= $hiddenID ?>" />
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="nipForm" class="col-sm-3 col-form-label">NIP</label>
                                            <div class="col-sm-7">
                                                <input type="number" name="nipAddEditForm" class="form-control" id="nipForm" placeholder="Nomer NIP" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="25" autofocus />
                                                <div class="invalid-feedback nipErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="namaForm" class="col-sm-3 col-form-label">Nama </label>
                                            <div class="col-sm-7">
                                                <input type="text" name="namaAddEditForm" class="form-control" id="namaForm" placeholder="Nama Lengkap"/>
                                                <div class="invalid-feedback namaErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lahirForm" class="col-sm-3 col-form-label">Tanggal Lahir </label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="lahirAddEditForm" id="lahirForm" placeholder="Nama Lengkap"/>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback lahirErrorForm"></div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="jabatanForm" class="col-sm-3 col-form-label">Jabatan</label>
                                            <div class="col-sm-7">
                                                <select name="jabatanAddEditForm" id="jabatanForm" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari Jabatan ---</option>
                                                </select>
                                                <div class="invalid-feedback jabatanErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pangolForm" class="col-sm-3 col-form-label">Pangkat & Golongan</label>
                                            <div class="col-sm-7">
                                                <select name="pangolAddEditForm" id="pangolForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Provinsi Terlebih Dahulu ---</option>
                                                </select>
                                                <div class="invalid-feedback pangolErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pelaksanaForm" class="col-sm-3 col-form-label">Pelaksana</label>
                                            <div class="col-sm-7">
                                                <select name="pelaksanaAddEditForm" id="pelaksanaForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Pelaksana ---</option>
                                                    <option value="Kasi Pelayan"> Kasi Pelayan </option>
                                                    <option value="Kasi Pengawasan"> Kasi Pengawasan</option>
                                                </select>
                                                <div class="invalid-feedback pelaksanaErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="fotoForm" class="col-sm-3 col-form-label">Foto</label>
                                            <div class="col-sm-7">
                                                <div class="custom-file">
                                                    <input type="file" name="fotoAddEditForm" class="custom-file-input" id="fotoForm">
                                                    <label class="custom-file-label" for="fotoForm">Choose file</label>
                                                    <div class="invalid-feedback fotoErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="usernameForm" class="col-sm-3 col-form-label">Username</label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">@</span>
                                                    </div>
                                                    <input type="text" name="usernameAddEditForm" id="usernameForm" class="form-control" placeholder="Username">
                                                    <div class="invalid-feedback usernameErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="passwordForm" class="col-sm-3 col-form-label">Password</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="passwordAddEditForm" id="passwordForm" aria-describedby="passwordHelp" class="form-control" placeholder="Masukkan Password">
                                                <small id="passwordHelp" class="form-text text-muted"></small>
                                                <div class="invalid-feedback passwordErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="levelForm" class="col-sm-3 col-form-label">Level</label>
                                            <div class="col-sm-7">
                                                <select name="levelAddEditForm" id="levelForm" class="form-control select2bs4" style="width: 100%;">
                                                    <!-- <option value="">--- Level Access ---</option>
                                                    <option value="Admin"> Admin </option>
                                                    <option value="Kepala Bidang"> Kepala Bidang</option>
                                                    <option value="Bendahara"> Bendahara</option>
                                                    <option value="Pegawai"> Pegawai</option> -->
                                                </select>
                                                <div class="invalid-feedback levelErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer" style="text-align:center;">
                            <a type="button" href="<?= base_url('') ?>/Admin/Pegawai" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i>&ensp;Back</a>
                            <button type="submit" id="submit-pegawai" class="btn btn-success ml-2"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
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

        // (envent.code == 13) press enter
        // preventDefault to stay in modal when keycode 13 / when we press enter default activity is submit so we remove it make it false
        $('form input').keydown(function(event) {if (event.keyCode == 13) {event.preventDefault();return false;}});

        $('#nipForm').keydown(function(event){if(event.keyCode == 13){$('#namaForm').focus();}}); // if we press enter after this we will redirect in nama columns
        $('#namaForm').keydown(function(event){if(event.keyCode == 13){$('#lahirForm').focus();}});
        $('#lahirForm').keydown(function(event){if(event.keyCode == 13){$('#jabatanForm').select2('open');}});

        $('#jabatanForm').on('select2:select', function(e) {$('#pangolForm').select2('open');});
        $('#pangolForm').on('select2:select', function(e) {$('#pelaksanaForm').select2('open');});
        $('#pelaksanaForm').on('select2:select', function(e) {$('#fotoForm').focus();});
        $('#fotoForm').keydown(function(event){if(event.keyCode == 13){$('#usernameForm').focus();}});
        $('#usernameForm').keydown(function(event){if(event.keyCode == 13){$('#passwordForm').focus();}});
        $('#passwordForm').keydown(function(event) {if (event.keyCode == 13) {$('#levelForm').select2('open');}});
        $('#levelForm').on('select2:select', function(e) {$('#submit-pegawai').focus();});
        update(); // running when method == uppdate

        function clearform() { // clear form after success insert or update the data
            $('#form-addedit')[0].reset();
            $("#nipForm").empty();$("#nipForm").removeClass('is-valid');$("#nipForm").removeClass('is-invalid');
            $("#namaForm").empty();$("#namaForm").removeClass('is-valid');$("#namaForm").removeClass('is-invalid');
            $("#lahirForm").empty();$("#lahirForm").removeClass('is-valid');$("#lahirForm").removeClass('is-invalid');
            $("#jabatanForm").empty();$("#jabatanForm").removeClass('is-valid');$("#jabatanForm").removeClass('is-invalid');
            $("#pangolForm").empty();$("#pangolForm").removeClass('is-valid');$("#pangolForm").removeClass('is-invalid');
            $("#pelaksanaForm").empty();$("#pelaksanaForm").removeClass('is-valid');$("#pelaksanaForm").removeClass('is-invalid');
            $("#fotoForm").empty();$("#fotoForm").removeClass('is-valid');$("#fotoForm").removeClass('is-invalid');
            $("#usernameForm").empty();$("#usernameForm").removeClass('is-valid');$("#usernameForm").removeClass('is-invalid');
            $("#passwordForm").empty();$("#passwordForm").removeClass('is-valid');$("#passwordForm").removeClass('is-invalid');
            $("#levelForm").empty();$("#levelForm").removeClass('is-valid');$("#levelForm").removeClass('is-invalid');
        }

        bsCustomFileInput.init();
        $("#pelaksanaForm").select2({theme: 'bootstrap4'});$("#levelForm").select2({theme: 'bootstrap4'});
        $('input[name="lahirAddEditForm"]').daterangepicker({
            autoApply: true,singleDatePicker: true,
            showDropdowns: true,startDate:moment(),    
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        // Load Data Select2 Array
        $('#levelForm').select2({
            theme: 'bootstrap4',
            dropdownAutoWidth: true,
            width: '100%',
            placeholder: '---Pilih jenis Level ---',
            data: [{id:'Admin',text:'Admin'},{id: 'Kepala Bidang',text: 'Kepala Bidang'},{id: 'Bendahara',text: 'Bendahara'},{id: 'Pegawai',text: 'Pegawai'}]
        });

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Pegawai/getjabatan') ?>';
        $("#jabatanForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Jabatan ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data,};
                },
                cache: true
            }
        });
        // Initialize select2
        var url_destination = '<?= base_url('Admin/Pegawai/getPangol') ?>';
        $("#pangolForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Pangkat & Golongan ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                },
                cache: true
            }
        })

        $('#form-addedit').on('submit', function(event) {  // insert and update submit here send to conttoller using ajax
            event.preventDefault();
            if ($('#methodPage').val() === 'New') {var url_destination = "<?= base_url('Admin/Pegawai/Create') ?>"; // url create
            } else {var url_destination = "<?= base_url('Admin/Pegawai/Update') ?>";} // url update
            $.ajax({url: url_destination,type: "POST",data: new FormData(this),processData:false,contentType:false,cache:false,async:false,
                beforeSend: function() { // function before send data
                    $('#submit-pegawai').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-pegawai').prop('disabled', true);
                },
                complete: function() { // function run when data has been send and complete
                    $('#submit-pegawai').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-pegawai').prop('disabled', false);
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
                    if (data.success==true) {
                        clearform(); // clear form after data success inputed
                        let timerInterval
                        swalWithBootstrapButtons.fire({ // show notication using sweetalert2
                            icon: 'success',title: 'Berhasil Memasukkan Data',
                            html: '<b>Otomatis Ke Table Pegawai!</b><br>' +
                                'Tekan No Jika Ingin Memasukkan Data Yang Lainnya',
                            timer: 3500,timerProgressBar: true,
                            showCancelButton: true,confirmButtonText: 'Ya, Kembali!',cancelButtonText: 'No, cancel!',reverseButtons: true,
                        }).then((result) => {
                            if (result.isConfirmed) {window.location.href = data.redirect;
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if ($('#methodPage').val() === 'New') {location.reload();
                                }else{window.location.replace("<?= base_url('Admin/Pegawai/new')?>");}
                            } else if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = data.redirect;
                            }
                        })
                    } else { // error while proccessing the data 
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("kode_", "");
                            var remove = key.replace("tgl_", "");
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
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);} // error ajax
            });
        })

        function update() { // display single data
            if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {
                var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Admin/Pegawai/single_data') ?>";
                $.ajax({
                    url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        $('#submit-pegawai').removeClass("btn-success");
                        $('#submit-pegawai').addClass("btn-warning text-white");
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        $('#nipForm').val(data.nip);
                        $('#namaForm').val(data.nama);
                        var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                        var lahir = new Date(data.tgl_lahir);var curr_date = lahir.getDate();var curr_month = lahir.getMonth();var curr_year = lahir.getFullYear();
                        $('#lahirForm').val(curr_date + "/" + m_names[curr_month] + "/" + curr_year);
                        $("#jabatanForm").append($("<option selected='selected'></option>")
                        .val(data.jabatan.kode).text(data.jabatan.nama_jabatan)).trigger('change');
                        $("#pangolForm").append($("<option selected='selected'></option>")
                        .val(data.pangol.kode).text(data.pangol.nama_pangol)).trigger('change');
                        $("#pelaksanaForm").val(data.pelaksana).trigger('change');
                        $("#usernameForm").val(data.username);
                        $("#passwordHelp").html("Kosongkan Jika Tidak Ingin mengganti Password");
                        $("#levelForm").val(data.level).trigger('change');
                        $('#submit-pegawai').html('<i class="fas fa-save"></i>&ensp;Update');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
            }
        }

    })
</script>
<?= $this->endSection() ?>
