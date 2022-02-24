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
                                                <input type="number" name="kodeAddEdit" class="form-control" id="kodeForm" placeholder="Kode Instansi" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" autofocus />
                                                <div class="invalid-feedback kodeError"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama_instansiForm" class="col-sm-3 col-form-label">Nama Instansi</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="zonasiAddEdit" class="form-control" id="nama_instansiForm" placeholder="Masukkan Nama Wilayah">
                                                <div class="invalid-feedback zonasiError"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="provinsiSelect" class="col-sm-3 col-form-label">Provinsi</label>
                                            <div class="col-sm-7">
                                                <select name="provinsiAddEdit" id="provinsiSelect" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari Provinsi ---</option>
                                                </select>
                                                <div class="invalid-feedback id_provinsiError"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kabupatenSelect" class="col-sm-3 col-form-label">Kabupaten/Kota</label>
                                            <div class="col-sm-7">
                                                <select name="kabupatenAddEdit" id="kabupatenSelect" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Cari Kabupaten ---</option>
                                                </select>
                                                <div class="invalid-feedback id_kabupatenError"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kecamatanSelect" class="col-sm-3 col-form-label">Kecamatan</label>
                                            <div class="col-sm-7">
                                                <select name="kecamatanAddEdit" id="kecamatanSelect" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Cari Kecamatan ---</option>
                                                </select>
                                                <div class="invalid-feedback id_kecamatanError"></div>
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

        // preventDefault to stay in modal when keycode 13
        $('form input').keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $('#kodeForm').keydown(function(event) {
            if (event.keyCode == 13) {
                $('#nama_wilayahForm').focus();
            }
        });
        $('#jenis_wilayahForm').keydown(function(event) {
            if (event.keyCode == 13) {
                $('#provinsiSelect').select2('open');
            }
        });
        // Bind an event
        $('#provinsiSelect').on('select2:select', function(e) {
            $('#kabupatenSelect').select2('open');
        });
        $('#kabupatenSelect').on('select2:select', function(e) {
            $('#kecamatanSelect').select2('open');
        });
        $('#kecamatanSelect').on('select2:select', function(e) {
            $('#submit-instansi').focus();
        });

        update();

        function clearform() {
            $('#form-addedit')[0].reset();
            $("#kodeForm").empty();
            $("#kodeForm").removeClass('is-valid');
            $("#kodeForm").removeClass('is-invalid');
            $("#nama_instansiForm").empty();
            $("#nama_instansiForm").removeClass('is-valid');
            $("#nama_instansiForm").removeClass('is-invalid');
            $("#provinsiSelect").empty();
            $("#provinsiSelect").removeClass('is-valid');
            $("#provinsiSelect").removeClass('is-invalid');
            $("#kabupatenSelect").empty();
            $("#kabupatenSelect").removeClass('is-valid');
            $("#kabupatenSelect").removeClass('is-invalid');
            $("#kecamatanSelect").empty();
            $("#kecamatanSelect").removeClass('is-valid');
            $("#kecamatanSelect").removeClass('is-invalid');
        }

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Provinsi/getProvinsi') ?>';
        $("#provinsiSelect").select2({
            theme: 'bootstrap4',
            allowClear: true,
            tags: true,
            placeholder: '--- Cari Provinsi ---',
            ajax: {
                url: url_destination,
                type: "POST",
                dataType: "JSON",
                delay: 250,
                data: function(params) {
                    return {

                        searchTerm: params.term,
                        csrf_token_name: $('input[name=csrf_token_name]').val()
                    };
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return {
                        results: response.data
                    };
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                },
                cache: true
            }
        });

        $("#provinsiSelect").change(function() {
            var provinsiID = $(this).val();
            // Initialize select2
            var url_destination = '<?= base_url('Admin/Instansi/getKabupaten') ?>';
            $("#kabupatenSelect").select2({
                theme: 'bootstrap4',
                allowClear: true,
                tags: true,
                placeholder: '--- Cari Kabupaten ---',
                ajax: {
                    url: url_destination,
                    type: "POST",
                    dataType: "JSON",
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term,
                            provinsi: provinsiID,
                            csrf_token_name: $('input[name=csrf_token_name]').val()
                        };
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);
                        return {
                            results: response.data
                        };
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    },
                    cache: false
                }
            })
        });

        $("#kabupatenSelect").change(function() {
            var kabupatenID = $(this).val();
            // Initialize select2
            var url_destination = '<?= base_url('Admin/Instansi/getKecamatan') ?>';
            $("#kecamatanSelect").select2({
                theme: 'bootstrap4',
                allowClear: true,
                tags: true,
                placeholder: '--- Cari Kecamatan ---',
                ajax: {
                    url: url_destination,
                    type: "POST",
                    dataType: "JSON",
                    delay: 250,
                    data: function(params) {
                        return {
                            searchTerm: params.term,
                            kabupaten: kabupatenID,
                            csrf_token_name: $('input[name=csrf_token_name]').val()
                        };
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);
                        return {
                            results: response.data
                        };
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    },
                    cache: true
                }
            })
        });

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            if ($('#methodPage').val() === 'New') {
                var url_destination = "<?= base_url('Admin/Instansi/Create') ?>";

            } else {
                var url_destination = "<?= base_url('Admin/Instansi/Update') ?>";
            }
            // console.log($(this).serialize());
            $.ajax({
                url: url_destination,
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit-instansi').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");
                    $('#submit-instansi').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-instansi').html("<i class='fa fa-save'></i>&ensp;Submit");
                    $('#submit-instansi').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            var ret = ("#" + key).replace('id_', '');
                            // console.log(ret); //prints: 123
                            var select = $(ret + "Select").addClass('is-invalid');
                            // select.addClass('is-invalid');
                            // console.log(select);
                            $("#" + key).addClass('is-invalid');
                            $("." + key + "Error").html(data.error[key]);
                            var element = $('#' + key + 'Form');
                            // console.log(element);
                            element.closest('.form-control').removeClass('is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                            select.closest('.form-control').removeClass('is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                    } else {
                        if (data.success) {
                            clearform();
                            let timerInterval
                            swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'Berhasil Memasukkan Data',
                                html: '<b>Otomatis Ke Table Wilayah!</b><br>' +
                                    'Tekan No Jika Ingin Memasukkan Data Yang Lainnya',
                                timer: 3500,
                                timerProgressBar: true,
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Kembali!',
                                cancelButtonText: 'No, cancel!',
                                reverseButtons: true,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = data.redirect;
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    location.reload();
                                } else if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.href = data.redirect;
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data.msg,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        })

        function update() {
            if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {

                var id = $('#hiddenIDPage').val();
                var url_destination = "<?= base_url('Admin/Instansi/single_data') ?>";
                $.ajax({
                    url: url_destination,
                    type: "POST",
                    data: {
                        id: id,
                        csrf_token_name: $('input[name=csrf_token_name]').val()
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $('#submit-wilayah').removeClass("btn-success");
                        $('#submit-wilayah').addClass("btn-warning text-white");
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        $('#kodeForm').val(data.kode);
                        $('#nama_instansiForm').val(data.nama_instansi);
                        $("#provinsiSelect").append($("<option selected='selected'></option>").val(data.provinsi.id).text(data.provinsi.nama_provinsi)).trigger('change');
                        $("#kabupatenSelect").append($("<option selected='selected'></option>").val(data.kabupaten.id).text(data.kabupaten.nama_kabupaten)).trigger('change');
                        $("#kecamatanSelect").append($("<option selected='selected'></option>").val(data.kecamatan.id).text(data.kecamatan.nama_kecamatan)).trigger('change');
                        $('#submit-wilayah').html('<i class="fas fa-save"></i>&ensp;Update');
                    }
                })



            }
        }

    })
</script>
<?= $this->endSection() ?>
