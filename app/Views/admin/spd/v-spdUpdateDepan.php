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

        <form class="form-horizontal" role="form" id="form-addedit" autocomplete="off" onsubmit="return false">
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
                        <div class="card-body">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <input type="hidden" id="methodPage" value="<?= $method ?>" />
                            <input type="hidden" name="hiddenID" id="hiddenIDPage" value="<?= $hiddenID ?>" />

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="kodeForm" class="col-sm-3 col-form-label">No SPD</label>
                                            <div class="col-sm-7">
                                                <input type="number" name="kodeAddEditForm" class="form-control" id="kodeForm" placeholder="Nomer SPD" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="3" autofocus />
                                                <div class="invalid-feedback kodeErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="diperintahForm" class="col-sm-3 col-form-label">Pejabat Yang Memberikan Perintah</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="diperintahAddEditForm" class="form-control" id="diperintahForm" placeholder="Pejabat Yang Memberikan Perintah" readonly />
                                                <div class="invalid-feedback diperintahErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pegawaiForm" class="col-sm-3 col-form-label">Pegawai Yang Diperintah</label>
                                            <div class="col-sm-7">
                                                <select name="namaPegawaiAddEditForm" id="pegawaiForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Data Pegawai ---</option>
                                                </select>
                                                <div class="invalid-feedback pegawaiErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tingkatBiayaForm" class="col-sm-3 col-form-label">Tingkat Biaya Perjalanan Dinas</label>
                                            <div class="col-sm-7">
                                                <select name="tingkatBiayaAddEditForm" id="tingkatBiayaForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Tingkat Biaya ---</option>
                                                    <option value="Tingkat A"> Tingkat A </option>
                                                    <option value="Tingkat B"> Tingkat B </option>
                                                    <option value="Tingkat C"> Tingkat C </option>
                                                </select>
                                                <div class="invalid-feedback tingkatBiayaErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="untukForm" class="col-sm-3 col-form-label">Maksud Perjalanan Dinas</label>
                                            <div class="col-sm-7">
                                                <textarea name="untukAddEditForm" class="form-control" id="untukForm" rows="3" placeholder="Maksud Perjalanan Dinas" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="30" readonly></textarea>
                                                <div class="invalid-feedback untukErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="instansiForm" class="col-sm-3 col-form-label">Nama Instansi</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="instansiAddEditForm" class="form-control" id="instansiForm" placeholder="Nama Instansi" readonly />
                                                <div class="invalid-feedback instansiErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="startForm" class="col-sm-3 col-form-label">Tanggal Pergi </label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="startAddEditForm" id="startForm" placeholder="Dari Tanggal" readonly/>
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
                                                    <input type="text" class="form-control" name="endAddEditForm" id="endForm" placeholder="Sampai Tanggal" readonly/>
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
                                                <input type="number" name="lamaAddEditForm" class="form-control" id="lamaForm" placeholder="Lama Perjalanan" readonly />
                                                <div class="invalid-feedback lamaErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="rekeningForm" class="col-sm-3 col-form-label">Kode Rekening</label>
                                            <div class="col-sm-7">
                                                <input type="number" name="rekeningAddEditForm" class="form-control" id="rekeningForm" placeholder="Kode Rekening" readonly/>
                                                <div class="invalid-feedback rekeningErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="keteranganForm" class="col-sm-3 col-form-label">Keterangan</label>
                                            <div class="col-sm-7">
                                                <textarea name="keteranganAddEditForm" class="form-control" id="keteranganForm" rows="3" placeholder="Keterangan" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="20"></textarea>
                                                <!-- <input type="text" name="keteranganAddEditForm" class="form-control" id="keteranganForm" placeholder="keterangan"/> -->
                                                <div class="invalid-feedback keteranganErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kendaraanForm" class="col-sm-3 col-form-label">Jenis Kendaraan</label>
                                            <div class="col-sm-7">
                                                <select name="kendaraanAddEditForm" id="kendaraanForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih jenis Kendaraan ---</option>
                                                    <option value="Bus"> Bus </option>
                                                    <option value="Kapal"> Kapal </option>
                                                    <option value="Kereta Api"> Kereta Api </option>
                                                    <option value="Mobil Dinas"> Mobil Dinas </option>
                                                    <option value="Motor Dinas"> Motor Dinas </option>
                                                    <option value="Pesawat"> Pesawat </option>
                                                </select>
                                                <div class="invalid-feedback kendaraanErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>


                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->
                </div>

               <div class="col-12">
                <div class="card-footer" style="text-align:center;">
                        <a type="button" href="<?= base_url('') ?>/Admin/Spd" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i>&ensp;Back</a>
                        <button type="submit" id="submit-spd" class="btn btn-success ml-2"><i class="fas fa-save"></i>&ensp;Submit</button>
                    </div>
                </div>
            </div>
        </form>

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {

        // preventDefault to stay in modal when keycode 13
        $('form input').keydown(function(event) {if (event.keyCode == 13) {event.preventDefault();return false;}});

        $('#kodeForm').keydown(function(event) {if (event.keyCode == 13) {$('#pegawaiForm').select2('open');}});
        $('#pegawaiForm').on('select2:select', function(e) {$('#tingkatBiayaForm').select2('open');});
        $('#tingkatBiayaForm').on('select2:select', function(e) {$('#keteranganForm').focus();});
        $('#keteranganForm').keydown(function(event) {if (event.keyCode == 13) {$('#kendaraanForm').select2('open');}});
        $('#kendaraanForm').on('select2:select', function(e) {$('#submit-spd').focus();});
        
        realupdate();

        function clearform() {
            $('#form-addedit')[0].reset();
            $("#kodeForm").empty();$("#kodeForm").removeClass('is-valid');$("#kodeForm").removeClass('is-invalid');
            $("#diperintahForm").empty();$("#diperintahForm").removeClass('is-valid');$("#diperintahForm").removeClass('is-invalid');
            $("#pegawaiForm").empty();$("#pegawaiForm").removeClass('is-valid');$("#pegawaiForm").removeClass('is-invalid');
            $("#tingkatBiayaForm").empty();$("#tingkatBiayaForm").removeClass('is-valid');$("#tingkatBiayaForm").removeClass('is-invalid');
            $("#untukForm").empty();$("#untukForm").removeClass('is-valid');$("#untukForm").removeClass('is-invalid');
            $("#instansiForm").empty();$("#instansiForm").removeClass('is-valid');$("#instansiForm").removeClass('is-invalid');
            $("#startForm").empty();$("#startForm").removeClass('is-valid');$("#startForm").removeClass('is-invalid');
            $("#endForm").empty();$("#endForm").removeClass('is-valid');$("#endForm").removeClass('is-invalid');
            $("#lamaForm").empty();$("#lamaForm").removeClass('is-valid');$("#lamaForm").removeClass('is-invalid');
            $("#rekeningForm").empty();$("#rekeningForm").removeClass('is-valid');$("#rekeningForm").removeClass('is-invalid');
            $("#keteranganForm").empty();$("#keteranganForm").removeClass('is-valid');$("#keteranganForm").removeClass('is-invalid');
            $("#kendaraanForm").empty();$("#kendaraanForm").removeClass('is-valid');$("#kendaraanForm").removeClass('is-invalid');
        }

        $("#tingkatBiayaForm").select2({theme: 'bootstrap4'});$("#kendaraanForm").select2({theme: 'bootstrap4'});


        // Initialize select2
        var url_destination = '<?= base_url('Admin/Spd/getPegawai') ?>';
        var id = $('#hiddenIDPage').val();
        $("#pegawaiForm").select2({
            minimumResultsForSearch: Infinity,
            theme: 'bootstrap4',
            placeholder: '--- Cari Data Pegawai ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {return {searchTerm: params.term, id:id, csrf_token_name: $('input[name=csrf_token_name]').val()}},
                processResults: function(response) {$('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data,}},
                cache: true
            }
        });

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Spd/update_depan') ?>";

            $.ajax({url: url_destination,type: "POST",dataType: "JSON",cache: false,data: $(this).serialize(),
                beforeSend: function() {
                    $('#submit-spd').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-spd').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-spd').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-spd').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'Form').addClass('is-invalid');$("." + key + "ErrorForm").html(data.error[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control');element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                    }
                    if (data.success == true) {
                        clearform();
                        let timerInterval
                        swalWithBootstrapButtons.fire({
                            icon: 'success',title: 'Berhasil Memasukkan Data',
                            html: 'Otomatis Kembali Ke Table SPD!',
                            showConfirmButton: false,
                            timer: 3500,timerProgressBar: true,
                        }).then((result) => {
                                window.location.href = data.redirect;
                        })
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("pejabat", "diperintah");
                            var remove = key.replace("pegawai_all", "pegawai");
                            var remove = key.replace("tingkat_biaya", "tingkatBiaya");
                            var remove = key.replace("awal", "start");
                            var remove = key.replace("akhir", "end");
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


        function realupdate() {
            if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {
                var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Admin/Spd/real_update') ?>";
                $.ajax({
                    url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        $('#submit-spd').removeClass("btn-success");
                        $('#submit-spd').addClass("btn-warning text-white");
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        $('#kodeForm').val(data.kode);
                        $("#diperintahForm").val(data.diperintah.nama);
                        $("#pegawaiForm").append($("<option selected='selected'></option>")
                        .val(data.pegawai.nip).text(data.pegawai.nama)).trigger('change');
                        $("#tingkatBiayaForm").append($("<option selected='selected'></option>")
                        .val(data.tingkat_biaya).text(data.tingkat_biaya)).trigger('change');
                        $("#kendaraanForm").append($("<option selected='selected'></option>")
                        .val(data.jenis_kendaraan).text(data.jenis_kendaraan)).trigger('change');
                        $('#untukForm').val(data.untuk);
                        $("#instansiForm").val(data.instansi.nama_instansi);
                        $('#alamatForm').val(data.alamat_instansi);
                        var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                        var m_awal = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
                        var awal = new Date(data.awal);var awal_curr_date = awal.getDate();var awal_curr_month = awal.getMonth();var awal_curr_year = awal.getFullYear();
                        $('#startForm').val(m_awal[awal_curr_date] + "/" + m_names[awal_curr_month] + "/" + awal_curr_year);
                        var akhir = new Date(data.akhir);var akhir_curr_date = akhir.getDate();var akhir_curr_month = akhir.getMonth();var akhir_curr_year = akhir.getFullYear();
                        $('#endForm').val(m_awal[akhir_curr_date] + "/" + m_names[akhir_curr_month] + "/" + akhir_curr_year);
                        $('#lamaForm').val(data.lama);
                        $('#keteranganForm').val(data.keterangan);
                        $('#rekeningForm').val(data.rekening.nomer_rekening);

                        $('#submit-spd').html('<i class="fas fa-save"></i>&ensp;Update');
                    },error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
            }
        }
    })
</script>
<?= $this->endSection() ?>
