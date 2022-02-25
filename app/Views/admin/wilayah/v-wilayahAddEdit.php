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
                                                <input type="number" name="kodeAddEdit" class="form-control" id="kodeForm" placeholder="Kode Wilayah" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" autofocus />
                                                <div class="invalid-feedback kodeError"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="provinsiSelect" class="col-sm-3 col-form-label">Provinsi</label>
                                            <div class="col-sm-7">
                                                <select name="provinsiAddEdit" id="provinsiSelect" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari Provinsi ---</option>
                                                </select>
                                                <div class="invalid-feedback id_provinsiError"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-info" data-rel="tooltip" data-placement="top" title="Tambah Provinsi" id="add-prov"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kabupatenSelect" class="col-sm-3 col-form-label">Kabupaten/Kota</label>
                                            <div class="col-sm-7">
                                                <select name="kabupatenAddEdit" id="kabupatenSelect" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Cari Kabupaten ---</option>
                                                </select>
                                                <div class="invalid-feedback id_kabupatenError"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-primary" data-rel="tooltip" data-placement="top" title="Tambah Kabupaten" id="add-kab"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kecamatanSelect" class="col-sm-3 col-form-label">Kecamatan</label>
                                            <div class="col-sm-7">
                                                <select name="kecamatanAddEdit" id="kecamatanSelect" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Cari Kecamatan ---</option>
                                                </select>
                                                <div class="invalid-feedback id_kecamatanError"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-success" data-rel="tooltip" data-placement="top" title="Tambah Kecamatan" id="add-kec"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jenisSelect" class="col-sm-3 col-form-label">Jenis Wilayah</label>
                                            <div class="col-sm-7">
                                                <select name="jenisAddEdit" id="jenisSelect" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Jenis Wilayah ---</option>
                                                </select>
                                                <!-- <input type="text" name="jenis_wilayahAddEdit" class="form-control" id="jenis_wilayahForm" placeholder="Masukkan Jenis Wilayah"> -->
                                                <div class="invalid-feedback jenis_wilayahError"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-danger" data-rel="tooltip" data-placement="top" title="Tambah Jenis Wilayah" id="add-jenis"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="zonasiSelect" class="col-sm-3 col-form-label">Zonasi</label>
                                            <div class="col-sm-7">
                                                <!-- <input type="text" name="zonasiAddEdit" class="form-control" id="zonasiForm" placeholder="Masukkan Zonasi"> -->
                                                <select name="zonasiAddEdit" id="zonasiSelect" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Cari Zonasi ---</option>
                                                </select>
                                                <div class="invalid-feedback zonasiError"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-warning" data-rel="tooltip" data-placement="top" title="Tambah Zonasi" id="add-zonasi"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer" style="text-align:center;">
                            <a type="button" href="<?= base_url('') ?>/Admin/Wilayah" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i>&ensp;Back</a>
                            <button type="submit" id="submit-wilayah" class="btn btn-success ml-2"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->

            </div>
        </div>

        <!--add Prov-->
        <div id="modal-prov" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AddEditModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Provinsi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" role="form" id="form-prov" autocomplete="off" onsubmit="return false">
                        <div class="modal-body">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <input type="hidden" id="method" name="method" value="Prov" />
                            <div class="form-group row">
                                <label for="nama_provinsiForm" class="col-sm-3 col-form-label">Provinsi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_provinsiAddEdit" id="nama_provinsiForm" placeholder="Nama Provinsi Baru" />
                                    <div class="invalid-feedback nama_provinsiError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="submit" id="submit-btn-prov" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal prov -->

        <!--add Kab-->
        <div id="modal-kab" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AddEditModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kota/Kab </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" role="form" id="form-kab" autocomplete="off" onsubmit="return false">
                        <div class="modal-body">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <input type="hidden" id="method" name="method" value="Kab" />
                            <div class="form-group row">
                                <label for="id_provinsiForm" class="col-sm-3 col-form-label">Provinsi</label>
                                <div class="col-sm-9">
                                    <select name="id_provinsiAddEdit" id="id_provinsiForm" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Provinsi ---</option>
                                    </select>
                                    <div class="invalid-feedback id_provinsiError"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_kabupatenForm" class="col-sm-3 col-form-label">Kota/Kab.</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_kabupatenAddEdit" id="nama_kabupatenForm" placeholder="Nama Kabupaten Baru" />
                                    <div class="invalid-feedback nama_kabupatenError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="submit" id="submit-btn-kab" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal Kab -->

        <!--add Kec-->
        <div id="modal-kec" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AddEditModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kecamatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" role="form" id="form-kec" autocomplete="off" onsubmit="return false">
                        <div class="modal-body">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <input type="hidden" id="method" name="method" value="Kec" />
                            <div class="form-group row">
                                <label for="provinsiKecamatanSelect" class="col-sm-3 col-form-label">Provinsi</label>
                                <div class="col-sm-9">
                                    <select name="provinsiAdd" id="provinsiKecamatanSelect" class="form-control select2bs4" style="width: 100%;">
                                        <!-- <option value="">--- Cari Provinsi ---</option> -->
                                    </select>
                                    <div class="invalid-feedback provinsiAddError"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_kabupatenForm" class="col-sm-3 col-form-label">Kabupaten</label>
                                <div class="col-sm-9">
                                    <select name="id_kabupatenAddEdit" id="id_kabupatenForm" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Kabupaten ---</option>
                                    </select>
                                    <div class="invalid-feedback id_kabupatenError"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_kecamatanForm" class="col-sm-3 col-form-label">Kec.</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_kecamatanAddEdit" id="nama_kecamatanForm" placeholder="Nama Kecamatan Baru" />
                                    <div class="invalid-feedback nama_kecamatanError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="submit" id="submit-btn-kec" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal Kec -->

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
            $('#jenis_wilayahForm').focus();
        });
        $('#jenis_wilayahForm').keydown(function(event) {
            if (event.keyCode == 13) {
                $('#zonasiForm').focus();
            }
        });
        $('#zonasiForm').keydown(function(event) {
            if (event.keyCode == 13) {
                $('#submit-wilayah').focus();
            }
        });
        update();

        function clearform() {
            $('#form-addedit')[0].reset();
            $("#kodeForm").empty();
            $("#kodeForm").removeClass('is-valid');
            $("#kodeForm").removeClass('is-invalid');
            $("#provinsiSelect").empty();
            $("#provinsiSelect").removeClass('is-valid');
            $("#provinsiSelect").removeClass('is-invalid');
            $("#kabupatenSelect").empty();
            $("#kabupatenSelect").removeClass('is-valid');
            $("#kabupatenSelect").removeClass('is-invalid');
            $("#kecamatanSelect").empty();
            $("#kecamatanSelect").removeClass('is-valid');
            $("#kecamatanSelect").removeClass('is-invalid');
            $("#jenis_wilayahForm").empty();
            $("#jenis_wilayahForm").removeClass('is-valid');
            $("#jenis_wilayahForm").removeClass('is-invalid');
            $("#zonasiForm").empty();
            $("#zonasiForm").removeClass('is-valid');
            $("#zonasiForm").removeClass('is-invalid');
        }

        $('#add-prov').click(function() {
            var option = {
                backdrop: 'static',
                keyboard: true
            };
            $('#modal-prov').modal(option);
            $('#form-prov')[0].reset();
            $('#modal-prov').modal('show');
        });
        $('#modal-prov').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#nama_provinsiForm").empty();
            $("#nama_provinsiForm").removeClass('is-valid');
            $("#nama_provinsiForm").removeClass('is-invalid');

        });
        $('#modal-prov').on('shown.bs.modal', function() {
            $('#nama_provinsiForm').focus();
            $('#nama_provinsiForm').keydown(function(event) {
                if (event.keyCode == 13) {
                    $('#submit-btn-prov').focus();
                }
            });
        });

        $('#add-kab').click(function() {
            var option = {
                backdrop: 'static',
                keyboard: true
            };
            $('#modal-kab').modal(option);
            $('#form-kab')[0].reset();
            $('#modal-kab').modal('show');
        });
        $('#modal-kab').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#id_provinsiForm").empty();
            $("#nama_kabupatenForm").empty();
            $("#id_provinsiForm").removeClass('is-valid');
            $("#nama_kabupatenForm").removeClass('is-valid');
            $("#id_provinsiForm").removeClass('is-invalid');
            $("#nama_kabupatenForm").removeClass('is-invalid');
        });
        $('#modal-kab').on('shown.bs.modal', function() {
            $('#id_provinsiForm').select2('open');
            $('#id_provinsiForm').on('select2:select', function(e) {
                $('#nama_kabupatenForm').focus();
            });
            $('#nama_kabupatenForm').keydown(function(event) {
                if (event.keyCode == 13) {
                    $('#submit-btn-kab').focus();
                }
            });

        });

        $('#add-kec').click(function() {
            var option = {
                backdrop: 'static',
                keyboard: true
            };
            $('#modal-kec').modal(option);
            $('#form-kec')[0].reset();
            $('#modal-kec').modal('show');
        });
        $('#modal-kec').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#provinsiAddKecSelect").empty();
            $("#kabupatenAddSelect").empty();
            $("#nama_kecForm").empty();
            $("#provinsiAddKecSelect").removeClass('is-valid');
            $("#kabupatenAddSelect").removeClass('is-valid');
            $("#nama_kecForm").removeClass('is-valid');
            $("#provinsiAddKecSelect").removeClass('is-invalid');
            $("#kabupatenAddSelect").removeClass('is-valid');
            $("#nama_kecForm").removeClass('is-invalid');
        });
        $('#modal-kec').on('shown.bs.modal', function() {
            $('#provinsiKecamatanSelect').select2('open');
            $('#provinsiKecamatanSelect').on('select2:select', function(e) {
                $('#id_kabupatenForm').select2('open');
            });
            $('#id_kabupatenForm').on('select2:select', function(e) {
                $('#nama_kecatanForm').focus();
            });
            $('#nama_kecatanForm').keydown(function(event) {
                if (event.keyCode == 13) {
                    $('#submit-btn-kec').focus();
                }
            });
        });

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Wilayah/getProvinsi') ?>';
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
                    console.log(data.count);
                    return {
                        results: response.data,
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
            var url_destination = '<?= base_url('Admin/Wilayah/getKabupaten') ?>';
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
            var url_destination = '<?= base_url('Admin/Wilayah/getKecamatan') ?>';
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

        var url_destination = '<?= base_url('Admin/Wilayah/getProvinsi') ?>';
        $("#id_provinsiForm").select2({
            dropdownParent: $('#modal-kab'),
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

        var url_destination = '<?= base_url('Admin/Wilayah/getProvinsi') ?>';
        $("#provinsiKecamatanSelect").select2({
            dropdownParent: $('#modal-kec'),
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

        $("#provinsiKecamatanSelect").change(function() {
            var provinsiID = $(this).val();
            // Initialize select2
            var url_destination = '<?= base_url('Admin/Wilayah/getKabupaten') ?>';
            $("#id_kabupatenForm").select2({
                dropdownParent: $('#modal-kec'),
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

        $('#form-prov').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Wilayah/savemodal') ?>";
            $.ajax({
                url: url_destination,
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn-prov').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");
                    $('#submit-btn-prov').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn-prov').html("<i class='fa fa-save'></i>&ensp;Submit");
                    $('#submit-btn-prov').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    // console.log(data.error);
                    if (data.error) {
                        // console.log(data);
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key).addClass('is-invalid');
                            $("." + key + "Error").html(data.error[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control')
                                .removeClass('is-invalid')
                                .addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                            // console.log(element);
                        });
                    } else {
                        if (data.success) {
                            $("#modal-prov").modal('hide');
                            toastr.options = {
                                "positionClass": "toast-top-right",
                                "closeButton": true
                            };
                            toastr["success"](data.msg, "Informasi");
                        } else {
                            $("#modal-prov").modal('hide');
                            toastr.options = {
                                "positionClass": "toast-top-right",
                                "closeButton": true
                            };
                            toastr["warning"](data.msg, "Informasi");
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        })

        $('#form-kab').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Wilayah/savemodal') ?>";
            $.ajax({
                url: url_destination,
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn-kab').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");
                    $('#submit-btn-kab').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn-kab').html("<i class='fa fa-save'></i>&ensp;Submit");
                    $('#submit-btn-kab').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    // console.log(data.error);
                    if (data.error) {
                        // console.log(data);
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key).addClass('is-invalid');
                            $("." + key + "Error").html(data.error[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control')
                                .removeClass('is-invalid')
                                .addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                            // console.log(element);
                        });
                    } else {
                        if (data.success) {
                            $("#modal-kab").modal('hide');
                            toastr.options = {
                                "positionClass": "toast-top-right",
                                "closeButton": true
                            };
                            toastr["success"](data.msg, "Informasi");
                        } else {
                            $("#modal-kab").modal('hide');
                            toastr.options = {
                                "positionClass": "toast-top-right",
                                "closeButton": true
                            };
                            toastr["warning"](data.msg, "Informasi");
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        })

        $('#form-kec').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Wilayah/savemodal') ?>";
            $.ajax({
                url: url_destination,
                method: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn-kec').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");
                    $('#submit-btn-kec').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn-kec').html("<i class='fa fa-save'></i>&ensp;Submit");
                    $('#submit-btn-kec').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    // console.log(data.error);
                    if (data.error) {
                        // console.log(data);
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key).addClass('is-invalid');
                            $("." + key + "Error").html(data.error[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control')
                                .removeClass('is-invalid')
                                .addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                            // console.log(element);
                        });
                    } else {
                        if (data.success) {
                            $("#modal-kec").modal('hide');
                            toastr.options = {
                                "positionClass": "toast-top-right",
                                "closeButton": true
                            };
                            toastr["success"](data.msg, "Informasi");
                        } else {
                            $("#modal-kec").modal('hide');
                            toastr.options = {
                                "positionClass": "toast-top-right",
                                "closeButton": true
                            };
                            toastr["warning"](data.msg, "Informasi");
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        })

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            if ($('#methodPage').val() === 'New') {
                var url_destination = "<?= base_url('Admin/Wilayah/Create') ?>";

            } else {
                var url_destination = "<?= base_url('Admin/Wilayah/Update') ?>";
            }
            // console.log($(this).serialize());
            $.ajax({
                url: url_destination,
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit-wilayah').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");
                    $('#submit-wilayah').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-wilayah').html("<i class='fa fa-save'></i>&ensp;Submit");
                    $('#submit-wilayah').prop('disabled', false);
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
                var url_destination = "<?= base_url('Admin/Wilayah/single_data') ?>";
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
                        $("#provinsiSelect").append($("<option selected='selected'></option>").val(data.provinsi.id).text(data.provinsi.nama_provinsi)).trigger('change');
                        $("#kabupatenSelect").append($("<option selected='selected'></option>").val(data.kabupaten.id).text(data.kabupaten.nama_kabupaten)).trigger('change');
                        $("#kecamatanSelect").append($("<option selected='selected'></option>").val(data.kecamatan.id).text(data.kecamatan.nama_kecamatan)).trigger('change');
                        $('#jenis_wilayahForm').val(data.jenis_wilayah);
                        $('#zonasiForm').val(data.zonasi);
                        $('#submit-wilayah').html('<i class="fas fa-save"></i>&ensp;Update');
                    }
                })



            }
        }

    })
</script>
<?= $this->endSection() ?>
