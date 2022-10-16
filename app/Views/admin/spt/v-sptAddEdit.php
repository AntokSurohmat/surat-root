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
                                            <label for="kodeForm" class="col-sm-3 col-form-label">No SPT</label>
                                            <p class="pt-2 pl-2">090/</p>
                                            <div class="col-sm-5">
                                                <input type="number" readonly name="kodeAddEditForm" class="form-control" id="kodeForm" placeholder="Nomer SPT" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="3" />
                                                <div class="invalid-feedback kodeErrorForm"></div>
                                            </div>
                                            <p class="pt-2">/Bid.ML</p>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pegawaiForm" class="col-sm-3 col-form-label">Nama Pegawai</label>
                                            <div class="col-sm-7">
                                                <select name="pegawaiAddEditForm[]" id="pegawaiForm" multiple="multiple" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Data Pegawai ---</option>
                                                </select>
                                                <div class="invalid-feedback pegawaiErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="dasarForm" class="col-sm-3 col-form-label">Dasar Perjalanan Dinas</label>
                                            <div class="col-sm-7">
                                                <textarea name="dasarAddEditForm" class="form-control" id="dasarForm" rows="3" placeholder="Dasar Perjalanan Dinas" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="50"></textarea>
                                                <!-- <input type="text" name="dasarAddEditForm" class="form-control" id="dasarForm" placeholder="Dasar"/> -->
                                                <div class="invalid-feedback dasarErrorForm"></div>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <label for="untukForm" class="col-sm-3 col-form-label">Maksud Perjalanan Dinas</label>
                                            <div class="col-sm-7">
                                            <textarea name="untukAddEditForm" class="form-control" id="untukForm" rows="3" placeholder="Maksud Perjalanan Dinas" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="50"></textarea> -->
                                                <!-- <input type="text" name="untukAddEditForm" class="form-control" id="untukForm" placeholder="Untuk"/> -->
                                                <!-- <div class="invalid-feedback untukErrorForm"></div>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <label for="untukForm" class="col-sm-3 col-form-label">Maksud Perjalanan Dinas</label>
                                            <div class="col-sm-7">
                                                <select name="untukAddEditForm" id="untukForm" class="form-control " style="width: 100%;">
                                                    <option value="">--- Maksud Perjalanan Dinas ---</option>
                                                </select>
                                                <div class="invalid-feedback untukErrorForm"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-info" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Tujuan" id="add-tujuan"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="instansiForm" class="col-sm-3 col-form-label">Nama Instansi</label>
                                            <div class="col-sm-7">
                                                <select name="instansiAddEditForm" id="instansiForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Data Instansi ---</option>
                                                </select>
                                                <div class="invalid-feedback instansiErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="alamatForm" class="col-sm-3 col-form-label">Alamat Instansi</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="alamatAddEditForm" class="form-control" id="alamatForm" placeholder="Alamat Instansi" readonly/>
                                                <div class="invalid-feedback alamatErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="startForm" class="col-sm-3 col-form-label">Tanggal Pergi </label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="startAddEditForm" id="startForm" placeholder="Dari Tanggal"/>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback startErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="endForm" class="col-sm-3 col-form-label">Tanggal Kembali </label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="endAddEditForm"  id="endForm" placeholder="Sampai Tanggal"/>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback endErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lamaForm" class="col-sm-3 col-form-label">Lama Perjalan</label>
                                            <div class="col-sm-7">
                                                <!-- <input type="number" name="lamaAddEditForm" class="form-control" id="lamaForm" placeholder="Lama Perjalanan" readonly/>
                                                <div class="invalid-feedback lamaErrorForm"></div> -->
                                                <div class="input-group">
                                                    <input type="number" name="lamaAddEditForm" class="form-control" id="lamaForm" placeholder="Lama Perjalanan" readonly/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Hari</span>
                                                    </div>
                                                    <div class="invalid-feedback lamaErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="diperintahForm" class="col-sm-3 col-form-label">Pejabat Yang Memberikan Perintah</label>
                                            <div class="col-sm-7">
                                                <select name="diperintahAddEditForm" id="diperintahForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Pegawai Yang Memberikan Memerintah ---</option>
                                                </select>
                                                <div class="invalid-feedback diperintahErrorForm"></div>
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

        <!--add Prov-->
        <div id="modal-tujuan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AddEditModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Tujuan Perjalanan Dinas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" role="form" id="form-tujuan" autocomplete="off" onsubmit="return false">
                        <div class="modal-body">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <!-- <input type="hidden" id="method" name="method" value="Prov" /> -->
                            <div class="form-group row">
                                <label for="tujuanModalTujuan" class="col-sm-3 col-form-label">Tujuan Perjalanan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="tujuanAddEditModalTujuan" id="tujuanModalTujuan" placeholder="Tujuan Perjalanan Dinas" />
                                    <div class="invalid-feedback tujuanErrorModalTujuan"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="pelaksanaModalTujuan" class="col-sm-3 col-form-label">Pelaksana</label>
                                <div class="col-sm-8">
                                    <select name="pelaksanaAddEditModalTujuan" id="pelaksanaModalTujuan" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Pilih Pelaksana ---</option>
                                        <option value="Kasi Pelayan"> Kasi Pelayan </option>
                                        <option value="Kasi Pengawasan"> Kasi Pengawasan</option>
                                    </select>
                                    <div class="invalid-feedback pelaksanaErrorForm"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="submit" id="submit-btn-tujuan" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal prov -->

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">

    if ($('#methodPage').val() === "New" && $('#hiddenIDPage').val() == "") { 
        var url_destination = "<?= base_url('Admin/Spt/nomer') ?>";
        // alert("OK");
        $.ajax({
            url: url_destination,type: "POST",data: {csrf_token_name: $('input[name=csrf_token_name]').val()},
            dataType: "JSON",
            success: function(data) {
                $('input[name=csrf_token_name]').val(data.csrf_token_name);$('#kodeForm').val(data.kode);
                $('#kodeForm').val(data.kode);
                // console.log(data);
            }
        })
    }

    // var brg = genfunc($('input[name=csrf_token_name]').val(),'<?= base_url() ?>Admin/Spt/nomer');
    // console.log(brg);
    $(document).ready(function() {

        // preventDefault to stay in modal when keycode 13
        $('form input').keydown(function(event) {if (event.keyCode == 13) {event.preventDefault();return false;}});

        $('#pegawaiForm').select2();
        $('#pegawaiForm').select2('focus');
        $('#pegawaiForm').on('select2:select', function(e) {$('#dasarForm').focus();});
        $('#dasarForm').keydown(function(event){if(event.keyCode == 13){$('#untukForm').select2('open');}});
        $('#untukForm').on('select2:select', function(e) {$('#instansiForm').select2('open');});
        $('#instansiForm').on('select2:select', function(e) {$('startForm').focus();});
        $('#startForm').on('apply.daterangepicker', function(ev) {$('#endForm').focus();});
        $('#endForm').on('apply.daterangepicker', function(ev) {$('#diperintahForm').select2('open');});
        $('#diperintahForm').on('select2:select', function(e) {$('#submit-spt').focus();});

        update();

        function clearform() {
            $('#form-addedit')[0].reset();
            $("#kodeForm").empty();$("#kodeForm").removeClass('is-valid');$("#kodeForm").removeClass('is-invalid');
            $("#pegawaiForm").empty();$("#pegawaiForm").removeClass('is-valid');$("#pegawaiForm").removeClass('is-invalid');
            $("#dasarForm").empty();$("#dasarForm").removeClass('is-valid');$("#dasarForm").removeClass('is-invalid');
            $("#untukForm").empty();$("#untukForm").removeClass('is-valid');$("#untukForm").removeClass('is-invalid');
            $("#instansiForm").empty();$("#instansiForm").removeClass('is-valid');$("#instansiForm").removeClass('is-invalid');
            $("#alamatForm").empty();$("#alamatForm").removeClass('is-valid');$("#alamatForm").removeClass('is-invalid');
            $("#startForm").empty();$("#startForm").removeClass('is-valid');$("#startForm").removeClass('is-invalid');
            $("#endForm").empty();$("#endForm").removeClass('is-valid');$("#endForm").removeClass('is-invalid');
            $("#lamaForm").empty();$("#lamaForm").removeClass('is-valid');$("#lamaForm").removeClass('is-invalid');
            $("#diperintahForm").empty();$("#diperintahForm").removeClass('is-valid');$("#diperintahForm").removeClass('is-invalid');
        }

        $('#add-tujuan').click(function() {
            var option = {backdrop: 'static',keyboard: true};
            $('#modal-tujuan').modal(option);$('#form-tujuan')[0].reset();$('#modal-tujuan').modal('show');
        });
        $('#modal-tujuan').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#tujuanModalTujuan").empty();$("#tujuanModalTujuan").removeClass('is-valid');$("#tujuanModalTujuan").removeClass('is-invalid');
            $("#pelaksanaModalTujuan").removeClass('is-valid');$("#pelaksanaModalTujuan").removeClass('is-invalid');
        });
        $('#modal-tujuan').on('shown.bs.modal', function() {
            $('#tujuanModalTujuan').focus();
            $('#tujuanModalTujuan').keydown(function(event) {if (event.keyCode == 13) {$('#pelaksanaModalTujuan').focus();}});
            $('#pelaksanaModalTujuan').on('select2:select', function(e) {$('#submit-btn-tujuan').focus();});
        });

        $('#startForm').daterangepicker({
            singleDatePicker: true,showDropdowns: true,
            startDate: moment(),locale: {format: 'DD/MM/YYYY'}
        });

        $('#endForm').daterangepicker({
            singleDatePicker: true,showDropdowns: true,
            startDate: moment().add(7, 'days'),locale: {format: 'DD/MM/YYYY'}
        });

        $('#startForm').on('apply.daterangepicker', function(ev, picker) {
            var new_start =  picker.startDate.clone().add(7, 'days');
            $('#end-date').daterangepicker({
                singleDatePicker: true,startDate: new_start,locale: {format: 'DD/MM/YYYY'}
            });

        });

        $('#endForm').on('apply.daterangepicker', function(ev, picker) {
            var range = $("#endForm").data('daterangepicker').endDate.format('YYYYMMDD') - $("#startForm").data('daterangepicker').startDate.format('YYYYMMDD');
            $("#lamaForm").val(range);
        });

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Spt/getPegawai') ?>';
        $("#pegawaiForm").select2({
            theme: 'bootstrap4',maximumSelectionLength: 7,
            placeholder: '--- Cari Data Pegawai ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return {results: response.data,};
                },
                cache: true
            }
        });

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Spt/getInstansi') ?>';
        $("#instansiForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Data Instansi ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return {results: response.data,};
                },
                cache: true
            }
        });

        $("#instansiForm").change(function() {
            var instansiKode = $(this).val();var url_destination = '<?= base_url('Admin/Spt/getAlamatInstansi') ?>';
            // Initialize select2
            $.ajax({url: url_destination, type: "POST", data: {instansi:instansiKode, csrf_token_name: $('input[name=csrf_token_name]').val()}, dataType: "JSON",cache:false,async:false,
                success: function(data){
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
            tags: true,
            placeholder: '--- Cari Data Pegawai Yang Memberikan Perintah ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return {results: response.data,};
                },
                cache: true
            }
        });

        // $("#pegawaiForm").on("select2:select", function (evt) {
        //     // var values = [];
        //     // // var keys = [];
        //     var element =  evt.params.data.text
        //     // values.push(element);
        //     // // $.each(element, function(key, value) {
        //     // //     values.push(value);
        //     // // });
        //     // console.log(values);
        //     var $element = $(element);
            
        //     $element.detach();
        //     $(this).append($element);
        //     $(this).trigger("change");
        // });

        // // jQuery("#pegawaiForm").each(function(){
        // //     $this = jQuery(this);
        // //     if($this.attr('data-reorder')){
        // //         $this.on('select2:select', function(e){
        // //         var elm = e.params.data.element;
        // //         $elm = jQuery(elm);
        // //         $t = jQuery(this);
        // //         $t.append($elm);
        // //         $t.trigger('change.select2');
        // //     });
        // // }
        // //     console.log($this.select2());
        // // });

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Spt/getTujuan') ?>';
        $("#untukForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Maksud Perjalanan ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return {results: response.data,};
                },
                cache: true
            }
        });

        $('#form-tujuan').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Spt/savemodal') ?>";
            $.ajax({
                url: url_destination,method: "POST",data: $(this).serialize(),dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn-tujuan').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-btn-tujuan').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn-tujuan').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-btn-tujuan').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'ModalTujuan').addClass('is-invalid');$("." + key + "ErrorModalTujuan").html(data.error[key]);
                            var element = $('#' + key + 'ModalTujuan');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                    } 
                    if (data.success==true) {
                        $("#modal-tujuan").modal('hide');
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["success"](data.msg, "Informasi");
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("nama_", "");
                            $("#" + remove + 'ModalTujuan').addClass('is-invalid');
                            $("." + remove + "ErrorModalTujuan").html(data.msg[key]);
                            var element = $('#' + remove + 'ModalTujuan');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"](data.msg, "Informasi");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
            });
            return false;
        })

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            if ($('#methodPage').val() === 'New') {var url_destination = "<?= base_url('Admin/Spt/Create') ?>";
            } else {var url_destination = "<?= base_url('Admin/Spt/Update') ?>";}


            console.log($(this).serialize());
            // throw new Error("my error message");
            $.ajax({url: url_destination,type: "POST",data: $(this).serialize(),dataType: "JSON",cache:false,
                beforeSend: function() {
                    $('#submit-spt').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-spt').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-spt').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-spt').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'Form').addClass('is-invalid');$("." + key + "ErrorForm").html(data.error[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                            // console.log(element);
                            // console.log(data.error[key].length);
                        });
                    }
                    if (data.success==true) {
                        clearform();let timerInterval
                        swalWithBootstrapButtons.fire({
                            icon: 'success',title: 'Berhasil Memasukkan Data',
                            html: '<b>Otomatis Ke Table SPT!</b><br>' +
                                'Tekan No Jika Ingin Memasukkan Data Yang Lainnya',
                            timer: 3500,timerProgressBar: true,
                            showCancelButton: true,confirmButtonText: 'Ya, Kembali!',cancelButtonText: 'No, cancel!',reverseButtons: true,
                        }).then((result) => {
                            if (result.isConfirmed) {window.location.href = data.redirect;
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if ($('#methodPage').val() === 'New') {location.reload();
                                }else{window.location.replace("<?= base_url('Admin/Spt/new')?>");}
                            } else if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = data.redirect;
                            }
                        })
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("pejabat", "diperintah");
                            var remove = key.replace("pegawai_all", "pegawai");
                            var remove = key.replace("kode_instansi", "instansi");
                            var remove = key.replace("alamat_instansi", "alamat");
                            var remove = key.replace("kode_", "");
                            $("#" + remove + 'Form').addClass('is-invalid');
                            $("." + remove + "ErrorForm").html(data.msg[key]);
                            var element = $('#' + remove + 'Form');
                            element.closest('.form-control');element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        if (data.msg != "") {
                            toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"](data.error, "Informasi");
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
            });
            return false;
        })

        function update() {
            if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {
                $("#startForm").datepicker("destroy");
                var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Admin/Spt/single_data') ?>";
                $.ajax({
                    url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        // console.log(data.pegawai);
                        $('#submit-spt').removeClass("btn-success");
                        $('#submit-spt').addClass("btn-warning text-white");
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        $('#kodeForm').val(data.kode);
                        data.pegawai.forEach((pegawailoop, index) => {
                            // console.log(pegawailoop);
                            pegawailoop.forEach((dataloop, index) => {
                                console.log(dataloop);

                                $("#pegawaiForm").append($("<option selected='selected'></option>")
                                .val(dataloop.nip).text(dataloop.nama)).trigger('change');
                            })
                        })
                        $('#dasarForm').val(data.dasar);
                        $("#untukForm").append($("<option selected='selected'></option>")
                        .val(data.untuk.id).text(data.untuk.tujuan)).trigger('change');
                        $("#instansiForm").append($("<option selected='selected'></option>")
                        .val(data.instansi.kode).text(data.instansi.nama_instansi)).trigger('change');
                        $("#diperintahForm").append($("<option selected='selected'></option>")
                        .val(data.pejabat.nip).text(data.pejabat.nama)).trigger('change');
                        $('#alamatForm').val(data.alamat_instansi);
                        var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                        var awal = new Date(data.awal);var curr_date = awal.getDate();var curr_month = awal.getMonth();var curr_year = awal.getFullYear();
                        $('#startForm').data('daterangepicker').setStartDate(curr_date + "/" + m_names[curr_month] + "/" + curr_year);
                        $('#startForm').data('daterangepicker').updateView();$('#startForm').data('daterangepicker').updateCalendars();
                        var akhir = new Date(data.akhir);var curr_date = akhir.getDate();var curr_month = akhir.getMonth();var curr_year = akhir.getFullYear();
                        $('#endForm').data('daterangepicker').setStartDate(curr_date + "/" + m_names[curr_month] + "/" + curr_year);
                        $('#endForm').data('daterangepicker').updateView();$('#endForm').data('daterangepicker').updateCalendars();
                        $('#lamaForm').val(data.lama);
                        $('#submit-spt').html('<i class="fas fa-save"></i>&ensp;Update');
                    },error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
            }
        }
    })
</script>
<?= $this->endSection() ?>
