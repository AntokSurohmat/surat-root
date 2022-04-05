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
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title" style="font-weight: 900;margin-top:-25px;padding: 0 5px;background-color:#FFF;">I</h3>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                    <input type="hidden" id="methodPage" value="<?= $method ?>" />
                                    <input type="hidden" name="hiddenID" id="hiddenIDPage" value="<?= $hiddenID ?>" />

                                    <div class="form-group">
                                        <label for="tibadiFormfirst">Tiba Di</label>
                                        <input type="text" class="form-control" name="tibadiAddEditForm[]" id="tibadiFormfirst" placeholder="Tiba Di">
                                        <div class="invalid-feedback tibadiErrorFormFirst"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggaltibaFormfirst">Tanggal Tiba</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalTibaAddEditForm[]" id="tanggaltibaFormfirst" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalTibaErrorFormFirst"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalatibaFormfirst">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaTibaAddEditForm[]" id="kepalatibaFormfirst" placeholder="Kepala Pada Tiba Di Lokasi">
                                        <div class="invalid-feedback kepalaTibaErrorFormFirst"></div>
                                    </div>
                                    <hr class="s9" style="margin: 0;">
                                    <div class="form-group">
                                        <label for="berangkatdariFormfirst">Berangkat Dari</label>
                                        <input type="text" class="form-control" name="berangkatAddEditForm[]" id="berangkatdariFormfirst" placeholder="Berangkat Dari">
                                        <div class="invalid-feedback berangkatErrorFormFirst"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuanFormfirst">Tujuan Instansi</label>
                                        <input type="text" class="form-control" name="tujuanAddEditForm[]" id="tujuanFormfirst" placeholder="tujuan Dari">
                                        <div class="invalid-feedback tujuanErrorFormFirst"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalberangkatFormfirst">Tanggal Berangkat</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalBerangkatAddEditForm[]" id="tanggalberangkatFormfirst" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalBerangkatErrorFormFirst"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaberangkatFormfirst">Kepala Saat Berangkat</label>
                                        <input type="text" class="form-control" name="kepalaBerangkatAddEditForm[]" id="kepalaberangkatFormfirst" placeholder="Kepala Pada Saat Tiba">
                                        <div class="invalid-feedback kepalaBerangkatErrorFormFirst"></div>
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
                                        <label for="tibadiFormsecond">Tiba Di</label>
                                        <input type="text" class="form-control" name="tibadiAddEditForm[]" id="tibadiFormsecond" placeholder="Tiba Di">
                                        <div class="invalid-feedback tibadiErrorFormSecond"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggaltibaFormsecond">Tanggal Tiba</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalTibaAddEditForm[]" id="tanggaltibaFormsecond" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalTibaErrorFormSecond"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalatibaFormsecond">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaTibaAddEditForm[]" id="kepalatibaFormsecond" placeholder="Kepala Pada Tiba Di Lokasi">
                                        <div class="invalid-feedback kepalaTibaErrorFormSecond"></div>
                                    </div>
                                    <hr class="s9" style="margin: 0;">
                                    <div class="form-group">
                                        <label for="berangkatdariFormsecond">Berangkat Dari</label>
                                        <input type="text" class="form-control" name="berangkatAddEditForm[]" id="berangkatdariFormsecond" placeholder="Berangkat Dari">
                                        <div class="invalid-feedback berangkatErrorFormSecond"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuanFormsecond">Tujuan Instansi</label>
                                        <input type="text" class="form-control" name="tujuanAddEditForm[]" id="tujuanFormsecond" placeholder="tujuan Dari">
                                        <div class="invalid-feedback tujuanErrorFormSecond"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalberangkatFormsecond">Tanggal Berangkat</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalBerangkatAddEditForm[]" id="tanggalberangkatFormsecond" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalBerangkatErrorFormSecond"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaberangkatFormsecond">Kepala Saat Berangkat</label>
                                        <input type="text" class="form-control" name="kepalaBerangkatAddEditForm[]" id="kepalaberangkatFormsecond" placeholder="Kepala Pada Saat Tiba">
                                        <div class="invalid-feedback kepalaBerangkatErrorFormSecond"></div>
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
                                        <label for="tibadiFormthird">Tiba Di</label>
                                        <input type="text" class="form-control" name="tibadiAddEditForm[]" id="tibadiFormthird" placeholder="Tiba Di">
                                        <div class="invalid-feedback tibadiErrorFormThird"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggaltibaFormthird">Tanggal Tiba</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalTibaAddEditForm[]" id="tanggaltibaFormthird" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalTibaErrorFormThird"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalatibaFormthird">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaTibaAddEditForm[]" id="kepalatibaFormthird" placeholder="Kepala Pada Tiba Di Lokasi">
                                        <div class="invalid-feedback kepalaTibaErrorFormThird"></div>
                                    </div>
                                    <hr class="s9" style="margin: 0;">
                                    <div class="form-group">
                                        <label for="berangkatdariFormthird">Berangkat Dari</label>
                                        <input type="text" class="form-control" name="berangkatAddEditForm[]" id="berangkatdariFormthird" placeholder="Berangkat Dari">
                                        <div class="invalid-feedback berangkatErrorFormThird"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuanFormthird">Tujuan Instansi</label>
                                        <input type="text" class="form-control" name="tujuanAddEditForm[]" id="tujuanFormthird" placeholder="tujuan Dari">
                                        <div class="invalid-feedback tujuanErrorFormThird"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalberangkatFormthird">Tanggal Berangkat</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalBerangkatAddEditForm[]" id="tanggalberangkatFormthird" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalBerangkatErrorFormThird"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaberangkatFormthird">Kepala Saat Berangkat</label>
                                        <input type="text" class="form-control" name="kepalaBerangkatAddEditForm[]" id="kepalaberangkatFormthird" placeholder="Kepala Pada Saat Tiba">
                                        <div class="invalid-feedback kepalaBerangkatErrorFormThird"></div>
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
                                        <label for="tibadiFormfourth">Tiba Di</label>
                                        <input type="text" class="form-control" name="tibadiAddEditForm[]" id="tibadiFormfourth" placeholder="Tiba Di">
                                        <div class="invalid-feedback tibadiErrorFormFourth"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggaltibaFormfourth">Tanggal Tiba</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalTibaAddEditForm[]" id="tanggaltibaFormfourth" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalTibaErrorFormFourth"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalatibaFormfourth">Kepala Saat Tiba</label>
                                        <input type="text" class="form-control" name="kepalaTibaAddEditForm[]" id="kepalatibaFormfourth" placeholder="Kepala Pada Tiba Di Lokasi">
                                        <div class="invalid-feedback kepalaTibaErrorFormFourth"></div>
                                    </div>
                                    <hr class="s9" style="margin: 0;">
                                    <div class="form-group">
                                        <label for="berangkatdariFormfourth">Berangkat Dari</label>
                                        <input type="text" class="form-control" name="berangkatAddEditForm[]" id="berangkatdariFormfourth" placeholder="Berangkat Dari">
                                        <div class="invalid-feedback berangkatErrorFormFourth"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tujuanFormfourth">Tujuan Instansi</label>
                                        <input type="text" class="form-control" name="tujuanAddEditForm[]" id="tujuanFormfourth" placeholder="tujuan Dari">
                                        <div class="invalid-feedback tujuanErrorFormFourth"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tanggalberangkatFormfourth">Tanggal Berangkat</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="tanggalBerangkatAddEditForm[]" id="tanggalberangkatFormfourth" placeholder="Dari Tanggal" />
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback tanggalBerangkatErrorFormFourth"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="kepalaberangkatFormfourth">Kepala Saat Berangkat</label>
                                        <input type="text" class="form-control" name="kepalaBerangkatAddEditForm[]" id="kepalaberangkatFormfourth" placeholder="Kepala Pada Saat Tiba">
                                        <div class="invalid-feedback kepalaBerangkatErrorFormFourth"></div>
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

        //Form first
        $('#tibadiFormfirst').keydown(function(event) {if (event.keyCode == 13) {$('#tanggaltibaFormfirst').focus();}});
        $('#tanggaltibaFormfirst').on('apply.daterangepicker', function(ev) {$('#kepalatibaFormfirst').focus();});
        $('#kepalatibaFormFirst').keydown(function(event) {if (event.keyCode == 13) {$('#berangkatdariFormsecond').focus();}});
        $('#berangkatdariFormfirst').keydown(function(event) {if (event.keyCode == 13) {$('#tujuanFormfirst').focus();}});
        $('#tujuanFormfirst').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalberangkatFormfirst').focus();}});
        $('#tanggalberangkatFormfirst').on('apply.daterangepicker', function(ev) {$('#kepalaberangkatFormfirst').focus();});
        $('#kepalaberangkatFormfirst').keydown(function(event) {if (event.keyCode == 13) {$('#tibadiFormsecond').focus();}});
        //Form second
        $('#tibadiFormsecond').keydown(function(event) {if (event.keyCode == 13) {$('#tanggaltibaFormsecond').focus();}});
        $('#tanggaltibaFormsecond').on('apply.daterangepicker', function(ev) {$('#kepalatibaFormsecond').focus();});
        $('#kepalatibaFormsecond').keydown(function(event) {if (event.keyCode == 13) {$('#berangkatdariFormthird').focus();}});
        $('#berangkatdariFormsecond').keydown(function(event) {if (event.keyCode == 13) {$('#tujuanFormsecond').focus();}});
        $('#tujuanFormsecond').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalberangkatFormsecond').focus();}});
        $('#tanggalberangkatFormsecond').on('apply.daterangepicker', function(ev) {$('#kepalaberangkatFormsecond').focus();});
        $('#kepalaberangkatFormsecond').keydown(function(event) {if (event.keyCode == 13) {$('#tibadiFormthird').focus();}});
        //Form third
        $('#tibadiFormthird').keydown(function(event) {if (event.keyCode == 13) {$('#tanggaltibaFormthird').focus();}});
        $('#tanggaltibaFormthird').on('apply.daterangepicker', function(ev) {$('#kepalatibaFormthird').focus();});
        $('#kepalatibaFormthird').keydown(function(event) {if (event.keyCode == 13) {$('#berangkatdariFormfourth').focus();}});
        $('#berangkatdariFormthird').keydown(function(event) {if (event.keyCode == 13) {$('#tujuanFormthird').focus();}});
        $('#tujuanFormthird').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalberangkatFormthird').focus();}});
        $('#tanggalberangkatFormthird').on('apply.daterangepicker', function(ev) {$('#kepalaberangkatFormthird').focus();});
        $('#kepalaberangkatFormthird').keydown(function(event) {if (event.keyCode == 13) {$('#tibadiFormfourth').focus();}});
        //Form third
        $('#tibadiFormfourth').keydown(function(event) {if (event.keyCode == 13) {$('#tanggaltibaFormfourth').focus();}});
        $('#tanggaltibaFormfourth').on('apply.daterangepicker', function(ev) {$('#kepalatibaFormfourth').focus();});
        $('#kepalatibaFormfourth').keydown(function(event) {if (event.keyCode == 13) {$('#berangkatdariFormfourth').focus();}});
        $('#berangkatdariFormfourth').keydown(function(event) {if (event.keyCode == 13) {$('#tujuanFormfourth').focus();}});
        $('#tujuanFormfourth').keydown(function(event) {if (event.keyCode == 13) {$('#tanggalberangkatFormfourth').focus();}});
        $('#tanggalberangkatFormfourth').on('apply.daterangepicker', function(ev) {$('#kepalaberangkatFormfourth').focus();});
        $('#kepalaberangkatFormfourth').keydown(function(event) {if (event.keyCode == 13) {$('#tibadiFormfourth').focus();}});

        $('#kepalaberangkatFormfourth').keydown(function(event) {if (event.keyCode == 13) {$('#submit-spd').focus();}});

        realupdate();

        function clearform() {
            $('#form-addedit')[0].reset();
            //Form first
            $("#tibadiFormfirst").empty();$("#tibadiFormfirst").removeClass('is-valid');$("#tibadiFormfirst").removeClass('is-invalid');
            $("#tanggaltibaFormfirst").empty();$("#tanggaltibaFormfirst").removeClass('is-valid');$("#tanggaltibaFormfirst").removeClass('is-invalid');
            $("#kepalatibaFormfirst").empty();$("#kepalatibaFormfirst").removeClass('is-valid');$("#kepalatibaFormfirst").removeClass('is-invalid');
            $("#berangkatdariFormfirst").empty();$("#berangkatdariFormfirst").removeClass('is-valid');$("#berangkatdariFormfirst").removeClass('is-invalid');
            $("#tujuanFormfirst").empty();$("#tujuanFormfirst").removeClass('is-valid');$("#tujuanFormfirst").removeClass('is-invalid');
            $("#tanggalberangkatFormfirst").empty();$("#tanggalberangkatFormfirst").removeClass('is-valid');$("#tanggalberangkatFormfirst").removeClass('is-invalid');
            $("#kepalaberangkatFormfirst").empty();$("#kepalaberangkatFormfirst").removeClass('is-valid');$("#kepalaberangkatFormfirst").removeClass('is-invalid');
            //Form second
            $("#tibadiFormsecond").empty();$("#tibadiFormsecond").removeClass('is-valid');$("#tibadiFormsecond").removeClass('is-invalid');
            $("#tanggaltibaFormsecond").empty();$("#tanggaltibaFormsecond").removeClass('is-valid');$("#tanggaltibaFormsecond").removeClass('is-invalid');
            $("#kepalatibaFormsecond").empty();$("#kepalatibaFormsecond").removeClass('is-valid');$("#kepalatibaFormsecond").removeClass('is-invalid');
            $("#berangkatdariFormsecond").empty();$("#berangkatdariFormsecond").removeClass('is-valid');$("#berangkatdariFormsecond").removeClass('is-invalid');
            $("#tujuanFormsecond").empty();$("#tujuanFormsecond").removeClass('is-valid');$("#tujuanFormsecond").removeClass('is-invalid');
            $("#tanggalberangkatFormsecond").empty();$("#tanggalberangkatFormsecond").removeClass('is-valid');$("#tanggalberangkatFormsecond").removeClass('is-invalid');
            $("#kepalaberangkatFormsecond").empty();$("#kepalaberangkatFormsecond").removeClass('is-valid');$("#kepalaberangkatFormsecond").removeClass('is-invalid');
            //Form third
            $("#tibadiFormthird").empty();$("#tibadiFormthird").removeClass('is-valid');$("#tibadiFormthird").removeClass('is-invalid');
            $("#tanggaltibaFormthird").empty();$("#tanggaltibaFormthird").removeClass('is-valid');$("#tanggaltibaFormthird").removeClass('is-invalid');
            $("#kepalatibaFormthird").empty();$("#kepalatibaFormthird").removeClass('is-valid');$("#kepalatibaFormthird").removeClass('is-invalid');
            $("#berangkatdariFormthird").empty();$("#berangkatdariFormthird").removeClass('is-valid');$("#berangkatdariFormthird").removeClass('is-invalid');
            $("#tujuanFormthird").empty();$("#tujuanFormthird").removeClass('is-valid');$("#tujuanFormthird").removeClass('is-invalid');
            $("#tanggalberangkatFormthird").empty();$("#tanggalberangkatFormthird").removeClass('is-valid');$("#tanggalberangkatFormthird").removeClass('is-invalid');
            $("#kepalaberangkatFormthird").empty();$("#kepalaberangkatFormthird").removeClass('is-valid');$("#kepalaberangkatFormthird").removeClass('is-invalid');
            //Form fourth
            $("#tibadiFormfourth").empty();$("#tibadiFormfourth").removeClass('is-valid');$("#tibadiFormfourth").removeClass('is-invalid');
            $("#tanggaltibaFormfourth").empty();$("#tanggaltibaFormfourth").removeClass('is-valid');$("#tanggaltibaFormfourth").removeClass('is-invalid');
            $("#kepalatibaFormfourth").empty();$("#kepalatibaFormfourth").removeClass('is-valid');$("#kepalatibaFormfourth").removeClass('is-invalid');
            $("#berangkatdariFormfourth").empty();$("#berangkatdariFormfourth").removeClass('is-valid');$("#berangkatdariFormfourth").removeClass('is-invalid');
            $("#tujuanFormfourth").empty();$("#tujuanFormfourth").removeClass('is-valid');$("#tujuanFormfourth").removeClass('is-invalid');
            $("#tanggalberangkatFormfourth").empty();$("#tanggalberangkatFormfourth").removeClass('is-valid');$("#tanggalberangkatFormfourth").removeClass('is-invalid');
            $("#kepalaberangkatFormfourth").empty();$("#kepalaberangkatFormfourth").removeClass('is-valid');$("#kepalaberangkatFormfourth").removeClass('is-invalid');

        }

        //Form first
        $('#tanggaltibaFormfirst').daterangepicker({singleDatePicker: true, showDropdowns: true, autoUpdateInput: false, locale: {cancelLabel: 'Clear', format: 'DD/MM/YYYY'}});
        $('#tanggaltibaFormfirst').on('apply.daterangepicker', function(ev, picker) {$(this).val(picker.startDate.format('DD/MM/YYYY'));});
        $('#tanggalberangkatFormfirst').daterangepicker({singleDatePicker: true, showDropdowns: true, autoUpdateInput: false,startDate: moment().add(1, 'days'), locale: {cancelLabel: 'Clear', format: 'DD/MM/YYYY'}});
        $('#tanggalberangkatFormfirst').on('apply.daterangepicker', function(ev, picker) {$(this).val(picker.startDate.format('DD/MM/YYYY'));});
        //Form second
        $('#tanggaltibaFormsecond').daterangepicker({singleDatePicker: true, showDropdowns: true, autoUpdateInput: false, locale: {cancelLabel: 'Clear', format: 'DD/MM/YYYY'}});
        $('#tanggaltibaFormsecond').on('apply.daterangepicker', function(ev, picker) { $(this).val(picker.startDate.format('DD/MM/YYYY'));});
        $('#tanggalberangkatFormsecond').daterangepicker({singleDatePicker: true, showDropdowns: true, autoUpdateInput: false, startDate: moment().add(1, 'days'), locale: {cancelLabel: 'Clear', format: 'DD/MM/YYYY'}});
        $('#tanggalberangkatFormsecond').on('apply.daterangepicker', function(ev, picker) {$(this).val(picker.startDate.format('DD/MM/YYYY'));});
        //Form third
        $('#tanggaltibaFormthird').daterangepicker({singleDatePicker: true, showDropdowns: true, autoUpdateInput: false, locale: {cancelLabel: 'Clear', format: 'DD/MM/YYYY'}});
        $('#tanggaltibaFormthird').on('apply.daterangepicker', function(ev, picker) {$(this).val(picker.startDate.format('DD/MM/YYYY'));});
        $('#tanggalberangkatFormthird').daterangepicker({singleDatePicker: true, showDropdowns: true, autoUpdateInput: false, startDate: moment().add(1, 'days'), locale: {cancelLabel: 'Clear', format: 'DD/MM/YYYY'}});
        $('#tanggalberangkatFormthird').on('apply.daterangepicker', function(ev, picker) {$(this).val(picker.startDate.format('DD/MM/YYYY'));});
        //Form fourth
        $('#tanggaltibaFormfourth').daterangepicker({singleDatePicker: true, showDropdowns: true, autoUpdateInput: false, locale: {cancelLabel: 'Clear', format: 'DD/MM/YYYY'}});
        $('#tanggaltibaFormfourth').on('apply.daterangepicker', function(ev, picker) {$(this).val(picker.startDate.format('DD/MM/YYYY'));});
        $('#tanggalberangkatFormfourth').daterangepicker({singleDatePicker: true, showDropdowns: true, autoUpdateInput: false, startDate: moment().add(1, 'days'), locale: {cancelLabel: 'Clear', format: 'DD/MM/YYYY'}});
        $('#tanggalberangkatFormfourth').on('apply.daterangepicker', function(ev, picker) {$(this).val(picker.startDate.format('DD/MM/YYYY'));});


        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Spd/update_belakang') ?>";
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
                        console.log(data.error);
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'Form').addClass('is-invalid');$("." + key + "ErrorForm").html(data.error[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control');element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
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


        function realupdate() {
            if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {
                var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Admin/Spd/real_update') ?>";
                $.ajax({
                    url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        // console.log(data.json);
                        $('#submit-spd').removeClass("btn-success");
                        $('#submit-spd').addClass("btn-warning text-white");
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        var u_names = new Array("first","second","third","fourth");
                        for (var urutan in data.json) { //json
                            // console.log(urutan);
                            var obj = data.json[urutan];
                            for (var prop in obj) {
                                // console.log(prop + " = " + obj[prop] + ' '+ urutan);
                                $('#'+ prop +'Form' + u_names[urutan]).val(obj[prop]);

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
