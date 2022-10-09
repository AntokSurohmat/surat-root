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
                                        <div class="invalid-feedback rincianBiayaSpdErrorForm"></div>
                                    </div>
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
                                            <label for="rincian_biayaSatuForm" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="rincianBiayaAddEditForm[]" id="rincian_biayaSatuForm" class="form-control" placeholder="Rincian Biaya">
                                                <div class="invalid-feedback rincianBiayaSatuErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jumlah_biayaSatuForm" class="col-sm-4 col-form-label">Jumlah </label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="number" name="jumlahAddEditForm[]" id="jumlah_biayaSatuForm" class="form-control" placeholder="Jumlah Uang" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8">
                                                    <div class="invalid-feedback jumlahSatuErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="buktiSatuForm" class="col-sm-2 col-form-label">Bukti Riil</label>
                                            <div class="col-sm-7">
                                                <div class="custom-file">
                                                    <input type="file" name="buktiAddEditForm[]" class="custom-file-input" id="buktiSatuForm">
                                                    <label class="custom-file-label" for="buktiSatuForm">Choose file</label>
                                                    <div class="invalid-feedback buktiSatuErrorForm"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" id="0" class="btn btn-primary btn-bukti d-none" data-rel="tooltip" data-placement="top" data-container=".content" title="Lihat Bukti"><i class="fa fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="s9">
                                <!-- /.Dua -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="rincian_biayaDuaForm" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="rincianBiayaAddEditForm[]" id="rincian_biayaDuaForm" class="form-control" placeholder="Rincian Biaya">
                                                <div class="invalid-feedback rincianBiayaDuaErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jumlah_biayaDuaForm" class="col-sm-4 col-form-label">Jumlah </label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="number" name="jumlahAddEditForm[]" id="jumlah_biayaDuaForm" class="form-control" placeholder="Jumlah Uang" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8">
                                                    <div class="invalid-feedback jumlahDuaErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="buktiDuaForm" class="col-sm-2 col-form-label">Bukti Riil</label>
                                            <div class="col-sm-7">
                                                <div class="custom-file">
                                                    <input type="file" name="buktiAddEditForm[]" class="custom-file-input" id="buktiDuaForm">
                                                    <label class="custom-file-label" for="buktiDuaForm">Choose file</label>
                                                    <div class="invalid-feedback buktiDuaErrorForm"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" id="1" class="btn btn-primary btn-bukti d-none" data-rel="tooltip" data-placement="top" data-container=".content" title="Lihat Bukti"><i class="fa fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="s9">
                                <!-- /.Tiga -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="rincian_biayaTigaForm" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="rincianBiayaAddEditForm[]" id="rincian_biayaTigaForm" class="form-control" placeholder="Rincian Biaya">
                                                <div class="invalid-feedback rincianBiayaTigaErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jumlah_biayaTigaForm" class="col-sm-4 col-form-label">Jumlah </label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="number" name="jumlahAddEditForm[]" id="jumlah_biayaTigaForm" class="form-control" placeholder="Jumlah Uang" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8">
                                                    <div class="invalid-feedback jumlahTigaErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="buktiTigaForm" class="col-sm-2 col-form-label">Bukti Riil</label>
                                            <div class="col-sm-7">
                                                <div class="custom-file">
                                                    <input type="file" name="buktiAddEditForm[]" class="custom-file-input" id="buktiTigaForm">
                                                    <label class="custom-file-label" for="buktiTigaForm">Choose file</label>
                                                    <div class="invalid-feedback buktiTigaErrorForm"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" id="2" class="btn btn-primary btn-bukti d-none" data-rel="tooltip" data-placement="top" data-container=".content" title="Lihat Bukti"><i class="fa fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="s9">
                                <!-- /.Empat -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="rincian_biayaEmpatForm" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="rincianBiayaAddEditForm[]" id="rincian_biayaEmpatForm" class="form-control" placeholder="Rincian Biaya">
                                                <div class="invalid-feedback rincianBiayaEmpatErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jumlah_biayaEmpatForm" class="col-sm-4 col-form-label">Jumlah </label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="number" name="jumlahAddEditForm[]" id="jumlah_biayaEmpatForm" class="form-control" placeholder="Jumlah Uang" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8">
                                                    <div class="invalid-feedback jumlahEmpatErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="buktiEmpatForm" class="col-sm-2 col-form-label">Bukti Riil</label>
                                            <div class="col-sm-7">
                                                <div class="custom-file">
                                                    <input type="file" name="buktiAddEditForm[]" class="custom-file-input" id="buktiEmpatForm">
                                                    <label class="custom-file-label" for="buktiEmpatForm">Choose file</label>
                                                    <div class="invalid-feedback buktiEmpatErrorForm"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" id="3" class="btn btn-primary btn-bukti d-none" data-rel="tooltip" data-placement="top" data-container=".content" title="Lihat Bukti"><i class="fa fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="s9">
                                <!-- /.Lima -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="rincian_biayaLimaForm" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="rincianBiayaAddEditForm[]" id="rincian_biayaLimaForm" class="form-control" placeholder="Rincian Biaya">
                                                <div class="invalid-feedback rincianBiayaLimaErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jumlah_biayaLimaForm" class="col-sm-4 col-form-label">Jumlah </label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Rp.</span>
                                                    </div>
                                                    <input type="number" name="jumlahAddEditForm[]" id="jumlah_biayaLimaForm" class="form-control" placeholder="Jumlah Uang" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="8">
                                                    <div class="invalid-feedback jumlahLimaErrorForm"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group row">
                                            <label for="buktiLimaForm" class="col-sm-2 col-form-label">Bukti Riil</label>
                                            <div class="col-sm-7">
                                                <div class="custom-file">
                                                    <input type="file" name="buktiAddEditForm[]" class="custom-file-input" id="buktiLimaForm">
                                                    <label class="custom-file-label" for="buktiLimaForm">Choose file</label>
                                                    <div class="invalid-feedback buktiLimaErrorForm"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="button" id="4" class="btn btn-primary btn-bukti d-none" data-rel="tooltip" data-placement="top" data-container=".content" title="Lihat Bukti"><i class="fa fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
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

        <!--Modal Bukti-->
        <div id="modal-tujuan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalView" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="namaBuktiModal">Nama Rincian Biaya</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" id="bodyBukti">

                    <!-- <embed id="embedBukti" src=""
                               frameborder="0" width="100%" height="600px">


                    <img id="imgBukti" src=""
                               frameborder="0" width="100%" height="600px"> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                    </div>

                </div>
            </div>
        </div><!-- /.modal Bukti -->

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {
        // preventDefault to stay in modal when keycode 13
        $('form input').keydown(function(event) {if (event.keyCode == 13) {event.preventDefault();return false;}});

        $('#noSpdForm').on('select2:select', function(e) {$('#rincian_biayaSatuForm').focus();});
        //Satu
        $('#rincian_biayaSatuForm').keydown(function(event){if(event.keyCode == 13){$('#jumlah_biayaSatuForm').focus();}});
        $('#jumlah_biayaSatuForm').keydown(function(event){if(event.keyCode == 13){$('#buktiSatuForm').focus();}});
        //Dua
        $('#rincian_biayaDuaForm').keydown(function(event){if(event.keyCode == 13){$('#jumlah_biayaDuaForm').focus();}});
        $('#jumlah_biayaDuaForm').keydown(function(event){if(event.keyCode == 13){$('#buktiDuaForm').focus();}});
        //Tiga
        $('#rincian_biayaTigaForm').keydown(function(event){if(event.keyCode == 13){$('#jumlah_biayaTigaForm').focus();}});
        $('#jumlah_biayaTigaForm').keydown(function(event){if(event.keyCode == 13){$('#buktiTigaForm').focus();}});
        //Empat
        $('#rincian_biayaEmpatForm').keydown(function(event){if(event.keyCode == 13){$('#jumlah_biayaEmpatForm').focus();}});
        $('#jumlah_biayaEmpatForm').keydown(function(event){if(event.keyCode == 13){$('#buktiEmpatForm').focus();}});
        //Lima
        $('#rincian_biayaLimaForm').keydown(function(event){if(event.keyCode == 13){$('#jumlah_biayaLimaForm').focus();}});
        $('#jumlah_biayaLimaForm').keydown(function(event){if(event.keyCode == 13){$('#buktiLimaForm').focus();}});

        $('#keteranganBuktiLimaForm').keydown(function(event){if(event.keyCode == 13){$('#submit-rincian').focus();}});

        update();bsCustomFileInput.init();

        function clearform() {
            $('#form-addedit')[0].reset();
            $("#noSpdForm").empty();$("#noSpdForm").removeClass('is-valid');$("#noSpdForm").removeClass('is-invalid');
            //Satu
            $("#rincian_biayaSatuForm").empty();$("#rincian_biayaSatuForm").removeClass('is-valid');$("#rincian_biayaSatuForm").removeClass('is-invalid');
            $("#jumlah_biayaSatuForm").empty();$("#jumlah_biayaSatuForm").removeClass('is-valid');$("#jumlah_biayaSatuForm").removeClass('is-invalid');
            $("#buktiSatuForm").empty();$("#buktiSatuForm").removeClass('is-valid');$("#buktiSatuForm").removeClass('is-invalid');
            //Dua
            $("#rincian_biayaDuaForm").empty();$("#rincian_biayaDuaForm").removeClass('is-valid');$("#rincian_biayaDuaForm").removeClass('is-invalid');
            $("#jumlah_biayaDuaForm").empty();$("#jumlah_biayaDuaForm").removeClass('is-valid');$("#jumlah_biayaDuaForm").removeClass('is-invalid');
            $("#buktiDuaForm").empty();$("#buktiDuaForm").removeClass('is-valid');$("#buktiDuaForm").removeClass('is-invalid');
            $("#keteranganBuktiDuaForm").empty();$("#keteranganBuktiDuaForm").removeClass('is-valid');$("#keteranganBuktiDuaForm").removeClass('is-invalid');
            //Tiga
            $("#rincian_biayaTigaForm").empty();$("#rincian_biayaTigaForm").removeClass('is-valid');$("#rincian_biayaTigaForm").removeClass('is-invalid');
            $("#jumlah_biayaTigaForm").empty();$("#jumlah_biayaTigaForm").removeClass('is-valid');$("#jumlah_biayaTigaForm").removeClass('is-invalid');
            $("#buktiTigaForm").empty();$("#buktiTigaForm").removeClass('is-valid');$("#buktiTigaForm").removeClass('is-invalid');
            $("#keteranganBuktiTigaForm").empty();$("#keteranganBuktiTigaForm").removeClass('is-valid');$("#keteranganBuktiTigaForm").removeClass('is-invalid');
            //Empat
            $("#rincian_biayaEmpatForm").empty();$("#rincian_biayaEmpatForm").removeClass('is-valid');$("#rincian_biayaEmpatForm").removeClass('is-invalid');
            $("#jumlah_biayaEmpatForm").empty();$("#jumlah_biayaEmpatForm").removeClass('is-valid');$("#jumlah_biayaEmpatForm").removeClass('is-invalid');
            $("#buktiEmpatForm").empty();$("#buktiEmpatForm").removeClass('is-valid');$("#buktiEmpatForm").removeClass('is-invalid');
            $("#keteranganBuktiEmpatForm").empty();$("#keteranganBuktiEmpatForm").removeClass('is-valid');$("#keteranganBuktiEmpatForm").removeClass('is-invalid');
            //Lima
            $("#rincian_biayaLimaForm").empty();$("#rincian_biayaLimaForm").removeClass('is-valid');$("#rincian_biayaLimaForm").removeClass('is-invalid');
            $("#jumlah_biayaLimaForm").empty();$("#jumlah_biayaLimaForm").removeClass('is-valid');$("#jumlah_biayaLimaForm").removeClass('is-invalid');
            $("#buktiLimaForm").empty();$("#buktiLimaForm").removeClass('is-valid');$("#buktiLimaForm").removeClass('is-invalid');
            $("#keteranganBuktiLimaForm").empty();$("#keteranganBuktiLimaForm").removeClass('is-valid');$("#keteranganBuktiLimaForm").removeClass('is-invalid');
        }

        $('.btn-bukti').click(function() {
            
            if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {
                var id_btn = $(this).attr('id');var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Bendahara/Rincian/getBukti') ?>";
                $.ajax({
                    url: url_destination,type: "POST",data: {id: id,number: id_btn,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        // console.log(data);
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        showPdf(data);
                    },error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
            }

            var option = {backdrop: 'static',keyboard: true};
            $('#modal-tujuan').modal(option);$('#modal-tujuan').modal('show');
        });

        var showPdf = (data) => {

            $('#modal-tujuan').on('shown.bs.modal', function() {
                console.log(data.rincian_biaya);
                $('#namaBuktiModal').text(data.rincian_biaya);
                $('#namaBuktiModal').css('text-transform', 'capitalize');

                var fileName, fileExtension;
                fileName = data.bukti_riil;
                fileExtension = fileName.split('.').pop();
                console.log (fileExtension);

                switch (fileExtension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                        $('#bodyBukti').html('<img src="<?= base_url() ?>/uploads/rincian/'+data.bukti_riil+'" frameborder="0" width="100%" height="500px">');
                    break;
                    default:
                        $('#bodyBukti').html('<embed src="<?= base_url() ?>/uploads/rincian/'+data.bukti_riil+'" frameborder="0" width="100%" height="600px">');

            }

                // $('#embedBukti').attr('src', '<?= base_url() ?>/uploads/rincian/'+data.bukti_riil);
            });
        }
        $('#modal-tujuan').on('hidden.bs.modal', function() {
            $('#bodyBukti').html('<img src="" frameborder="0" width="100%" height="500px">');
            $('#bodyBukti').html('<emebed src="" frameborder="0" width="100%" height="600px">');
        });

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
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        if(data.success){
                            // console.log(data);
                            $("#rincianBiayaSpdForm").val(data.isi.untuk);
                            var jumlah = data.rincian.jumlah_uang * data.isi.lama;
                            $("#jumlahTotalSpdForm").val(jumlah);
                        }else{
                            if (data.msg != "") {
                                toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["error"](data.msg, "Informasi");
                            }
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
        })

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            if ($('#methodPage').val() === 'New') {var url_destination = "<?= base_url('Bendahara/Rincian/Create') ?>";
            } else {var url_destination = "<?= base_url('Bendahara/Rincian/Update') ?>";}
            // console.log($(this).serialize());
            $.ajax({url: url_destination,type: "POST",data: new FormData(this),processData:false,contentType:false,cache:false,async:false,
                beforeSend: function() {
                    $('#submit-rincian').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-rincian').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-rincian').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-rincian').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            // console.log(key);
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
                            html: '<b>Otomatis Ke Table Rincian!</b><br>' +
                                'Tekan No Jika Ingin Memasukkan Data Yang Lainnya',
                            timer: 3500,timerProgressBar: true,
                            showCancelButton: true,confirmButtonText: 'Ya, Kembali!',
                            cancelButtonText: 'No, cancel!',reverseButtons: true,
                        }).then((result) => {
                            if (result.isConfirmed) {window.location.href = data.redirect;
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if ($('#methodPage').val() === 'New') {location.reload();
                                }else{window.location.replace("<?= base_url('Bendahara/Rincian/new')?>");}
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
        });

        function update() {
            if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {
                // Remove d-none button view bukti
                // $('.btn-bukti').removeClass("d-none");

                var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Bendahara/Rincian/single_data') ?>";
                $.ajax({
                    url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        // console.log(data);
                        $('#submit-rincian').removeClass("btn-success");
                        $('#submit-rincian').addClass("btn-warning text-white");
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        $("#noSpdForm").append($("<option selected='selected'></option>")
                        .val(data.kode_spd).text(data.kode_spd)).trigger('change');
                        var m_names = new Array("Satu","Dua","Tiga","Empat","Lima");
                        var m_nomor = new Array("0","1","2","3","4");
                        for (var urutan in data.json) { //json
                            // console.log(urutan);
                            var obj = data.json[urutan];
                            for (var prop in obj) {
                                // console.log(prop + " = " + obj[prop] + ' ++++++ ' );
                                // console.log('#'+ prop + m_names[urutan] + 'Form');
                                // console.log('#' +m_names[urutan] + 'nomer');
                                $('#'+ prop + m_names[urutan] +'Form').val(obj[prop]);
                                if(prop === 'bukti_riil' && obj[prop] !== ""){
                                    $('#' + m_nomor[urutan]).removeClass("d-none");
                                    // console.log(m_nomor[urutan]);
                                }
                            }
                        }
                    },error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
            }
        }
    })
</script>
<?= $this->endSection() ?>
