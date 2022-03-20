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
                                <div class="form-group row">
                                    <label for="noSpdForm" class="col-sm-2 col-form-label">No SPD </label>
                                    <div class="col-sm-7">
                                        <select name="noSpdAddEditForm" id="noSpdForm" class="form-control " style="width: 100%;">
                                            <option value="">--- Cari No SPD ---</option>
                                        </select>
                                        <div class="invalid-feedback noSpdErrorForm"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rincianBiayaSpdForm" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                    <div class="col-sm-7">
                                        <input type="text" name="rincianBiayaSpdAddEditForm" class="form-control" id="rincianBiayaSpdForm" placeholder="Biaya Uang Harian" readonly>
                                    </div>
                                    <div class="invalid-feedback rincianBiayaSpdErrorForm"></div>
                                </div>
                                <div class="form-group row">
                                    <label for="jumlahTotalSpdForm" class="col-sm-2 col-form-label">Jumlah </label>
                                    <div class="col-sm-7">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input type="text" name="jumlahTotalSpdAddEditForm" id="jumlahTotalSpdForm" class="form-control" placeholder="Jumlah Uang" readonly>
                                            <div class="invalid-feedback jumlahTotalSpdErrorForm"></div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="s9">

                                <!-- /.Satu -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="rincianBiayaSatuForm" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="rincianBiayaSatuAddEditForm" id="rincianBiayaSatuForm" class="form-control" placeholder="Rincian Biaya">
                                                <div class="invalid-feedback rincianBiayaSatuErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="buktiSatuForm" class="col-sm-4 col-form-label">Bukti Riil</label>
                                            <div class="col-sm-8">
                                                <div class="custom-file">
                                                    <input type="file" name="buktiSatuAddEditForm" class="custom-file-input" id="buktiSatuForm">
                                                    <label class="custom-file-label" for="buktiSatuForm">Choose file</label>
                                                    <div class="invalid-feedback buktiSatuErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jumlahSatuForm" class="col-sm-2 col-form-label">Jumlah </label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" name="jumlahAddEditForm" id="jumlahSatuForm" class="form-control" placeholder="Jumlah Uang">
                                                    <div class="invalid-feedback jumlahErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="s9">
                                <!-- /.Dua -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="rincianBiayaDuaForm" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="rincianBiayaDuaAddEditForm" id="rincianBiayaDuaForm" class="form-control" placeholder="Rincian Biaya">
                                                <div class="invalid-feedback rincianBiayaDuaErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="buktiDuaForm" class="col-sm-4 col-form-label">Bukti Riil</label>
                                            <div class="col-sm-8">
                                                <div class="custom-file">
                                                    <input type="file" name="buktiDuaAddEditForm" class="custom-file-input" id="buktiDuaForm">
                                                    <label class="custom-file-label" for="buktiDuaForm">Choose file</label>
                                                    <div class="invalid-feedback buktiDuaErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jumlahDuaForm" class="col-sm-2 col-form-label">Jumlah </label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" name="jumlahAddEditForm" id="jumlahDuaForm" class="form-control" placeholder="Jumlah Uang">
                                                    <div class="invalid-feedback jumlahErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="s9">
                                <!-- /.Tiga -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="rincianBiayaTigaForm" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="rincianBiayaTigaAddEditForm" id="rincianBiayaTigaForm" class="form-control" placeholder="Rincian Biaya">
                                                <div class="invalid-feedback rincianBiayaTigaErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="buktiTigaForm" class="col-sm-4 col-form-label">Bukti Riil</label>
                                            <div class="col-sm-8">
                                                <div class="custom-file">
                                                    <input type="file" name="buktiTigaAddEditForm" class="custom-file-input" id="buktiTigaForm">
                                                    <label class="custom-file-label" for="buktiTigaForm">Choose file</label>
                                                    <div class="invalid-feedback buktiTigaErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jumlahTigaForm" class="col-sm-2 col-form-label">Jumlah </label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" name="jumlahAddEditForm" id="jumlahTigaForm" class="form-control" placeholder="Jumlah Uang">
                                                    <div class="invalid-feedback jumlahErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="s9">
                                <!-- /.Empat -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="rincianBiayaEmpatForm" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="rincianBiayaEmpatAddEditForm" id="rincianBiayaEmpatForm" class="form-control" placeholder="Rincian Biaya">
                                                <div class="invalid-feedback rincianBiayaEmpatErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="buktiEmpatForm" class="col-sm-4 col-form-label">Bukti Riil</label>
                                            <div class="col-sm-8">
                                                <div class="custom-file">
                                                    <input type="file" name="buktiEmpatAddEditForm" class="custom-file-input" id="buktiEmpatForm">
                                                    <label class="custom-file-label" for="buktiEmpatForm">Choose file</label>
                                                    <div class="invalid-feedback buktiEmpatErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jumlahEmpatForm" class="col-sm-2 col-form-label">Jumlah </label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" name="jumlahAddEditForm" id="jumlahEmpatForm" class="form-control" placeholder="Jumlah Uang">
                                                    <div class="invalid-feedback jumlahErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="s9">
                                <!-- /.Lima -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="rincianBiayaLimaForm" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="rincianBiayaLimaAddEditForm" id="rincianBiayaLimaForm" class="form-control" placeholder="Rincian Biaya">
                                                <div class="invalid-feedback rincianBiayaLimaErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="buktiLimaForm" class="col-sm-4 col-form-label">Bukti Riil</label>
                                            <div class="col-sm-8">
                                                <div class="custom-file">
                                                    <input type="file" name="buktiLimaAddEditForm" class="custom-file-input" id="buktiLimaForm">
                                                    <label class="custom-file-label" for="buktiLimaForm">Choose file</label>
                                                    <div class="invalid-feedback buktiLimaErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jumlahLimaForm" class="col-sm-2 col-form-label">Jumlah </label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="text" name="jumlahAddEditForm" id="jumlahLimaForm" class="form-control" placeholder="Jumlah Uang">
                                                    <div class="invalid-feedback jumlahErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="s9">
                                
                                </div>
                            </div>

                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer" style="text-align:center;">
                            <a type="button" href="<?= base_url('') ?>/Bendahara/Rincian" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i>&ensp;Back</a>
                            <button type="submit" id="submit-rincian" class="btn btn-success ml-2"><i class="fas fa-save"></i>&ensp;Submit</button>
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

        $('#noSpdForm').on('select2:select', function(e) {$('#rincianBiayaSatuForm').focus();});
        //Satu
        $('#rincianBiayaSatuForm').keydown(function(event){if(event.keyCode == 13){$('#jumlahSatuForm').focus();}});
        $('#jumlahSatuForm').keydown(function(event){if(event.keyCode == 13){$('#buktiSatuForm').focus();}});
        $('#buktiSatuForm').keydown(function(event){if(event.keyCode == 13){$('#keteranganBuktiSatuForm').focus();}});
        //Dua
        $('#rincianBiayaDuaForm').keydown(function(event){if(event.keyCode == 13){$('#jumlahDuaForm').focus();}});
        $('#jumlahDuaForm').keydown(function(event){if(event.keyCode == 13){$('#buktiDuaForm').focus();}});
        $('#buktiDuaForm').keydown(function(event){if(event.keyCode == 13){$('#keteranganBuktiDuaForm').focus();}});
        //Tiga
        $('#rincianBiayaTigaForm').keydown(function(event){if(event.keyCode == 13){$('#jumlahTigaForm').focus();}});
        $('#jumlahTigaForm').keydown(function(event){if(event.keyCode == 13){$('#buktiTigaForm').focus();}});
        $('#buktiTigaForm').keydown(function(event){if(event.keyCode == 13){$('#keteranganBuktiTigaForm').focus();}});
        //Empat
        $('#rincianBiayaEmpatForm').keydown(function(event){if(event.keyCode == 13){$('#jumlahEmpatForm').focus();}});
        $('#jumlahEmpatForm').keydown(function(event){if(event.keyCode == 13){$('#buktiEmpatForm').focus();}});
        $('#buktiEmpatForm').keydown(function(event){if(event.keyCode == 13){$('#keteranganBuktiEmpatForm').focus();}});
        //Lima
        $('#rincianBiayaLimaForm').keydown(function(event){if(event.keyCode == 13){$('#jumlahLimaForm').focus();}});
        $('#jumlahLimaForm').keydown(function(event){if(event.keyCode == 13){$('#buktiLimaForm').focus();}});
        $('#buktiLimaForm').keydown(function(event){if(event.keyCode == 13){$('#keteranganBuktiLimaForm').focus();}});

        $('#keteranganBuktiLimaForm').keydown(function(event){if(event.keyCode == 13){$('#submit-rincian').focus();}});


        function clearform() {
            $('#form-addedit')[0].reset();
            $("#noSpdForm").empty();$("#noSpdForm").removeClass('is-valid');$("#noSpdForm").removeClass('is-invalid');
            //Satu
            $("#rincianBiayaSatuForm").empty();$("#rincianBiayaSatuForm").removeClass('is-valid');$("#rincianBiayaSatuForm").removeClass('is-invalid');
            $("#jumlahSatuForm").empty();$("#jumlahSatuForm").removeClass('is-valid');$("#jumlahSatuForm").removeClass('is-invalid');
            $("#buktiSatuForm").empty();$("#buktiSatuForm").removeClass('is-valid');$("#buktiSatuForm").removeClass('is-invalid');
            $("#keteranganBuktiSatuForm").empty();$("#keteranganBuktiSatuForm").removeClass('is-valid');$("#keteranganBuktiSatuForm").removeClass('is-invalid');
            //Dua
            $("#rincianBiayaDuaForm").empty();$("#rincianBiayaDuaForm").removeClass('is-valid');$("#rincianBiayaDuaForm").removeClass('is-invalid');
            $("#jumlahDuaForm").empty();$("#jumlahDuaForm").removeClass('is-valid');$("#jumlahDuaForm").removeClass('is-invalid');
            $("#buktiDuaForm").empty();$("#buktiDuaForm").removeClass('is-valid');$("#buktiDuaForm").removeClass('is-invalid');
            $("#keteranganBuktiDuaForm").empty();$("#keteranganBuktiDuaForm").removeClass('is-valid');$("#keteranganBuktiDuaForm").removeClass('is-invalid');
            //Tiga
            $("#rincianBiayaTigaForm").empty();$("#rincianBiayaTigaForm").removeClass('is-valid');$("#rincianBiayaTigaForm").removeClass('is-invalid');
            $("#jumlahTigaForm").empty();$("#jumlahTigaForm").removeClass('is-valid');$("#jumlahTigaForm").removeClass('is-invalid');
            $("#buktiTigaForm").empty();$("#buktiTigaForm").removeClass('is-valid');$("#buktiTigaForm").removeClass('is-invalid');
            $("#keteranganBuktiTigaForm").empty();$("#keteranganBuktiTigaForm").removeClass('is-valid');$("#keteranganBuktiTigaForm").removeClass('is-invalid');
            //Empat
            $("#rincianBiayaEmpatForm").empty();$("#rincianBiayaEmpatForm").removeClass('is-valid');$("#rincianBiayaEmpatForm").removeClass('is-invalid');
            $("#jumlahEmpatForm").empty();$("#jumlahEmpatForm").removeClass('is-valid');$("#jumlahEmpatForm").removeClass('is-invalid');
            $("#buktiEmpatForm").empty();$("#buktiEmpatForm").removeClass('is-valid');$("#buktiEmpatForm").removeClass('is-invalid');
            $("#keteranganBuktiEmpatForm").empty();$("#keteranganBuktiEmpatForm").removeClass('is-valid');$("#keteranganBuktiEmpatForm").removeClass('is-invalid');
            //Lima
            $("#rincianBiayaLimaForm").empty();$("#rincianBiayaLimaForm").removeClass('is-valid');$("#rincianBiayaLimaForm").removeClass('is-invalid');
            $("#jumlahLimaForm").empty();$("#jumlahLimaForm").removeClass('is-valid');$("#jumlahLimaForm").removeClass('is-invalid');
            $("#buktiLimaForm").empty();$("#buktiLimaForm").removeClass('is-valid');$("#buktiLimaForm").removeClass('is-invalid');
            $("#keteranganBuktiLimaForm").empty();$("#keteranganBuktiLimaForm").removeClass('is-valid');$("#keteranganBuktiLimaForm").removeClass('is-invalid');
        }

        // Initialize select2
        var url_destination = '<?= base_url('Bendahara/Rincian/getNoSpd') ?>';
        $("#noSpdForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari No SPD ---',
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

        $("#noSpdForm").change(function() { 
            var noSpd = $(this).val();
            var url_destination = '<?= base_url('Bendahara/Rincian/getDetailNoSpd') ?>';
            $.ajax({
                    url: url_destination,type: "POST",data: {kode: noSpd,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        // console.log(data);
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        $("#rincianBiayaSpdForm").val(data.untuk);
                        var jumlah = data.sbuh.jumlah_uang * data.lama;
                        $("#jumlahTotalSpdForm").val(jumlah);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
        })
    })
</script>
<?= $this->endSection() ?>
