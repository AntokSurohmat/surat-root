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
                        <!-- <a class="btn btn-sm btn-outline-info float-right" tabindex="1" href="#" data-rel="tooltip" data-placement="left" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i> Add Data
                        </a> -->
                    </div>
                    <!-- /.card-header -->
                    <form class="form-horizontal" role="form" id="form-addedit" autocomplete="off" onsubmit="return false">
                        <div class="card-body">
                            <input type="hidden" class="txt_csrfname" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="kode" class="col-sm-3 col-form-label">Kode</label>
                                            <div class="col-sm-7">
                                                <input type="number" name="kode" class="form-control" id="kode" placeholder="Kode Pangkat & Golongan" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" />
                                                <div class="invalid-feedback kodeError"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="provinsiSelect" class="col-sm-3 col-form-label">Provinsi</label>
                                            <div class="col-sm-7">
                                                <select name="provinsi" id="provinsiSelect" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Cari Provinsi ---</option>
                                                </select>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-info" data-rel="tooltip" data-placement="top" title="Tambah Provinsi" id="add-prov"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kabupatenSelect" class="col-sm-3 col-form-label">Kabupaten</label>
                                            <div class="col-sm-7">
                                                <select name="kabupaten" id="kabupatenSelect" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Cari Kabupaten ---</option>
                                                </select>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-primary" data-rel="tooltip" data-placement="top" title="Tambah Kabupaten" id="add-kab"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kecamatanSelect" class="col-sm-3 col-form-label">Kecamatan</label>
                                            <div class="col-sm-7">
                                                <select name="kecamatan" id="kecamatanSelect" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Cari Kecamatan ---</option>
                                                </select>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-success" data-rel="tooltip" data-placement="top" title="Tambah Kecamatan" id="add-kec"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jenis_wilayahForm" class="col-sm-3 col-form-label">Jenis Wilayah</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="jenis_wilayah" class="form-control" id="jenis_wilayahForm" placeholder="Masukkan Jenis Wilayah">
                                                <div class="invalid-feedback nama_pangolError"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="zonasiForm" class="col-sm-3 col-form-label">Zonasi</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="zonasi" class="form-control" id="zonasiForm" placeholder="Masukkan Jenis Wilayah">
                                                <div class="invalid-feedback nama_pangolError"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
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
                            <input type="text" id="method" name="method" value="Prov" />
                            <div class="form-group row">
                                <label for="nama_provForm" class="col-sm-3 col-form-label">Provinsi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_provAdd" id="nama_provForm" placeholder="Nama Provinsi Baru" />
                                    <div class="invalid-feedback nama_provError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="button" id="submit-btn_prov" onclick="saveprov()" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal prov -->

        <!--add Kab-->
        <div id="modal-kab" class="modal fade" tabindex="-1"  role="dialog" aria-labelledby="AddEditModal" aria-hidden="true">
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
                            <input type="text" id="methodKab" name="methodKab" value="Kab"/>
                            <div class="form-group row">
                                <label for="provinsiAddSelect" class="col-sm-3 col-form-label">Provinsi</label>
                                <div class="col-sm-9">
                                    <select name="provinsiAdd" id="provinsiAddSelect" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Provinsi ---</option>
                                    </select>
                                    <div class="invalid-feedback provinsiError"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_kabForm" class="col-sm-3 col-form-label">Kota/Kab.</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_kabAdd" id="nama_kabForm" placeholder="Nama Kabupaten Baru" />
                                    <div class="invalid-feedback nama_kabError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="button" id="submit-btn" onclick="savekab()" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal Kab -->

        <!--add Kec-->
        <div id="modal-kec" class="modal fade" tabindex="-1"  role="dialog" aria-labelledby="AddEditModal" aria-hidden="true">
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
                            <input type="text" id="methodKec" name="methodKec"/>
                            <div class="form-group row">
                                <label for="provinsiAddSelect" class="col-sm-3 col-form-label">Provinsi</label>
                                <div class="col-sm-9">
                                    <select name="provinsiAdd" id="provinsiAddKecSelect" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Provinsi ---</option>
                                    </select>
                                    <div class="invalid-feedback provinsiError"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kabupatenAddSelect" class="col-sm-3 col-form-label">Kabupaten</label>
                                <div class="col-sm-9">
                                    <select name="provinsiAdd" id="kabupatenAddSelect" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Kabupaten ---</option>
                                    </select>
                                    <div class="invalid-feedback provinsiError"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_kecForm" class="col-sm-3 col-form-label">Kec.</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_kabAdd" id="nama_kecForm" placeholder="Nama Kabupaten Baru" />
                                    <div class="invalid-feedback nama_kabError"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="button" id="submit-btn" onclick="savekec()" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
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

        $('#add-prov').click(function() {
            var option = {backdrop: 'static',keyboard: true};
            $('#modal-prov').modal(option);$('#form-prov')[0].reset();$('#modal-prov').modal('show');
        });
        $('#modal-prov').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();$("#nama_provForm").empty();
            $("#nama_provForm").removeClass('is-valid');$("#nama_provForm").removeClass('is-invalid');

        });
        $('#modal-prov').on('shown.bs.modal', function() {$('#nama_provForm').focus();});

        $('#add-kab').click(function() {
            var option = {backdrop: 'static',keyboard: true};
            $('#modal-kab').modal(option);$('#form-kab')[0].reset();$('#modal-kab').modal('show');
        });
        $('#modal-kab').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#provinsiSelect").empty();$("#nama_kabForm").empty();
            $("#provinsiSelect").removeClass('is-valid');$("#nama_kabForm").removeClass('is-valid');
            $("#provinsiSelect").removeClass('is-invalid');$("#nama_kabForm").removeClass('is-invalid');
        });
        $('#modal-prov').on('shown.bs.modal', function() {$('#provinsiAdd').focus();$('#provinsiAdd').keydown(function(event){if(event.keyCode == 13) {$('#nama_kabForm').focus();}});});

        $('#add-kec').click(function() {
            var option = {backdrop: 'static',keyboard: true};
            $('#modal-kec').modal(option);$('#form-kec')[0].reset();$('#modal-kec').modal('show');
        });
        $('#modal-kab').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#provinsiAddKecSelect").empty();$("#kabupatenAddSelect").empty();$("#nama_kecForm").empty();
            $("#provinsiAddKecSelect").removeClass('is-valid');$("#kabupatenAddSelect").removeClass('is-valid');$("#nama_kecForm").removeClass('is-valid');
            $("#provinsiAddKecSelect").removeClass('is-invalid');$("#kabupatenAddSelect").removeClass('is-valid');$("#nama_kecForm").removeClass('is-invalid');
        });
        $('#modal-prov').on('shown.bs.modal', function() {$('#provinsiAdd').focus();$('#provinsiAdd').keydown(function(event){if(event.keyCode == 13) {$('#nama_kabForm').focus();}});});

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Wilayah/getProvinsi') ?>';
        $("#provinsiSelect").select2({
            theme: 'bootstrap4',allowClear: true,
            placeholder: '--- Cari Provinsi ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};},
                processResults: function(response) {$('input[name=csrf_token_name]').val(response.csrf_token_name); return {results: response.data}; },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);},cache: true
            }
        });

        $("#provinsiSelect").change(function() {
            var provinsiID = $(this).val();
            // Initialize select2
            var url_destination = '<?= base_url('Admin/Wilayah/getKabupaten') ?>';
            $("#kabupatenSelect").select2({
                theme: 'bootstrap4',allowClear: true,
                placeholder: '--- Cari Kabupaten ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {return {searchTerm: params.term,provinsi: provinsiID,csrf_token_name: $('input[name=csrf_token_name]').val()};},
                    processResults: function(response) { $('input[name=csrf_token_name]').val(response.csrf_token_name); return {results: response.data};},
                    error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);},cache: false
                }
            })
        });

        $("#kabupatenSelect").change(function() {
            var kabupatenID = $(this).val();
            // Initialize select2
            var url_destination = '<?= base_url('Admin/Wilayah/getKecamatan') ?>';
            $("#kecamatanSelect").select2({
                theme: 'bootstrap4', allowClear: true,
                placeholder: '--- Cari Kecamatan ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {return {searchTerm: params.term,kabupaten: kabupatenID,csrf_token_name: $('input[name=csrf_token_name]').val()};},
                    processResults: function(response) { $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};},
                    error: function(xhr, ajaxOptions, thrownError) { alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);},cache: true
                }
            })
        });

        var url_destination = '<?= base_url('Admin/Wilayah/getProvinsi') ?>';
        $("#provinsiAddSelect").select2({
            dropdownParent: $('#modal-kab'),
            theme: 'bootstrap4',allowClear: true,
            placeholder: '--- Cari Provinsi ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};},
                processResults: function(response) { $('input[name=csrf_token_name]').val(response.csrf_token_name);return { results: response.data};},
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);},cache: true
            }
        });

        var url_destination = '<?= base_url('Admin/Wilayah/getProvinsi') ?>';
        $("#provinsiAddKecSelect").select2({
            dropdownParent: $('#modal-kec'),
            theme: 'bootstrap4',allowClear: true,
            placeholder: '--- Cari Provinsi ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};},
                processResults: function(response) { $('input[name=csrf_token_name]').val(response.csrf_token_name);return { results: response.data};},
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);},cache: true
            }
        });


        $("#provinsiAddKecSelect").change(function() {
            var provinsiID = $(this).val();
            // Initialize select2
            var url_destination = '<?= base_url('Admin/Wilayah/getKabupaten') ?>';
            $("#kabupatenAddSelect").select2({
                theme: 'bootstrap4',allowClear: true,
                placeholder: '--- Cari Kabupaten ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {return {searchTerm: params.term,provinsi: provinsiID,csrf_token_name: $('input[name=csrf_token_name]').val()};},
                    processResults: function(response) { $('input[name=csrf_token_name]').val(response.csrf_token_name); return {results: response.data};},
                    error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);},cache: false
                }
            })
        });
    
    })

    function saveprov(){

        var url_destination = '<?= base_url('Admin/Wilayah/savemodal')?>';
        var method = $('#method').val();
        var nama_provAdd = $('#nama_provForm').val();
        var form = $('#form-prov').serialize();
        // console.log(method);
        // console.log(nama_provForm);
        var form = document.getElementById('form-prov');
		var formData = new FormData(form);
        console.log(formData);


        // $.ajax({url: url_destination,method: "POST",data: form,dataType: "JSON",
        //     beforeSend: function() {
        //             $('#submit-btn-prov').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-btn-prov').prop('disabled', true);
        //     },
        //     complete: function() {
        //             $('#submit-btn-prov').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-btn-prov').prop('disabled', false);
        //     },
        //     success: function(data) {
        //             $('input[name=csrf_token_name]').val(data.csrf_token_name)
        //             // console.log(data.error);
        //             if (data.error) {
        //                 console.log(data);
        //                 Object.keys(data.error).forEach((key, index) => {
        //                     $("#" + key).addClass('is-invalid');
        //                     $("." + key + "Error").html(data.error[key]);
        //                     var element = $('#' + key + 'Form');
        //                     element.closest('.form-control')
        //                         .removeClass('is-invalid')
        //                         .addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
        //                 });
        //             } else {
        //                 if (data.success) {
        //                     $("#modal-prov").modal('hide');
        //                     toastr.options = {"positionClass": "toast-top-right","closeButton": true};
        //                     toastr["success"](data.msg, "Informasi");
        //                 } else {
        //                     // $("#modal-prov").modal('hide');
        //                     toastr.options = {"positionClass": "toast-top-right","closeButton": true};
        //                     toastr["warning"](data.msg, "Informasi");
        //                 }
        //             }
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        //         }
        // });return false;
    }

    function savekab(){

    var url_destination = '<?= base_url('Admin/Wilayah/savemodal')?>';
    var method = $('#methodProv').val();
    var form = $('#form-kab');
    console.log(method);
    console.log(form.serialize());

    // $.ajax({url: url_destination,type: "POST",data: form.serialize(),dataType: "JSON",
    //     beforeSend: function() {
    //             $('#submit-btn-prov').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-btn-prov').prop('disabled', true);
    //     },
    //     complete: function() {
    //             $('#submit-btn-prov').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-btn-prov').prop('disabled', false);
    //     },
    //     success: function(data) {
    //             $('input[name=csrf_token_name]').val(data.csrf_token_name)
    //             // console.log(data.error);
    //             if (data.error) {
    //                 Object.keys(data.error).forEach((key, index) => {
    //                     $("#" + key).addClass('is-invalid');
    //                     $("." + key + "Error").html(data.error[key]);
    //                     var element = $('#' + key + 'Form');
    //                     element.closest('.form-control')
    //                         .removeClass('is-invalid')
    //                         .addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
    //                 });
    //             } else {
    //                 if (data.success) {
    //                     $("#modal-prov").modal('hide');
    //                     toastr.options = {"positionClass": "toast-top-right","closeButton": true};
    //                     toastr["success"](data.msg, "Informasi");
    //                 } else {
    //                     $("#modal-prov").modal('hide');
    //                     toastr.options = {"positionClass": "toast-top-right","closeButton": true};
    //                     toastr["warning"](data.msg, "Informasi");
    //                 }
    //             }
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    //         }
    // })
}
</script>
<?= $this->endSection() ?>
