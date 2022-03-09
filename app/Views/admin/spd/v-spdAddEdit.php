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
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="kodeForm" class="col-sm-5 col-form-label">No SPD</label>
                                            <p class="pt-2 pl-2">090/</p>
                                            <div class="col-sm-4">
                                                <input type="number" name="kodeAddEditForm" class="form-control" id="kodeForm" placeholder="Nomer SPT" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="3" autofocus />
                                                <div class="invalid-feedback kodeErrorForm"></div>
                                            </div>
                                            <p class="pt-2">/Bid.ML</p>
                                        </div>
                                        <div class="form-group row">
                                            <label for="diperintahForm" class="col-sm-5 col-form-label">Pejabat Yang Memberikan Perintah</label>
                                            <div class="col-sm-7">
                                                <select name="diperintahAddEditForm" id="diperintahForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Pegawai Yang Memberikan Memerintah ---</option>
                                                </select>
                                                <div class="invalid-feedback diperintahErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pegawaiForm" class="col-sm-5 col-form-label">Pegawai Yang Diperintah</label>
                                            <div class="col-sm-7">
                                                <select name="pegawaiAddEditForm[]" id="pegawaiForm" multiple="multiple" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Data Pegawai ---</option>
                                                </select>
                                                <div class="invalid-feedback pegawaiErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="levelForm" class="col-sm-5 col-form-label">Tingkat Biaya Perjalanan Dinas</label>
                                            <div class="col-sm-7">
                                                <select name="levelAddEditForm" id="levelForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Tingkat Biaya ---</option>
                                                    <option value="Admin"> Tingkat A </option>
                                                    <option value="Kepala Bidang"> Tingkat B </option>
                                                    <option value="Bendahara"> Tingkat C </option>
                                                </select>
                                                <div class="invalid-feedback levelErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="untukForm" class="col-sm-5 col-form-label">Maksud Perjalanan Dinas</label>
                                            <div class="col-sm-7">
                                                <textarea name="untukAddEditForm" class="form-control" id="untukForm" rows="3" placeholder="Maksud Perjalanan Dinas" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="30"></textarea>
                                                <!-- <input type="text" name="untukAddEditForm" class="form-control" id="untukForm" placeholder="Untuk"/> -->
                                                <div class="invalid-feedback untukErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="instansiForm" class="col-sm-5 col-form-label">Nama Instansi</label>
                                            <div class="col-sm-7">
                                                <select name="instansiAddEditForm" id="instansiForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Data Instansi ---</option>
                                                </select>
                                                <div class="invalid-feedback instansiErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="startForm" class="col-sm-5 col-form-label">Tanggal Pergi </label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="startAddEditForm" class="form-control" id="startForm" placeholder="Dari Tanggal" />
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback startErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="endForm" class="col-sm-5 col-form-label">Tanggal Kembali </label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="endAddEditForm" class="form-control" id="endForm" placeholder="Sampai Tanggal" />
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback endErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lamaForm" class="col-sm-5 col-form-label">Lama Perjalan</label>
                                            <div class="col-sm-7">
                                                <input type="number" name="lamaAddEditForm" class="form-control" id="lamaForm" placeholder="Lama Perjalanan" readonly />
                                                <div class="invalid-feedback lamaErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="rekeningForm" class="col-sm-5 col-form-label">Kode Rekening</label>
                                            <div class="col-sm-7">
                                                <input type="number" name="rekeningAddEditForm" class="form-control" id="rekeningForm" placeholder="Kode Rekening" />
                                                <div class="invalid-feedback rekeningErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="keteranganForm" class="col-sm-5 col-form-label">Keterangan</label>
                                            <div class="col-sm-7">
                                                <textarea name="keteranganAddEditForm" class="form-control" id="keteranganForm" rows="3" placeholder="Keterangan" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="20"></textarea>
                                                <!-- <input type="text" name="keteranganAddEditForm" class="form-control" id="keteranganForm" placeholder="keterangan"/> -->
                                                <div class="invalid-feedback keteranganErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="levelForm" class="col-sm-5 col-form-label">Jenis Kendaraan</label>
                                            <div class="col-sm-7">
                                                <select name="levelAddEditForm" id="levelForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih jenis Kendaraan ---</option>
                                                    <option value="Bus"> Bus </option>
                                                    <option value="Kapal"> Kapal </option>
                                                    <option value="Kereta Api"> Kereta Api </option>
                                                    <option value="Mobil Dinas"> Mobil Dinas </option>
                                                    <option value="Motor Dinas"> Motor Dinas </option>
                                                    <option value="Pesawat"> Pesawat </option>
                                                </select>
                                                <div class="invalid-feedback levelErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title">I</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="tibadiFormFirst">Tiba Di</label>
                                                    <input type="text" class="form-control" name="tibadiAddEdit" id="tibadiFormFirst" placeholder="Tiba Di">
                                                    <div class="invalid-feedback tibadiErrorFormFirst"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="padaTanggalFormFirst">Pada Tanggal</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="startAddEditForm" class="form-control" id="padaTanggalFormFirst" placeholder="Dari Tanggal" />
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="invalid-feedback padaTanggalErrorFormFirst"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputFile">File input</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" id="exampleInputFile">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Upload</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                                </div>
                                            </div>

                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                            <div class="text-center">
                                                <img class="profile-user-img img-fluid img-circle" src="<?= base_url() ?>/AdminLTE/dist/img/user4-128x128.jpg" alt="User profile picture">
                                            </div>
                                            <h3 class="profile-username text-center">Nina Mcintire</h3>
                                            <p class="text-muted text-center">Software Engineer</p>
                                            <ul class="list-group list-group-unbordered mb-3">
                                                <li class="list-group-item">
                                                    <b>Followers</b> <a class="float-right">1,322</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Following</b> <a class="float-right">543</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Friends</b> <a class="float-right">13,287</a>
                                                </li>
                                            </ul>
                                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                            <div class="text-center">
                                                <img class="profile-user-img img-fluid img-circle" src="<?= base_url() ?>/AdminLTE/dist/img/user4-128x128.jpg" alt="User profile picture">
                                            </div>
                                            <h3 class="profile-username text-center">Nina Mcintire</h3>
                                            <p class="text-muted text-center">Software Engineer</p>
                                            <ul class="list-group list-group-unbordered mb-3">
                                                <li class="list-group-item">
                                                    <b>Followers</b> <a class="float-right">1,322</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Following</b> <a class="float-right">543</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Friends</b> <a class="float-right">13,287</a>
                                                </li>
                                            </ul>
                                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                            <div class="text-center">
                                                <img class="profile-user-img img-fluid img-circle" src="<?= base_url() ?>/AdminLTE/dist/img/user4-128x128.jpg" alt="User profile picture">
                                            </div>
                                            <h3 class="profile-username text-center">Nina Mcintire</h3>
                                            <p class="text-muted text-center">Software Engineer</p>
                                            <ul class="list-group list-group-unbordered mb-3">
                                                <li class="list-group-item">
                                                    <b>Followers</b> <a class="float-right">1,322</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Following</b> <a class="float-right">543</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Friends</b> <a class="float-right">13,287</a>
                                                </li>
                                            </ul>
                                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                </div>

                <!-- /.card-body -->
                <div class="card-footer" style="text-align:center;">
                    <a type="button" href="<?= base_url('') ?>/Admin/Spt" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i>&ensp;Back</a>
                    <button type="submit" id="submit-spt" class="btn btn-success ml-2"><i class="fas fa-save"></i>&ensp;Submit</button>
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
                $('#pegawaiForm').select2('open');
            }
        });
        $('#pegawaiForm').on('select2:select', function(e) {
            $('#dasarForm').focus();
        });
        $('#dasarForm').keydown(function(event) {
            if (event.keyCode == 13) {
                $('#untukForm').focus();
            }
        });
        $('#untukForm').keydown(function(event) {
            if (event.keyCode == 13) {
                $('#instansiForm').select2('open');
            }
        });
        $('#instansiForm').on('select2:select', function(e) {
            $('startForm').focus();
        });
        $('#startForm').keydown(function(event) {
            if (event.keyCode == 13) {
                $('#endForm').focus();
            }
        });
        $('#endForm').keydown(function(event) {
            if (event.keyCode == 13) {
                $('#diperintahForm').select2('open');
            }
        });
        $('#diperintahForm').on('select2:select', function(e) {
            $('#submit-spt').focus();
        });

        // update();

        function clearform() {
            $('#form-addedit')[0].reset();
            $("#kodeForm").empty();
            $("#kodeForm").removeClass('is-valid');
            $("#kodeForm").removeClass('is-invalid');
            $("#pegawaiForm").empty();
            $("#pegawaiForm").removeClass('is-valid');
            $("#pegawaiForm").removeClass('is-invalid');
            $("#dasarForm").empty();
            $("#dasarForm").removeClass('is-valid');
            $("#dasarForm").removeClass('is-invalid');
            $("#untukForm").empty();
            $("#untukForm").removeClass('is-valid');
            $("#untukForm").removeClass('is-invalid');
            $("#instansiForm").empty();
            $("#instansiForm").removeClass('is-valid');
            $("#instansiForm").removeClass('is-invalid');
            $("#alamatForm").empty();
            $("#alamatForm").removeClass('is-valid');
            $("#alamatForm").removeClass('is-invalid');
            $("#startForm").empty();
            $("#startForm").removeClass('is-valid');
            $("#startForm").removeClass('is-invalid');
            $("#endForm").empty();
            $("#endForm").removeClass('is-valid');
            $("#endForm").removeClass('is-invalid');
            $("#lamaForm").empty();
            $("#lamaForm").removeClass('is-valid');
            $("#lamaForm").removeClass('is-invalid');
            $("#diperintahForm").empty();
            $("#diperintahForm").removeClass('is-valid');
            $("#diperintahForm").removeClass('is-invalid');
        }

        $('#startForm').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            minDate: moment(),
            startDate: moment(),
            locale: {
                format: 'DD/MM/YYYY',
                firstDay: 1
            }
        });

        $('#endForm').daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            minDate: moment(),
            startDate: moment().add(7, 'days'),
            locale: {
                format: 'DD/MM/YYYY',
                firstDay: 1
            }
        });

        $('#startForm').on('apply.daterangepicker', function(ev, picker) {
            var new_start = picker.startDate.clone().add(7, 'days');
            $('#end-date').daterangepicker({
                singleDatePicker: true,
                autoApply: true,
                minDate: moment(),
                startDate: new_start,
                locale: {
                    format: 'DD/MM/YYYY',
                    firstDay: 1
                }
            });

        });
        $('#endForm').on('apply.daterangepicker', function(ev, picker) {
            var range = $("#endForm").data('daterangepicker').endDate.format('YYYYMMDD') - $("#startForm").data('daterangepicker').startDate.format('YYYYMMDD');
            $("#lamaForm").val(range);
        });

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Spt/getPegawai') ?>';
        $("#pegawaiForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Data Pegawai ---',
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
                        results: response.data,
                    };
                },
                cache: true
            }
        });

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Spt/getInstansi') ?>';
        $("#instansiForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Data Instansi ---',
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
                        results: response.data,
                    };
                },
                cache: true
            }
        });

        $("#instansiForm").change(function() {
            var instansiKode = $(this).val();
            var url_destination = '<?= base_url('Admin/Spt/getAlamatInstansi') ?>';
            // Initialize select2
            $.ajax({
                url: url_destination,
                type: "POST",
                data: {
                    instansi: instansiKode,
                    csrf_token_name: $('input[name=csrf_token_name]').val()
                },
                dataType: "JSON",
                cache: false,
                async: false,
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#alamatForm').val(data.alamat)
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        });

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Spt/getDiperintah') ?>';
        $("#diperintahForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Data Pegawai Yang Memberikan Perintah ---',
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
                        results: response.data,
                    };
                },
                cache: true
            }
        });

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            if ($('#methodPage').val() === 'New') {
                var url_destination = "<?= base_url('Admin/Spt/Create') ?>";
            } else {
                var url_destination = "<?= base_url('Admin/Spt/Update') ?>";
            }
            // console.log($(this).serialize());
            $.ajax({
                url: url_destination,
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                cache: false,
                beforeSend: function() {
                    $('#submit-spt').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");
                    $('#submit-spt').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-spt').html("<i class='fa fa-save'></i>&ensp;Submit");
                    $('#submit-spt').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'Form').addClass('is-invalid');
                            $("." + key + "ErrorForm").html(data.error[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                            // console.log(element);
                            // console.log(data.error[key].length);
                        });
                    }
                    if (data.success == true) {
                        clearform();
                        let timerInterval
                        swalWithBootstrapButtons.fire({
                            icon: 'success',
                            title: 'Berhasil Memasukkan Data',
                            html: '<b>Otomatis Ke Table SPT!</b><br>' +
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
                                if ($('#methodPage').val() === 'New') {
                                    location.reload();
                                } else {
                                    window.location.replace("<?= base_url('Admin/Spt/new') ?>");
                                }
                            } else if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = data.redirect;
                            }
                        })
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            $("#" + key + 'Form').addClass('is-invalid');
                            $("." + key + "ErrorForm").html(data.msg[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        if (data.msg != "") {
                            toastr.options = {
                                "positionClass": "toast-top-right",
                                "closeButton": true
                            };
                            toastr["warning"](data.error, "Informasi");
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        })

        // function update() {
        //     if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {
        //         $("#startForm").datepicker("destroy");
        //         var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Admin/Spt/single_data') ?>";
        //         $.ajax({
        //             url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
        //             dataType: "JSON",
        //             success: function(data) {
        //                 // console.log(data);
        //                 $('#submit-spt').removeClass("btn-success");
        //                 $('#submit-spt').addClass("btn-warning text-white");
        //                 $('input[name=csrf_token_name]').val(data.csrf_token_name);
        //                 $('#kodeForm').val(data.kode);
        //                 // $('#pegawaiForm').html(data.nama_pegawai);
        //                 // $('#pegawaiForm').multiselect('refresh');
        //                 // // console.log(data.nama_pegawai);
        //                 // // console.log(JSON.parse(data.nama_pegawai))
        //                 // // $.each(JSON.parse(data.nama_pegawai), function(i, val) {
        //                 // //     $('#pegawaiForm').append('<option value="'+i+'">'+val+'</option>').multiselect('refresh');
        //                 // // });
        //                 $('#dasarForm').val(data.dasar);
        //                 $('#untukForm').val(data.untuk);
        //                 $("#instansiForm").append($("<option selected='selected'></option>")
        //                 .val(data.instansi.kode).text(data.instansi.nama_instansi)).trigger('change');
        //                 $("#diperintahForm").append($("<option selected='selected'></option>")
        //                 .val(data.pegawai.nip).text(data.pegawai.nama)).trigger('change');
        //                 $('#alamatForm').val(data.alamat_instansi);
        //                 // $('#startForm' ).datepicker('setDate', '09/03/2022');
        //                 // $('#lahirForm').val(data.tgl_lahir);
        //                 // $('#lahirForm').val(data.tgl_lahir);

        //                 $("#startForm").datepicker({ 
        //                     format: 'yyyy-mm-dd'
        //                 });
        //                 $("#startForm").on("change", function () {
        //                     var fromdate = $(this).val(data.awal);
        //                     alert(fromdate);
        //                 });
        //                 $('#lamaForm').val(data.lama);
        //                 $('#submit-spt').html('<i class="fas fa-save"></i>&ensp;Update');
        //             },error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
        //         })
        //     }
        // }
    })
</script>
<?= $this->endSection() ?>
