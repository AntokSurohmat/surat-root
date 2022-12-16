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
                    <form class="form-horizontal" role="form" id="form-addedit" autocomplete="off" onsubmit="return false">
                        <div class="card-body">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <input type="hidden" id="methodPage" value="<?= $method ?>" />
                            <input type="hidden" name="hiddenID" id="hiddenIDPage" value="<?= $hiddenID ?>" />
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="kodeForm" class="col-sm-3 col-form-label">Kode</label>
                                            <div class="col-sm-7">
                                                <input type="number" name="kodeAddEditForm" class="form-control" id="kodeForm" placeholder="Kode Instansi" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" autofocus />
                                                <div class="invalid-feedback kodeErrorForm"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-default" data-rel="tooltip" data-placement="top" data-container=".content" title="Generate kode" id="generate-kode" > <i class="fa fa-retweet" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="instansiForm" class="col-sm-3 col-form-label">Nama Instansi</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="instansiAddEditForm" class="form-control" id="instansiForm" placeholder="Masukkan Nama Instansi">
                                                <div class="invalid-feedback instansiErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="provinsiForm" class="col-sm-3 col-form-label">Provinsi</label>
                                            <div class="col-sm-7">
                                                <select name="provinsiAddEditForm" id="provinsiForm" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari Provinsi ---</option>
                                                </select>
                                                <div class="invalid-feedback provinsiErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kabupatenForm" class="col-sm-3 col-form-label">Kabupaten/Kota</label>
                                            <div class="col-sm-7">
                                                <select name="kabupatenAddEditForm" id="kabupatenForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Cari Kabupaten ---</option>
                                                </select>
                                                <div class="invalid-feedback kabupatenErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kecamatanForm" class="col-sm-3 col-form-label">Kecamatan</label>
                                            <div class="col-sm-7">
                                                <select name="kecamatanAddEditForm" id="kecamatanForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Cari Kecamatan ---</option>
                                                </select>
                                                <div class="invalid-feedback kecamatanErrorForm"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer" style="text-align:center;">
                            <a type="button" href="<?= base_url('') ?>/Admin/Instansi" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i>&ensp;Back</a>
                            <button type="submit" id="submit-instansi" class="btn btn-success ml-2"><i class="fas fa-save"></i>&ensp;Submit</button>
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

        $('#kodeForm').keydown(function(event) {if (event.keyCode == 13) {$('#instansiForm').focus();}}); // if we press enter after this we will redirect in instansi columns
        $('#instansiForm').keydown(function(event) {if (event.keyCode == 13) {$('#provinsiForm').select2('open');}});
        $('#provinsiForm').on('select2:select', function(e) {$('#kabupatenForm').select2('open');});
        $('#kabupatenForm').on('select2:select', function(e) {$('#kecamatanForm').select2('open');});
        $('#kecamatanForm').on('select2:select', function(e) {$('#submit-instansi').focus();});
        update(); 

        function clearform() { // clear form after success insert or update the data
            $('#form-addedit')[0].reset();
            $("#kodeForm").empty();$("#kodeForm").removeClass('is-valid');$("#kodeForm").removeClass('is-invalid');
            $("#instansiForm").empty();$("#instansiForm").removeClass('is-valid');$("#instansiForm").removeClass('is-invalid');
            $("#provinsiForm").empty();$("#provinsiForm").removeClass('is-valid');$("#provinsiForm").removeClass('is-invalid');
            $("#kabupatenForm").empty();$("#kabupatenForm").removeClass('is-valid');$("#kabupatenForm").removeClass('is-invalid');
            $("#kecamatanForm").empty();$("#kecamatanForm").removeClass('is-valid');$("#kecamatanForm").removeClass('is-invalid');
        }

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Instansi/getProvinsi') ?>';
        $("#provinsiForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Provinsi ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                },
                cache: true
            }
        });

        $("#provinsiForm").change(function() {
            var provinsiID = $(this).val();var url_destination = '<?= base_url('Admin/Instansi/getKabupaten') ?>';
            // Initialize select2
            $("#kabupatenForm").select2({
                theme: 'bootstrap4',
                placeholder: '--- Cari Kabupaten ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,provinsi: provinsiID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                    },
                    cache: false
                }
            })
        });

        $("#kabupatenForm").change(function() {
            var kabupatenID = $(this).val();var url_destination = '<?= base_url('Admin/Instansi/getKecamatan') ?>';
            // Initialize select2
            $("#kecamatanForm").select2({
                theme: 'bootstrap4',
                placeholder: '--- Cari Kecamatan ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,kabupaten: kabupatenID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                    },
                    cache: true
                }
            })
        });

        $('#form-addedit').on('submit', function(event) { // insert and update submit here send to conttoller using ajax
            event.preventDefault();
            if ($('#methodPage').val() === 'New') {var url_destination = "<?= base_url('Admin/Instansi/Create') ?>"; // url create
            } else {var url_destination = "<?= base_url('Admin/Instansi/Update') ?>";} // url update
            $.ajax({url: url_destination,type: "POST",data: $(this).serialize(),dataType: "JSON",
                beforeSend: function() { // function before send data
                    $('#submit-instansi').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-instansi').prop('disabled', true);
                },
                complete: function() { // function run when data has been send and complete
                    $('#submit-instansi').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-instansi').prop('disabled', false);
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
                            html: '<b>Otomatis Ke Table Insatansi!</b><br>' +
                                'Tekan No Jika Ingin Memasukkan Data Yang Lainnya',
                            timer: 3500,timerProgressBar: true,
                            showCancelButton: true,confirmButtonText: 'Ya, Kembali!',
                            cancelButtonText: 'No, cancel!',reverseButtons: true,
                        }).then((result) => {
                            if (result.isConfirmed) {window.location.href = data.redirect;
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if ($('#methodPage').val() === 'New') {location.reload();
                                }else{window.location.replace("<?= base_url('Admin/Instansi/new')?>");}
                            } else if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = data.redirect;
                            }
                        })
                    } else { // error while proccessing the data 
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("kode_", "");
                            var remove = key.replace("nama_", "");
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
            return false;
        })

        function update() { // display single data
            if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {
                var id = $('#hiddenIDPage').val();
                var url_destination = "<?= base_url('Admin/Instansi/single_data') ?>";
                $.ajax({url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},dataType: "JSON",
                    success: function(data) {
                        $('#submit-instansi').removeClass("btn-success");
                        $('#submit-instansi').addClass("btn-warning text-white");
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        $('#kodeForm').val(data.kode);
                        $('#instansiForm').val(data.nama_instansi);
                        $("#provinsiForm").append($("<option selected='selected'></option>")
                        .val(data.provinsi.kode).text(data.provinsi.nama_provinsi)).trigger('change');
                        $("#kabupatenForm").append($("<option selected='selected'></option>")
                        .val(data.kabupaten.kode).text(data.kabupaten.nama_kabupaten)).trigger('change');
                        $("#kecamatanForm").append($("<option selected='selected'></option>")
                        .val(data.kecamatan.kode).text(data.kecamatan.nama_kecamatan)).trigger('change');
                        $('#submit-instansi').html('<i class="fas fa-save"></i>&ensp;Update');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
            }
        }

        $('#generate-kode').click(function() { // generate code
            var url_destination = "<?= base_url('Admin/Instansi/generator') ?>";
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
