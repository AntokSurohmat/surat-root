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
                                                <select name="pegawaiAddEditForm" id="pegawaiForm" class="form-control select2bs4" style="width: 100%;">
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
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title" style="font-weight: 900;margin-top:-25px;padding: 0 5px;background-color:#FFF;">I</h3>
                                </div>
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="berangkatdariFormfirst">Berangkat Dari</label>
                                        <input type="text" class="form-control" name="berangkatAddEditFormFirst" id="berangkatdariFormfirst" placeholder="Berangkat Dari">
                                        <div class="invalid-feedback berangkatErrorFormFirst"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuanFormfirst">Tujuan Instansi</label>
                                        <input type="text" class="form-control" name="tujuanAddEditFormFirst" id="tujuanFormfirst" placeholder="tujuan Dari">
                                        <div class="invalid-feedback tujuanErrorFormFirst"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalBerangkatFormfirst">Tanggal Berangkat</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalBerangkatAddEditFormfirst" id="tanggalBerangkatFormfirst" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalBerangkatErrorFormFirst"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaBerangkatFormfirst">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaBerangkatAddEditFormFirst" id="kepalaBerangkatFormfirst" placeholder="Kepala Pada Saat Tiba">
                                        <div class="invalid-feedback kepalaBerangkatErrorFormFirst"></div>
                                    </div>
                                    <hr class="s9" style="margin: 0;">
                                    <div class="form-group">
                                        <label for="tibadiFormfirst">Tiba Di</label>
                                        <input type="text" class="form-control" name="tibadiAddEditFirst" id="tibadiFormfirst" placeholder="Tiba Di">
                                        <div class="invalid-feedback tibadiErrorFormFirst"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalTibaFormfirst">Tanggal Tiba</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalTibaAddEditFormFirst" id="tanggalTibaFormfirst" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalTibaErrorFormFirst"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaTibaFormfirst">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaTibaAddEditFormFirst" id="kepalaTibaFormfirst" placeholder="Kepala Pada Tiba Di Lokasi">
                                        <div class="invalid-feedback kepalaTibaErrorFormFirst"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                <h3 class="card-title" style="font-weight: 900;margin-top:-25px;padding: 0 5px;background-color:#FFF;">II</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="berangkatdariFormsecond">Berangkat Dari</label>
                                        <input type="text" class="form-control" name="berangkatAddEditFormSecond" id="berangkatdariFormsecond" placeholder="Berangkat Dari">
                                        <div class="invalid-feedback berangkatErrorFormSecond"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuanFormsecond">Tujuan Instansi</label>
                                        <input type="text" class="form-control" name="tujuanAddEditFormSecond" id="tujuanFormsecond" placeholder="tujuan Dari">
                                        <div class="invalid-feedback tujuanErrorFormSecond"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalBerangkatFormsecond">Tanggal Berangkat</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalBerangkatAddEditFormSecond" id="tanggalBerangkatFormsecond" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalBerangkatErrorFormSecond"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaBerangkatFormsecond">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaBerangkatAddEditFormSecond" id="kepalaBerangkatFormsecond" placeholder="Kepala Pada Saat Tiba">
                                        <div class="invalid-feedback kepalaBerangkatErrorFormSecond"></div>
                                    </div>
                                    <hr class="s9" style="margin: 0;">
                                    <div class="form-group">
                                        <label for="tibadiFormsecond">Tiba Di</label>
                                        <input type="text" class="form-control" name="tibadiAddEditSecond" id="tibadiFormsecond" placeholder="Tiba Di">
                                        <div class="invalid-feedback tibadiErrorFormSecond"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalTibaFormsecond">Tanggal Tiba</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalTibaAddEditFormSecond" id="tanggalTibaFormsecond" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalTibaErrorFormSecond"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaTibaFormsecond">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaTibaAddEditFormSecond" id="kepalaTibaFormsecond" placeholder="Kepala Pada Tiba Di Lokasi">
                                        <div class="invalid-feedback kepalaTibaErrorFormSecond"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                <h3 class="card-title" style="font-weight: 900;margin-top:-25px;padding: 0 5px;background-color:#FFF;">III</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="berangkatdariFormthird">Berangkat Dari</label>
                                        <input type="text" class="form-control" name="berangkatAddEditFormThird" id="berangkatdariFormthird" placeholder="Berangkat Dari">
                                        <div class="invalid-feedback berangkatErrorFormThird"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuanFormthird">Tujuan Instansi</label>
                                        <input type="text" class="form-control" name="tujuanAddEditFormThird" id="tujuanFormthird" placeholder="tujuan Dari">
                                        <div class="invalid-feedback tujuanErrorFormThird"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalBerangkatFormthird">Tanggal Berangkat</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalBerangkatAddEditFormThird" id="tanggalBerangkatFormthird" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalBerangkatErrorFormThird"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaBerangkatFormthird">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaBerangkatAddEditFormThird" id="kepalaBerangkatFormthird" placeholder="Kepala Pada Saat Tiba">
                                        <div class="invalid-feedback kepalaBerangkatErrorFormThird"></div>
                                    </div>
                                    <hr class="s9" style="margin: 0;">
                                    <div class="form-group">
                                        <label for="tibadiFormthird">Tiba Di</label>
                                        <input type="text" class="form-control" name="tibadiAddEditThird" id="tibadiFormthird" placeholder="Tiba Di">
                                        <div class="invalid-feedback tibadiErrorFormThird"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalTibaFormthird">Tanggal Tiba</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalTibaAddEditFormThird" id="tanggalTibaFormthird" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalTibaErrorFormThird"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaTibaFormthird">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaTibaAddEditFormThird" id="kepalaTibaFormthird" placeholder="Kepala Pada Tiba Di Lokasi">
                                        <div class="invalid-feedback kepalaTibaErrorFormThird"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                <h3 class="card-title" style="font-weight: 900;margin-top:-25px;padding: 0 5px;background-color:#FFF;">IV</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="berangkatdariFormfourth">Berangkat Dari</label>
                                        <input type="text" class="form-control" name="berangkatAddEditFormFourth" id="berangkatdariFormfourth" placeholder="Berangkat Dari">
                                        <div class="invalid-feedback berangkatErrorFormFourth"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuanFormfourth">Tujuan Instansi</label>
                                        <input type="text" class="form-control" name="tujuanAddEditFormFourth" id="tujuanFormfourth" placeholder="tujuan Dari">
                                        <div class="invalid-feedback tujuanErrorFormFourth"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalBerangkatFormfourth">Tanggal Berangkat</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalBerangkatAddEditFormFourth" id="tanggalBerangkatFormfourth" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalBerangkatErrorFormFourth"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaBerangkatFormfourth">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaBerangkatAddEditFormFourth" id="kepalaBerangkatFormfourth" placeholder="Kepala Pada Saat Tiba">
                                        <div class="invalid-feedback kepalaBerangkatErrorFormFourth"></div>
                                    </div>
                                    <hr class="s9" style="margin: 0;">
                                    <div class="form-group">
                                        <label for="tibadiFormfourth">Tiba Di</label>
                                        <input type="text" class="form-control" name="tibadiAddEditFourth" id="tibadiFormfourth" placeholder="Tiba Di">
                                        <div class="invalid-feedback tibadiErrorFormFourth"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalTibaFormfourth">Tanggal Tiba</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalTibaAddEditFormFourth" id="tanggalTibaFormfourth" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalTibaErrorFormFourth"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaTibaFormfourth">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaTibaAddEditFormFourth" id="kepalaTibaFormfourth" placeholder="Kepala Pada Tiba Di Lokasi">
                                        <div class="invalid-feedback kepalaTibaErrorFormFourth"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        $('#kendaraanForm').on('select2:select', function(e) {$('#berangkatdariFormfirst').focus();});
        //Form first
        $('#berangkatdariFormfirst').keydown(function(event) {if (event.keyCode == 13) {$('#tujuanFormfirst').focus();}});
        $('#tujuanFormfirst').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalBerangkatFormfirst').focus();}});
        $('#tanggalBerangkatFormfirst').on('apply.daterangepicker', function(ev) {$('#kepalaBerangkatFormfirst').focus();});
        $('#kepalaBerangkatFormfirst').keydown(function(event) {if (event.keyCode == 13) {$('#tibadiFormfirst').focus();}});
        $('#tibadiFormfirst').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalTibaFormfirst').focus();}});
        $('#tanggalTibaFormfirst').on('apply.daterangepicker', function(ev) {$('#kepalaTibaFormfirst').focus();});
        $('#kepalaTibaFormFirst').keydown(function(event) {if (event.keyCode == 13) {$('#berangkatdariFormsecond').focus();}});
        //Form second
        $('#berangkatdariFormsecond').keydown(function(event) {if (event.keyCode == 13) {$('#tujuanFormsecond').focus();}});
        $('#tujuanFormsecond').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalBerangkatFormsecond').focus();}});
        $('#tanggalBerangkatFormsecond').on('apply.daterangepicker', function(ev) {$('#kepalaBerangkatFormsecond').focus();});
        $('#kepalaBerangkatFormsecond').keydown(function(event) {if (event.keyCode == 13) {$('#tibadiFormsecond').focus();}});
        $('#tibadiFormsecond').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalTibaFormsecond').focus();}});
        $('#tanggalTibaFormsecond').on('apply.daterangepicker', function(ev) {$('#kepalaTibaFormsecond').focus();});
        $('#kepalaTibaFormsecond').keydown(function(event) {if (event.keyCode == 13) {$('#berangkatdariFormthird').focus();}});
        //Form third
        $('#berangkatdariFormthird').keydown(function(event) {if (event.keyCode == 13) {$('#tujuanFormthird').focus();}});
        $('#tujuanFormthird').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalBerangkatFormthird').focus();}});
        $('#tanggalBerangkatFormthird').on('apply.daterangepicker', function(ev) {$('#kepalaBerangkatFormthird').focus();});
        $('#kepalaBerangkatFormthird').keydown(function(event) {if (event.keyCode == 13) {$('#tibadiFormthird').focus();}});
        $('#tibadiFormthird').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalTibaFormthird').focus();}});
        $('#tanggalTibaFormthird').on('apply.daterangepicker', function(ev) {$('#kepalaTibaFormthird').focus();});
        $('#kepalaTibaFormthird').keydown(function(event) {if (event.keyCode == 13) {$('#berangkatdariFormfourth').focus();}});
        //Form third
        $('#berangkatdariFormfourth').keydown(function(event) {if (event.keyCode == 13) {$('#tujuanFormfourth').focus();}});
        $('#tujuanFormfourth').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalBerangkatFormfourth').focus();}});
        $('#tanggalBerangkatFormfourth').on('apply.daterangepicker', function(ev) {$('#kepalaBerangkatFormfourth').focus();});
        $('#kepalaBerangkatFormfourth').keydown(function(event) {if (event.keyCode == 13) {$('#tibadiFormfourth').focus();}});
        $('#tibadiFormfourth').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalTibaFormfourth').focus();}});
        $('#tanggalTibaFormfourth').on('apply.daterangepicker', function(ev) {$('#kepalaTibaFormfourth').focus();});
        $('#kepalaTibaFormfourth').keydown(function(event) {if (event.keyCode == 13) {$('#submit-spd').focus();}});

        newupdate();realupdate();

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
            //Form first
            $("#berangkatdariFormfirst").empty();$("#berangkatdariFormfirst").removeClass('is-valid');$("#berangkatdariFormfirst").removeClass('is-invalid');
            $("#tujuanFormfirst").empty();$("#tujuanFormfirst").removeClass('is-valid');$("#tujuanFormfirst").removeClass('is-invalid');
            $("#tanggalBerangkatFormfirst").empty();$("#tanggalBerangkatFormfirst").removeClass('is-valid');$("#tanggalBerangkatFormfirst").removeClass('is-invalid');
            $("#kepalaBerangkatFormfirst").empty();$("#kepalaBerangkatFormfirst").removeClass('is-valid');$("#kepalaBerangkatFormfirst").removeClass('is-invalid');
            $("#tibadiFormfirst").empty();$("#tibadiFormfirst").removeClass('is-valid');$("#tibadiFormfirst").removeClass('is-invalid');
            $("#tanggalTibaFormfirst").empty();$("#tanggalTibaFormfirst").removeClass('is-valid');$("#tanggalTibaFormfirst").removeClass('is-invalid');
            $("#kepalaTibaFormfirst").empty();$("#kepalaTibaFormfirst").removeClass('is-valid');$("#kepalaTibaFormfirst").removeClass('is-invalid');
            //Form second
            $("#berangkatdariFormsecond").empty();$("#berangkatdariFormsecond").removeClass('is-valid');$("#berangkatdariFormsecond").removeClass('is-invalid');
            $("#tujuanFormsecond").empty();$("#tujuanFormsecond").removeClass('is-valid');$("#tujuanFormsecond").removeClass('is-invalid');
            $("#tanggalBerangkatFormsecond").empty();$("#tanggalBerangkatFormsecond").removeClass('is-valid');$("#tanggalBerangkatFormsecond").removeClass('is-invalid');
            $("#kepalaBerangkatFormsecond").empty();$("#kepalaBerangkatFormsecond").removeClass('is-valid');$("#kepalaBerangkatFormsecond").removeClass('is-invalid');
            $("#tibadiFormsecond").empty();$("#tibadiFormsecond").removeClass('is-valid');$("#tibadiFormsecond").removeClass('is-invalid');
            $("#tanggalTibaFormsecond").empty();$("#tanggalTibaFormsecond").removeClass('is-valid');$("#tanggalTibaFormsecond").removeClass('is-invalid');
            $("#kepalaTibaFormsecond").empty();$("#kepalaTibaFormsecond").removeClass('is-valid');$("#kepalaTibaFormsecond").removeClass('is-invalid');
            //Form third
            $("#berangkatdariFormthird").empty();$("#berangkatdariFormthird").removeClass('is-valid');$("#berangkatdariFormthird").removeClass('is-invalid');
            $("#tujuanFormthird").empty();$("#tujuanFormthird").removeClass('is-valid');$("#tujuanFormthird").removeClass('is-invalid');
            $("#tanggalBerangkatFormthird").empty();$("#tanggalBerangkatFormthird").removeClass('is-valid');$("#tanggalBerangkatFormthird").removeClass('is-invalid');
            $("#kepalaBerangkatFormthird").empty();$("#kepalaBerangkatFormthird").removeClass('is-valid');$("#kepalaBerangkatFormthird").removeClass('is-invalid');
            $("#tibadiFormthird").empty();$("#tibadiFormthird").removeClass('is-valid');$("#tibadiFormthird").removeClass('is-invalid');
            $("#tanggalTibaFormthird").empty();$("#tanggalTibaFormthird").removeClass('is-valid');$("#tanggalTibaFormthird").removeClass('is-invalid');
            $("#kepalaTibaFormthird").empty();$("#kepalaTibaFormthird").removeClass('is-valid');$("#kepalaTibaFormthird").removeClass('is-invalid');
            //Form fourth
            $("#berangkatdariFormfourth").empty();$("#berangkatdariFormfourth").removeClass('is-valid');$("#berangkatdariFormfourth").removeClass('is-invalid');
            $("#tujuanFormfourth").empty();$("#tujuanFormfourth").removeClass('is-valid');$("#tujuanFormfourth").removeClass('is-invalid');
            $("#tanggalBerangkatFormfourth").empty();$("#tanggalBerangkatFormfourth").removeClass('is-valid');$("#tanggalBerangkatFormfourth").removeClass('is-invalid');
            $("#kepalaBerangkatFormfourth").empty();$("#kepalaBerangkatFormfourth").removeClass('is-valid');$("#kepalaBerangkatFormfourth").removeClass('is-invalid');
            $("#tibadiFormfourth").empty();$("#tibadiFormfourth").removeClass('is-valid');$("#tibadiFormfourth").removeClass('is-invalid');
            $("#tanggalTibaFormfourth").empty();$("#tanggalTibaFormfourth").removeClass('is-valid');$("#tanggalTibaFormfourth").removeClass('is-invalid');
            $("#kepalaTibaFormfourth").empty();$("#kepalaTibaFormfourth").removeClass('is-valid');$("#kepalaTibaFormfourth").removeClass('is-invalid');

        }

        $("#tingkatBiayaForm").select2({theme: 'bootstrap4'});$("#kendaraanForm").select2({theme: 'bootstrap4'});
        //Form first
        $('#tanggalBerangkatFormfirst').daterangepicker({singleDatePicker: true,minDate: moment(),locale: {format: 'YYYY-MM-DD',firstDay: 1}});
        $('#tanggalTibaFormfirst').daterangepicker({singleDatePicker: true,minDate: moment(),locale: {format: 'YYYY-MM-DD',firstDay: 1}});
        //Form second
        $('#tanggalBerangkatFormsecond').daterangepicker({singleDatePicker: true,minDate: moment(),locale: {format: 'YYYY-MM-DD',firstDay: 1}});
        $('#tanggalTibaFormsecond').daterangepicker({singleDatePicker: true,minDate: moment(),locale: {format: 'YYYY-MM-DD',firstDay: 1}});
        //Form third
        $('#tanggalBerangkatFormthird').daterangepicker({singleDatePicker: true,minDate: moment(),locale: {format: 'YYYY-MM-DD',firstDay: 1}});
        $('#tanggalTibaFormthird').daterangepicker({singleDatePicker: true,minDate: moment(),locale: {format: 'YYYY-MM-DD',firstDay: 1}});
        //Form fourth
        $('#tanggalBerangkatFormfourth').daterangepicker({singleDatePicker: true,minDate: moment(),locale: {format: 'YYYY-MM-DD',firstDay: 1}});
        $('#tanggalTibaFormfourth').daterangepicker({singleDatePicker: true,minDate: moment(),locale: {format: 'YYYY-MM-DD',firstDay: 1}});

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Spd/getPegawai') ?>';
        // $("#pegawaiAddEditForm option:selected").text();
        $("#pegawaiForm").select2({
            // var pegawai = $('#pegawaiAddEditForm :selected').val();
            // console.log(pegawai);
            minimumResultsForSearch: Infinity,
            theme: 'bootstrap4',
            placeholder: '--- Cari Data Pegawai ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()}},
                processResults: function(response) {$('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data,}},
                cache: true
            }
        });

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            if ($('#methodPage').val() === 'New') {var url_destination = "<?= base_url('Admin/Spd/Create') ?>";
        } else {var url_destination = "<?= base_url('Admin/Spd/Update') ?>";}
            console.log($(this).serialize());
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
                            // console.log(element);
                            // console.log(data.error[key].length);
                        });
                    }
                    if (data.success == true) {
                        clearform();
                        let timerInterval
                        swalWithBootstrapButtons.fire({
                            icon: 'success',title: 'Berhasil Memasukkan Data',
                            html: '<b>Otomatis Ke Table SPD!</b><br>' +
                                'Tekan No Jika Ingin Memasukkan Data Yang Lainnya',
                            timer: 3500,timerProgressBar: true,
                            confirmButtonText: 'Ya, Kembali!',
                        }).then((result) => {
                            if (result.isConfirmed) { window.location.href = data.redirect;
                            } else if (result.dismiss === Swal.DismissReason.timer) {window.location.href = data.redirect;}
                        })
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            $("#" + key + 'Form').addClass('is-invalid');$("." + key + "ErrorForm").html(data.msg[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control');element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        if (data.msg != "") {
                            toastr.options = {"positionClass": "toast-top-right","closeButton": true};
                            toastr["warning"](data.error, "Informasi");
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
            });
            return false;
        })

        function newupdate() {
            if ($('#methodPage').val() === "New" && $('#hiddenIDPage').val() != "") {
                var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Admin/Spd/new_update') ?>";
                $.ajax({
                    url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        // console.log(data);
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        $('#kodeForm').val(data.kode);
                        $("#diperintahForm").val(data.pegawai.nama);
                        $('#untukForm').val(data.untuk);
                        $("#instansiForm").val(data.instansi.nama_instansi);
                        $('#startForm').val(data.awal);
                        $('#endForm').val(data.akhir);
                        $('#lamaForm').val(data.lama);
                        $('#rekeningForm').val(data.rekening.nomer_rekening);
                        $('#submit-spd').html('<i class="fas fa-save"></i>&ensp;Submit');
                    },error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
            }
        }

        function realupdate() {
            if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {
                var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Admin/Spd/real_update') ?>";
                $.ajax({
                    url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data.json);
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
                        $('#startForm').val(data.awal);
                        $('#endForm').val(data.akhir);
                        $('#lamaForm').val(data.lama);
                        $('#keteranganForm').val(data.keterangan);
                        $('#rekeningForm').val(data.rekening.nomer_rekening);
                        for (var urutan in data.json) { //json
                            // console.log(urutan);
                            var obj = data.json[urutan];
                            for (var prop in obj) {
                                $('#'+ prop +'Form' + urutan).val(obj[prop]);
                            }
                        }

                        $('#submit-spd').html('<i class="fas fa-save"></i>&ensp;Update');
                    },error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
            }
        }
    })
</script>
<?= $this->endSection() ?>