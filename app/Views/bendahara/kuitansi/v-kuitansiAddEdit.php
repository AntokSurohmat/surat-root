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
                                            <label for="noSpdForm" class="col-sm-3 col-form-label" style="text-align: right;">No SPD </label>
                                            <div class="col-sm-7">
                                                <input type="text" name="noSpdAddEditForm" class="form-control" id="noSpdForm" placeholder="Masukkan No SPD"/>
                                                <div class="invalid-feedback noSpdErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="namaPegawaiForm" class="col-sm-3 col-form-label" style="text-align: right;">Nama Pegawai</label>
                                            <div class="col-sm-7">
                                                <select name="namaPegawaiAddEditForm" id="namaPegawaiForm" class="form-control " style="width: 100%;">
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
                                            <input type="email" class="form-control" name="nipAddEditForm" id="nipKuitansiForm" placeholder="NIP Pegawai" readonly>
                                            <div class="invalid-feedback nipKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="namaKuitansiForm">Nama Pegawai</label>
                                            <input type="email" class="form-control" name="namaAddEditForm" id="namaKuitansiForm" placeholder="Nama Pegawai" readonly>
                                            <div class="invalid-feedback namaKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="pangkatKuitansiForm">Pangkat</label>
                                            <input type="email" class="form-control" name="pangkatAddEditForm" id="pangkatKuitansiForm" placeholder="Pangkat" readonly>
                                            <div class="invalid-feedback pangkatKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="jabatanKuitansiForm">Jabatan</label>
                                            <input type="email" class="form-control" name="jabatanAddEditForm" id="jabatanKuitansiForm" placeholder="Jabatan" readonly>
                                            <div class="invalid-feedback jabatanKuitansiErrorForm"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="tglBerangkatKuitansiForm">Tanggal Berangkat</label>
                                            <input type="email" class="form-control" name="tglBerangkatAddEditForm" id="tglBerangkatKuitansiForm" placeholder="Tanggal Berangkat" readonly>
                                            <div class="invalid-feedback tglBerangkatKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="tglKembaliKuitansiForm">Tanggal Kembali</label>
                                            <input type="email" class="form-control" name="tglKembaliAddEditForm" id="tglKembaliKuitansiForm" placeholder="Tanggal Kembali" readonly>
                                            <div class="invalid-feedback tglKembaliKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="lamaKuitansiForm">Lama Perjalanan</label>
                                            <input type="email" class="form-control" name="lamaAddEditForm" id="lamaKuitansiForm" placeholder="Perjalanan" readonly>
                                            <div class="invalid-feedback lamaKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="rekeningKuitansiForm">Kode Rekening</label>
                                            <input type="email" class="form-control" name="rekeningAddEditForm" id="rekeningKuitansiForm" placeholder="Kode Rekening" readonly>
                                            <div class="invalid-feedback rekeningKuitansiErrorForm"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for="instansiKuitansiForm">Nama Instansi</label>
                                            <input type="email" class="form-control" name="instansiAddEditForm" id="instansiKuitansiForm" placeholder="Nama Instansi" readonly>
                                            <div class="invalid-feedback instansiKuitansiErrorForm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="untukKuitansiForm" class="col-form-label">Maksud Perjalanan Dinas</label>
                                            <textarea name="untukAddEditForm" class="form-control" id="untukKuitansiForm" rows="3" placeholder="Maksud Perjalanan Dinas" readonly></textarea>
                                            <div class="invalid-feedback untukErrorForm"></div>
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
                                            <div class="col-sm-12 row">
                                            <p class="col-sm-1 mt-2">Rp. </p>
                                            <input type="email" class="form-control col-sm-8" name="jumlahAddEditForm" id="jumlahKuitansiForm" placeholder="Nama jumlah" readonly>
                                            </div>
                                            <div class="invalid-feedback jumlahKuitansiErrorForm"></div>
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

        $('#noSpdForm').keydown(function(event){if(event.keyCode == 13){$('#namaPegawaiForm').select2('open');}});
        $('#namaPegawaiForm').on('select2:select', function(e) {$('#pejabatKuitansiForm').select2('open');});
        $('#pejabatKuitansiForm').on('select2:select', function(e) {$('#submit-kuitansi').focus();});

        function clearform() {
            $('#form-addedit')[0].reset();
            $("#noSpdForm").empty();$("#noSpdForm").removeClass('is-valid');$("#noSpdForm").removeClass('is-invalid');
            $("#namaPegawaiForm").empty();$("#namaPegawaiForm").removeClass('is-valid');$("#namaPegawaiForm").removeClass('is-invalid');
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

        var url_destination = '<?= base_url('Bendahara/Kuitansi/getPegawai') ?>';
        $("#pejabatKuitansiForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Jabatan ---',
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
    })
</script>
<?= $this->endSection() ?>
