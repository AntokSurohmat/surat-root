<?= $this->extend('bendahara/layouts/default') ?>

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
                                            <label for="noSpdKuitansiForm" class="col-sm-3 col-form-label" style="text-align: right;">No SPD </label>
                                            <div class="col-sm-7">
                                                <select name="noSpdAddEditForm" id="noSpdKuitansiForm" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari No SPD ---</option>
                                                </select>
                                                <div class="invalid-feedback noSpdErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="namaPegawaiKuitansiForm" class="col-sm-3 col-form-label" style="text-align: right;">Nama Pegawai</label>
                                            <div class="col-sm-7">
                                                <select name="namaPegawaiAddEditForm" id="namaPegawaiKuitansiForm" class="form-control " style="width: 100%;">
                                                    <option value="">--- Pilih Nama Pegawai ---</option>
                                                </select>
                                                <div class="invalid-feedback namaPegawaiErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <br>
                                 <br>
                                 <br>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="nipKuitansiForm">NIP</label>
                                            <input type="text" class="form-control" name="nipAddEditForm" id="nipKuitansiForm" placeholder="NIP Pegawai" readonly>
                                            <div class="invalid-feedback nipKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="namaKuitansiForm">Nama Pegawai</label>
                                            <input type="text" class="form-control" name="namaAddEditForm" id="namaKuitansiForm" placeholder="Nama Pegawai" readonly>
                                            <div class="invalid-feedback namaKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pangkatKuitansiForm">Pangkat</label>
                                            <input type="text" class="form-control" name="pangkatAddEditForm" id="pangkatKuitansiForm" placeholder="Pangkat" readonly>
                                            <div class="invalid-feedback pangkatKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jabatanKuitansiForm">Jabatan</label>
                                            <input type="text" class="form-control" name="jabatanAddEditForm" id="jabatanKuitansiForm" placeholder="Jabatan" readonly>
                                            <div class="invalid-feedback jabatanKuitansiErrorForm"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="tglBerangkatKuitansiForm">Tanggal Berangkat</label>
                                            <input type="text" class="form-control" name="tglBerangkatAddEditForm" id="tglBerangkatKuitansiForm" placeholder="Tanggal Berangkat" readonly>
                                            <div class="invalid-feedback tglBerangkatKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tglKembaliKuitansiForm">Tanggal Kembali</label>
                                            <input type="text" class="form-control" name="tglKembaliAddEditForm" id="tglKembaliKuitansiForm" placeholder="Tanggal Kembali" readonly>
                                            <div class="invalid-feedback tglKembaliKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lamaKuitansiForm">Lama Perjalanan</label>
                                            <div class="input-group">
                                            <input type="text" class="form-control" name="lamaAddEditForm" id="lamaKuitansiForm" placeholder="Perjalanan" readonly>
                                                <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend">Hari</span>
                                                </div>
                                                <div class="invalid-feedback lamaKuitansiErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="rekeningKuitansiForm">Kode Rekening</label>
                                            <input type="text" class="form-control" name="rekeningAddEditForm" id="rekeningKuitansiForm" placeholder="Kode Rekening" readonly>
                                            <div class="invalid-feedback rekeningKuitansiErrorForm"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="instansiKuitansiForm">Nama Instansi</label>
                                            <input type="text" class="form-control" name="instansiAddEditForm" id="instansiKuitansiForm" placeholder="Nama Instansi" readonly>
                                            <div class="invalid-feedback instansiKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="untukKuitansiForm" class="col-form-label">Maksud Perjalanan Dinas</label>
                                            <textarea name="untukAddEditForm" class="form-control" id="untukKuitansiForm" rows="3" placeholder="Maksud Perjalanan Dinas" readonly></textarea>
                                            <div class="invalid-feedback untukKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pejabatKuitansiForm" class="col-form-label">Pejabat Pelaksana Teknis</label>
                                            <select name="pejabatKuitansiAddEditForm" id="pejabatKuitansiForm" class="form-control " style="width: 100%;">
                                                <option value="">--- Pilih Nama Pegawai ---</option>
                                            </select>
                                            <div class="invalid-feedback pejabatKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jumlahKuitansiForm">Jumlah</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                                </div>
                                                <input type="text" class="form-control" name="jumlahAddEditForm" id="jumlahKuitansiForm" placeholder="Nama jumlah" readonly>
                                                <div class="invalid-feedback jumlahKuitansiErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer" style="text-align:center;">
                            <a type="button" href="<?= base_url('') ?>/Bendahara/Kuitansi" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i>&ensp;Back</a>
                            <button type="submit" id="submit-kuitansi" class="btn btn-success ml-2"><i class="fas fa-save"></i>&ensp;Submit</button>
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
        $('form input').keydown(function(event) {if (event.keyCode == 13) {event.preventDefault();return false;}});

        $('#noSpdKuitansiForm').keydown(function(event){if(event.keyCode == 13){$('#namaPegawaiKuitansiForm').select2('open');}});
        // $('#namaPegawaiKuitansiForm').on('select2:select', function(e) {$('#pejabatKuitansiForm').select2('open');});
        $('#pejabatKuitansiForm').on('select2:select', function(e) {$('#submit-kuitansi').focus();});

        update();

        function clearform() {
            $('#form-addedit')[0].reset();
            $("#noSpdKuitansiForm").empty();$("#noSpdKuitansiForm").removeClass('is-valid');$("#noSpdKuitansiForm").removeClass('is-invalid');
            $("#namaPegawaiKuitansiForm").empty();$("#namaPegawaiKuitansiForm").removeClass('is-valid');$("#namaPegawaiKuitansiForm").removeClass('is-invalid');
            $("#nipKuitansiForm").empty();$("#nipKuitansiForm").removeClass('is-valid');$("#nipKuitansiForm").removeClass('is-invalid');
            $("#namaKuitansiForm").empty();$("#namaKuitansiForm").removeClass('is-valid');$("#namaKuitansiForm").removeClass('is-invalid');
            $("#pangkatKuitansiForm").empty();$("#pangkatKuitansiForm").removeClass('is-valid');$("#pangkatKuitansiForm").removeClass('is-invalid');
            $("#jabatanKuitansiForm").empty();$("#jabatanKuitansiForm").removeClass('is-valid');$("#jabatanKuitansiForm").removeClass('is-invalid');
            $("#tglBerangkatKuitansiForm").empty();$("#tglBerangkatKuitansiForm").removeClass('is-valid');$("#tglBerangkatKuitansiForm").removeClass('is-invalid');
            $("#tglKembaliKuitansiForm").empty();$("#tglKembaliKuitansiForm").removeClass('is-valid');$("#tglKembaliKuitansiForm").removeClass('is-invalid');
            $("#lamaKuitansiForm").empty();$("#lamaKuitansiForm").removeClass('is-valid');$("#lamaKuitansiForm").removeClass('is-invalid');
            $("#rekeningKuitansiForm").empty();$("#rekeningKuitansiForm").removeClass('is-valid');$("#rekeningKuitansiForm").removeClass('is-invalid');
            $("#instansiKuitansiForm").empty();$("#instansiKuitansiForm").removeClass('is-valid');$("#instansiKuitansiForm").removeClass('is-invalid');
            $("#untukKuitansiForm").empty();$("#untukKuitansiForm").removeClass('is-valid');$("#untukKuitansiForm").removeClass('is-invalid');
            $("#pejabatKuitansiForm").empty();$("#pejabatKuitansiForm").removeClass('is-valid');$("#pejabatKuitansiForm").removeClass('is-invalid');
            $("#jumlahKuitansiForm").empty();$("#jumlahKuitansiForm").removeClass('is-valid');$("#jumlahKuitansiForm").removeClass('is-invalid');
        }
        var url_destination = '<?= base_url('Bendahara/Kuitansi/getNoSpd') ?>';
        $("#noSpdKuitansiForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari NO SPD ---',
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

        $("#noSpdKuitansiForm").change(function() {
            pelaksana($(this).val());
            // Initialize select2
            var idSpd = $(this).val();var url_destination = '<?= base_url('Bendahara/Kuitansi/getPegawaiNoSpd') ?>';
            $("#namaPegawaiKuitansiForm").select2({
                minimumResultsForSearch: Infinity,
                theme: 'bootstrap4',
                placeholder: '--- Cari Data Pegawai ---',
                ajax: {url: url_destination,spd :idSpd,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,spd: idSpd,csrf_token_name: $('input[name=csrf_token_name]').val()}
                    },
                    processResults: function(response) {$('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data,}},
                    cache: true
                }
            });
        });

        $("#namaPegawaiKuitansiForm").change(function() {
            var namaPegawai = $(this).val();var idSpd = $("#noSpdKuitansiForm").val();
            var url_destination = '<?= base_url('Bendahara/Kuitansi/getDetailPegawaiNoSpd') ?>';
            $.ajax({
                    url: url_destination,type: "POST",data: {kode: namaPegawai, id: idSpd, csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        if (data.success==true) {
                            $('input[name=csrf_token_name]').val(data.csrf_token_name);
                            $('#nipKuitansiForm').val(data.nip);
                            $('#namaKuitansiForm').val(data.nama);
                            $('#pangkatKuitansiForm').val(data.pangol.nama_pangol);
                            $('#jabatanKuitansiForm').val(data.jabatan.nama_jabatan);
                            var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                            var awal = new Date(data.spd.awal);var curr_date = awal.getDate();var curr_month = awal.getMonth();var curr_year = awal.getFullYear();
                            $('#tglBerangkatKuitansiForm').val(curr_date + "/" + m_names[curr_month] + "/" + curr_year);
                            var akhir = new Date(data.spd.akhir);var curr_date = akhir.getDate();var curr_month = akhir.getMonth();var curr_year = akhir.getFullYear();
                            $('#tglKembaliKuitansiForm').val(curr_date + "/" + m_names[curr_month] + "/" + curr_year);
                            $("#lamaKuitansiForm").val(data.spd.lama);
                            $("#rekeningKuitansiForm").val(data.spd.kode_rekening);
                            $("#instansiKuitansiForm").val(data.instansi.nama_instansi);
                            $("#untukKuitansiForm").val(data.spd.untuk);
                            var jumlah = data.sbuh.jumlah_uang * data.spd.lama;
                            $("#jumlahKuitansiForm").val(jumlah);
                        }else{
                            toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["error"](data.msg, "Informasi");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
        });

        var pelaksana = (nospd) => {

            var bendaharaNip =<?= session()->nip ?>; var url_destination = '<?= base_url('Bendahara/Kuitansi/getPelaksana') ?>';
            $("#pejabatKuitansiForm").select2({
                theme: 'bootstrap4',
                placeholder: '--- Cari Pejabat Pelaksana Teknis ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,bendahara: bendaharaNip,spd: nospd,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);
                        return {results: response.data,};
                    },
                    cache: true
                }
            });
        }

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            if ($('#methodPage').val() === 'New') {var url_destination = "<?= base_url('Bendahara/Kuitansi/Create') ?>";
            } else {var url_destination = "<?= base_url('Bendahara/Kuitansi/Update') ?>";}
            $.ajax({url: url_destination,type: "POST",data: $(this).serialize(),dataType: "JSON",
                beforeSend: function() {
                    $('#submit-kuitansi').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-kuitansi').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-kuitansi').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-kuitansi').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'KuitansiForm').addClass('is-invalid');$("." + key + "ErrorForm").html(data.error[key]);$("." + key + "KuitansiErrorForm").html(data.error[key]);
                            var element = $('#' + key + 'KuitansiForm');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                    }
                    if (data.success==true) {
                        clearform();let timerInterval
                        swalWithBootstrapButtons.fire({
                            icon: 'success',title: 'Berhasil Memasukkan Data',
                            html: '<b>Otomatis Ke Table Kuitansi!</b><br>' +
                                'Tekan No Jika Ingin Memasukkan Data Yang Lainnya',
                            timer: 3500,timerProgressBar: true,
                            showCancelButton: true,confirmButtonText: 'Ya, Kembali!',
                            cancelButtonText: 'No, cancel!',reverseButtons: true,
                        }).then((result) => {
                            if (result.isConfirmed) {window.location.href = data.redirect;
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if ($('#methodPage').val() === 'New') {location.reload();
                                }else{window.location.replace("<?= base_url('Bendahara/Kuitansi/new')?>");}
                            } else if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = data.redirect;
                            }
                        })
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            $("#" + key + 'Form').addClass('is-invalid');$("." + key + "ErrorForm").html(data.msg[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
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
                var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Bendahara/Kuitansi/single_data') ?>";
                $.ajax({
                    url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        $('#submit-kuitansi').removeClass("btn-success");
                        $('#submit-kuitansi').addClass("btn-warning text-white");
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        $("#noSpdKuitansiForm").append($("<option selected='selected'></option>")
                        .val(data.spd.id).text(data.spd.kode)).trigger('change');
                        $("#namaPegawaiKuitansiForm").append($("<option selected='selected'></option>")
                        .val(data.pegawai.nip).text(data.pegawai.nama)).trigger('change');
                        $('#nipKuitansiForm').val(data.pegawai.nip);
                        $('#namaKuitansiForm').val(data.pegawai.nama);
                        $('#pangkatKuitansiForm').val(data.pangol.nama_pangol);
                        $('#jabatanKuitansiForm').val(data.jabatan.nama_jabatan);
                        var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                        var awal = new Date(data.spd.awal);var curr_date = awal.getDate();var curr_month = awal.getMonth();var curr_year = awal.getFullYear();
                        $('#tglBerangkatKuitansiForm').val(curr_date + "/" + m_names[curr_month] + "/" + curr_year);
                        var akhir = new Date(data.spd.akhir);var curr_date = akhir.getDate();var curr_month = akhir.getMonth();var curr_year = akhir.getFullYear();
                        $('#tglKembaliKuitansiForm').val(curr_date + "/" + m_names[curr_month] + "/" + curr_year);
                        $("#lamaKuitansiForm").val(data.spd.lama);
                        $("#rekeningKuitansiForm").val(data.spd.kode_rekening);
                        $("#instansiKuitansiForm").val(data.instansi.nama_instansi);
                        $("#untukKuitansiForm").val(data.spd.untuk);
                        var jumlah = data.sbuh.jumlah_uang * data.spd.lama;
                        $("#jumlahKuitansiForm").val(jumlah);
                        $("#pejabatKuitansiForm").append($("<option selected='selected'></option>")
                        .val(data.pejabat.nip).text(data.pejabat.nama)).trigger('change');
                        $('#submit-kuitansi').html('<i class="fas fa-save"></i>&ensp;Update');
                    },error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
            }
        }

    })
</script>
<?= $this->endSection() ?>
