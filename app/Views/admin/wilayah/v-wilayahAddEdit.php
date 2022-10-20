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
                                                <input type="number" name="kodeAddEditForm" class="form-control" id="kodeForm" placeholder="Kode Wilayah" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" autofocus />
                                                <div class="invalid-feedback kodeErrorForm"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-default" data-rel="tooltip" data-placement="top" data-container=".content" title="Generate kode" id="generate-kode" > <i class="fa fa-retweet" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="provinsiForm" class="col-sm-3 col-form-label">Provinsi</label>
                                            <div class="col-sm-7">
                                                <select name="provinsiAddEditForm" id="provinsiForm" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari Provinsi ---</option>
                                                </select>
                                                <div class="invalid-feedback provinsiErrorForm"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-info" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Provinsi" id="add-prov"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kabupatenForm" class="col-sm-3 col-form-label">Kabupaten/Kota</label>
                                            <div class="col-sm-7">
                                                <select name="kabupatenAddEditForm" id="kabupatenForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Provinsi Terlebih Dahulu ---</option>
                                                </select>
                                                <div class="invalid-feedback kabupatenErrorForm"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-primary" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Kabupaten" id="add-kab"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kecamatanForm" class="col-sm-3 col-form-label">Kecamatan</label>
                                            <div class="col-sm-7">
                                                <select name="kecamatanAddEditForm" id="kecamatanForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Kabupaten Terlebih Dahulu ---</option>
                                                </select>
                                                <div class="invalid-feedback kecamatanErrorForm"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-success" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Kecamatan" id="add-kec"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="jenisWilayahForm" class="col-sm-3 col-form-label">Jenis Wilayah</label>
                                            <div class="col-sm-7">
                                                <select name="jenisWilayahAddEditForm" id="jenisWilayahForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Kabupaten Terlebih Dahulu ---</option>
                                                </select>
                                                <div class="invalid-feedback jenisWilayahErrorForm"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-danger" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Jenis Wilayah" id="add-jenis"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="zonasiForm" class="col-sm-3 col-form-label">Zonasi</label>
                                            <div class="col-sm-7">
                                                <select name="zonasiAddEditForm" id="zonasiForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Kecamatan Terlebih Dahulu ---</option>
                                                </select>
                                                <div class="invalid-feedback zonasiErrorForm"></div>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-warning" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Zonasi" id="add-zona"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
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
            <div class="modal-dialog modal-lg">
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
                                <label for="kodeModalProv" class="col-sm-3 col-form-label">Kode</label>
                                <div class="col-sm-7">
                                    <input type="number" name="kodeAddEditModalProv" class="form-control" id="kodeModalProv" placeholder="Kode Provinsi" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="2" autofocus />
                                    <div class="invalid-feedback kodeErrorModalProv"></div>
                                </div>
                                <span>
                                    <button type="button" class="btn btn-default" data-rel="tooltip" data-placement="top" data-container=".content" title="Generate kode" id="generate-kodeProv" > <i class="fa fa-retweet" aria-hidden="true"></i> </button>
                                </span>
                            </div>
                            <div class="form-group row">
                                <label for="provinsiModalProv" class="col-sm-3 col-form-label">Nama Provinsi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="provinsiAddEditModalProv" id="provinsiModalProv" placeholder="Nama Provinsi Baru" />
                                    <div class="invalid-feedback provinsiErrorModalProv"></div>
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
            <div class="modal-dialog modal-lg">
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
                                <label for="kodeModalKab" class="col-sm-3 col-form-label">Kode</label>
                                <div class="col-sm-7">
                                    <input type="number" name="kodeAddEditModalKab" class="form-control" id="kodeModalKab" placeholder="Kode Kabupaten" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="4" autofocus />
                                    <div class="invalid-feedback kodeErrorModalKab"></div>
                                </div>
                                <span>
                                    <button type="button" class="btn btn-default" data-rel="tooltip" data-placement="top" data-container=".content" title="Generate kode" id="generate-kodeKab" > <i class="fa fa-retweet" aria-hidden="true"></i> </button>
                                </span>
                            </div>
                            <div class="form-group row">
                                <label for="provinsiModalKab" class="col-sm-3 col-form-label">Provinsi</label>
                                <div class="col-sm-8">
                                    <select name="provinsiAddEditModalKab" id="provinsiModalKab" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Provinsi ---</option>
                                    </select>
                                    <div class="invalid-feedback provinsiErrorModalKab"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kabupatenModalKab" class="col-sm-3 col-form-label">Nama Kota/Kab.</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="kabupatenAddEditModalKab" id="kabupatenModalKab" placeholder="Nama Kabupaten Baru" />
                                    <div class="invalid-feedback kabupatenErrorModalKab"></div>
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
            <div class="modal-dialog modal-lg">
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
                                <label for="kodeModalKec" class="col-sm-3 col-form-label">Kode</label>
                                <div class="col-sm-7">
                                    <input type="number" name="kodeAddEditModalKec" class="form-control" id="kodeModalKec" placeholder="Kode Kecamatan" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="7" autofocus />
                                    <div class="invalid-feedback kodeErrorModalKec"></div>
                                </div>
                                <span>
                                    <button type="button" class="btn btn-default" data-rel="tooltip" data-placement="top" data-container=".content" title="Generate kode" id="generate-kodeKec" > <i class="fa fa-retweet" aria-hidden="true"></i> </button>
                                </span>
                            </div>
                            <div class="form-group row">
                                <label for="provinsiModalKec" class="col-sm-3 col-form-label">Provinsi</label>
                                <div class="col-sm-8">
                                    <select name="provinsiAddEditModalKec" id="provinsiModalKec" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Provinsi ---</option>
                                    </select>
                                    <div class="invalid-feedback provinsiErrorModalKec"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kabupatenModalKec" class="col-sm-3 col-form-label">Kabupaten</label>
                                <div class="col-sm-8">
                                    <select name="kabupatenAddEditModalKec" id="kabupatenModalKec" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Kabupaten ---</option>
                                    </select>
                                    <div class="invalid-feedback kabupatenErrorModalKec"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kecamatanModalKec" class="col-sm-3 col-form-label">Nama kecamatan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="kecamatanAddEditModalKec" id="kecamatanModalKec" placeholder="Nama Kecamatan Baru" />
                                    <div class="invalid-feedback kecamatanErrorModalKec"></div>
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

        <!--add Jenis-->
        <div id="modal-jenis" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AddEditModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Jenis Wilayah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" role="form" id="form-jenis" autocomplete="off" onsubmit="return false">
                        <div class="modal-body">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <input type="hidden" id="method" name="method" value="Jenis" />
                            <div class="form-group row">
                                <label for="kodeModalJenis" class="col-sm-3 col-form-label">Kode</label>
                                <div class="col-sm-7">
                                    <input type="number" name="kodeAddEditModalJenis" class="form-control" id="kodeModalJenis" placeholder="Kode Jenis Wilayah" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" autofocus />
                                    <div class="invalid-feedback kodeErrorModalJenis"></div>
                                </div>
                                <span>
                                    <button type="button" class="btn btn-default" data-rel="tooltip" data-placement="top" data-container=".content" title="Generate kode" id="generate-kodeJenis" > <i class="fa fa-retweet" aria-hidden="true"></i> </button>
                                </span>
                            </div>
                            <div class="form-group row">
                                <label for="provinsiModalJenis" class="col-sm-3 col-form-label">Provinsi</label>
                                <div class="col-sm-8">
                                    <select name="provinsiAddEditModalJenis" id="provinsiModalJenis" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Provinsi ---</option>
                                    </select>
                                    <div class="invalid-feedback provinsiErrorModalJenis"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kabupatenModalJenis" class="col-sm-3 col-form-label">Kabupaten</label>
                                <div class="col-sm-8">
                                    <select name="kabupatenAddEditModalJenis" id="kabupatenModalJenis" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Kabupaten ---</option>
                                    </select>
                                    <div class="invalid-feedback kabupatenErrorModalJenis"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenisWilayahModalJenis" class="col-sm-3 col-form-label">Jenis Wilayah</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="jenisWilayahAddEditModalJenis" id="jenisWilayahModalJenis" placeholder="Nama Jenis Wilayah" />
                                    <div class="invalid-feedback jenisWilayahErrorModalJenis"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="submit" id="submit-btn-jenis" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal Jenis -->

        <!--add Zonasi-->
        <div id="modal-zona" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="AddEditModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Zonasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form-horizontal" role="form" id="form-zona" autocomplete="off" onsubmit="return false">
                        <div class="modal-body">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <input type="hidden" id="method" name="method" value="Zona" />
                            <div class="form-group row">
                                <label for="kodeModalZona" class="col-sm-3 col-form-label">Kode</label>
                                <div class="col-sm-7">
                                    <input type="number" name="kodeAddEditModalZona" class="form-control" id="kodeModalZona" placeholder="Kode Zonasi" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" autofocus />
                                    <div class="invalid-feedback kodeErrorModalZona"></div>
                                </div>
                                <span>
                                    <button type="button" class="btn btn-default" data-rel="tooltip" data-placement="top" data-container=".content" title="Generate kode" id="generate-kodeZona" > <i class="fa fa-retweet" aria-hidden="true"></i> </button>
                                </span>
                            </div>
                            <div class="form-group row">
                                <label for="provinsiModalZona" class="col-sm-3 col-form-label">Provinsi</label>
                                <div class="col-sm-8">
                                    <select name="provinsiAddEditModalZona" id="provinsiModalZona" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Provinsi ---</option>
                                    </select>
                                    <div class="invalid-feedback provinsiErrorModalZona"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kabupatenModalZona" class="col-sm-3 col-form-label">Kabupaten</label>
                                <div class="col-sm-8">
                                    <select name="kabupatenAddEditModalZona" id="kabupatenModalZona" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Kabupaten ---</option>
                                    </select>
                                    <div class="invalid-feedback kabupatenErrorModalZona"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kecamatanModalZona" class="col-sm-3 col-form-label">Kecamatan</label>
                                <div class="col-sm-8">
                                    <select name="kecamatanAddEditModalZona" id="kecamatanModalZona" class="form-control select2bs4" style="width: 100%;">
                                        <option value="">--- Cari Kecamatan ---</option>
                                    </select>
                                    <div class="invalid-feedback kecamatanErrorModalZona"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="zonasiModalZona" class="col-sm-3 col-form-label">Zonasi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="zonasiAddEditModalZona" id="zonasiModalZona" placeholder="Nama Zonasi" />
                                    <div class="invalid-feedback zonasiErrorModalZona"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                            <button type="submit" id="submit-btn-zona" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.modal Zonasi -->


    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {

        // preventDefault to stay in modal when keycode 13
        $('form input').keydown(function(event) {if (event.keyCode == 13) {event.preventDefault();return false;}});

        $('#kodeForm').keydown(function(event){if(event.keyCode == 13){$('#provinsiForm').select2('open');}});
        $('#provinsiForm').on('select2:select', function(e) {$('#kabupatenForm').select2('open');});
        $('#kabupatenForm').on('select2:select', function(e) {$('#kecamatanForm').select2('open');});
        $('#kecamatanForm').on('select2:select', function(e) {$('#jenisWilayahForm').select2('open');});
        $('#jenisWilayahForm').on('select2:select', function(e) {$('#zonasiForm').select2('open');});
        $('#zonasiForm').keydown(function(event) {if (event.keyCode == 13) {$('#submit-wilayah').focus();}});
        update();

        function clearform() {
            $('#form-addedit')[0].reset();
            $("#kodeForm").empty();$("#kodeForm").removeClass('is-valid');$("#kodeForm").removeClass('is-invalid');
            $("#provinsiForm").empty();$("#provinsiForm").removeClass('is-valid');$("#provinsiForm").removeClass('is-invalid');
            $("#kabupatenForm").empty();$("#kabupatenForm").removeClass('is-valid');$("#kabupatenForm").removeClass('is-invalid');
            $("#kecamatanForm").empty();$("#kecamatanForm").removeClass('is-valid');$("#kecamatanForm").removeClass('is-invalid');
            $("#jenisForm").empty();$("#jenisForm").removeClass('is-valid');$("#jenisForm").removeClass('is-invalid');
            $("#zonasiForm").empty();$("#zonasiForm").removeClass('is-valid');$("#zonasiForm").removeClass('is-invalid');
        }

        $('#add-prov').click(function() {
            var option = {backdrop: 'static',keyboard: true};
            $('#modal-prov').modal(option);$('#form-prov')[0].reset();$('#modal-prov').modal('show');
        });
        $('#modal-prov').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#kodeModalProv").empty();$("#kodeModalProv").removeClass('is-valid');$("#kodeModalProv").removeClass('is-invalid');
            $("#provinsiModalProv").empty();$("#provinsiModalProv").removeClass('is-valid');$("#provinsiModalProv").removeClass('is-invalid');
        });
        $('#modal-prov').on('shown.bs.modal', function() {
            $('#kodeModalProv').focus();
            $('#kodeModalProv').keydown(function(event) {if (event.keyCode == 13) {$('#provinsiModalProv').focus();}});
            $('#provinsiModalProv').keydown(function(event) {if (event.keyCode == 13) {$('#submit-btn-prov').focus();}});
        });

        $('#add-kab').click(function() {
            var option = {backdrop: 'static',keyboard: true};
            $('#modal-kab').modal(option);$('#form-kab')[0].reset();$('#modal-kab').modal('show');
        });
        $('#modal-kab').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#kodeModalKab").empty();$("#kodeModalKab").removeClass('is-valid');$("#kodeModalKab").removeClass('is-invalid');
            $("#provinsiModalKab").empty();$("#provinsiModalKab").removeClass('is-valid');$("#provinsiModalKab").removeClass('is-invalid');
            $("#kabupatenModalKab").empty();$("#kabupatenModalKab").removeClass('is-valid');$("#kabupatenModalKab").removeClass('is-invalid');
        });
        $('#modal-kab').on('shown.bs.modal', function() {
            $('#kodeModalKab').focus();
            $('#kodeModalKab').keydown(function(event) {if (event.keyCode == 13) {$('#provinsiModalKab').select2('open');}});
            $('#provinsiModalKab').on('select2:select', function(e) {$('#kabupatenModalKab').focus();});
            $('#kabupatenModalKab').keydown(function(event) {if (event.keyCode == 13) {$('#submit-btn-kab').focus();}});
        });

        $('#add-kec').click(function() {var option = {backdrop: 'static',keyboard: true};
            $('#modal-kec').modal(option);$('#form-kec')[0].reset();$('#modal-kec').modal('show');
        });
        $('#modal-kec').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#kodeModalkec").empty();$("#kodeModalkec").removeClass('is-valid');$("#kodeModalkec").removeClass('is-invalid');
            $("#kabupatenModalKec").empty();$("#kabupatenModalKec").removeClass('is-invalid');$("#kabupatenModalKec").removeClass('is-valid');
            $("#kecamatanModalKec").empty();$("#kecamatanModalKec").removeClass('is-valid');$("#kecamatanModalKec").removeClass('is-invalid');
        });
        $('#modal-kec').on('shown.bs.modal', function() {
            $('#kodeModalKec').focus();
            $('#kodeModalKec').keydown(function(event) {if (event.keyCode == 13) {$('#provinsiModalKec').select2('open');}});
            $('#provinsiModalKec').on('select2:select', function(e) {$('#kabupatenModalKec').select2('open');});
            $('#kabupatenModalKec').on('select2:select', function(e) {$('#kecamatanModalKec').focus();});
            $('#kecamatanModalKec').keydown(function(event) {if (event.keyCode == 13) {$('#submit-btn-kec').focus();}});
        });

        $('#add-jenis').click(function() {
            var option = {backdrop: 'static',keyboard: true};
            $('#modal-jenis').modal(option);$('#form-jenis')[0].reset();$('#modal-jenis').modal('show');
        });
        $('#modal-jenis').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#kodeModalJenis").empty();$("#kodeModalJenis").removeClass('is-valid');$("#kodeModalJenis").removeClass('is-invalid');
            $("#provinsiModalJenis").empty();$("#provinsiModalJenis").removeClass('is-valid');$("#provinsiModalJenis").removeClass('is-invalid');
            $("#kabupatenModalJenis").empty();$("#kabupatenModalJenis").removeClass('is-invalid');$("#kabupatenModalJenis").removeClass('is-valid');
            $("#jenisWilayahModalJenis").empty();$("#jenisWilayahModalJenis").removeClass('is-valid');$("#jenisWilayahModalJenis").removeClass('is-invalid');
        });
        $('#modal-jenis').on('shown.bs.modal', function() {
            $('#kodeModalJenis').focus();
            $('#kodeModalJenis').keydown(function(event) {if (event.keyCode == 13) {$('#provinsiModalJenis').select2('open');}});
            $('#provinsiModalJenis').on('select2:select', function(e) {$('#kabupatenModalJenis').select2('open');});
            $('#kabupatenModalJenis').on('select2:select', function(e) {$('#jenisWilayahModalJenis').focus();});
            $('#jenisWilayahModalJenis').keydown(function(event) {if (event.keyCode == 13) {$('#submit-btn-jenis').focus();}});
        });

        $('#add-zona').click(function() {
            var option = {backdrop: 'static',keyboard: true};
            $('#modal-zona').modal(option);$('#form-zona')[0].reset();$('#modal-zona').modal('show');
        });
        $('#modal-zona').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#kodeModalZona").empty();$("#kodeModalZona").removeClass('is-valid');$("#kodeModalZona").removeClass('is-invalid');
            $("#provinsiModalZona").empty();$("#provinsiModalZona").removeClass('is-valid');$("#provinsiModalZona").removeClass('is-invalid');
            $("#kabupatenModalZona").empty();$("#kabupatenModalZona").removeClass('is-invalid');$("#kabupatenModalZona").removeClass('is-valid');
            $("#kecamatanModalZona").empty();$("#kecamatanModalZona").removeClass('is-invalid');$("#kecamatanModalZona").removeClass('is-valid');
            $("#zonasiModalZona").empty();$("#zonasiModalZona").removeClass('is-valid');$("#zonasiModalZona").removeClass('is-invalid');
        });
        $('#modal-zona').on('shown.bs.modal', function() {
            $('#kodeModalZona').focus();
            $('#kodeModalZona').keydown(function(event) {if (event.keyCode == 13) {$('#provinsiModalZona').select2('open');}});
            $('#provinsiModalZona').on('select2:select', function(e) {$('#kabupatenModalZona').select2('open');});
            $('#kabupatenModalZona').on('select2:select', function(e) {$('#kecamatanModalZona').select2('open');});
            $('#kecamatanModalZona').on('select2:select', function(e) {$('#zonasiModalZona').focus();});
            $('#zonasiModalZona').keydown(function(event) {if (event.keyCode == 13) {$('#submit-btn-zona').focus();}});
        });

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Wilayah/getProvinsi') ?>';
        $("#provinsiForm").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Provinsi ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                },
                cache: true
            },
        });
        $("#provinsiForm").change(function() {
            var provinsiID = $(this).val();var url_destination = '<?= base_url('Admin/Wilayah/getKabupaten') ?>';
            // Initialize select2
            $("#kabupatenForm").select2({
                theme: 'bootstrap4',
                placeholder: '--- Cari Kabupaten ---',
                ajax: {url: url_destination,provinsi: provinsiID,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,provinsi: provinsiID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                    },
                    cache: false
                }
            })
        });
        $("#kabupatenForm").change(function() {
            var kabupatenID = $(this).val();var url_destination = '<?= base_url('Admin/Wilayah/getKecamatan') ?>';
            // Initialize select2
            $("#kecamatanForm").select2({
                theme: 'bootstrap4',
                placeholder: '--- Cari Kecamatan ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,kabupaten: kabupatenID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                    },
                    cache: true
                }
            })
        });
        $("#kabupatenForm").change(function() {
            var provinsiID = $('#provinsiForm :selected').val();
            var kabupatenID = $(this).val();var url_destination = '<?= base_url('Admin/Wilayah/getJenis') ?>';
            // Initialize select2
            $("#jenisWilayahForm").select2({
                theme: 'bootstrap4',
                placeholder: '--- Cari Jenis Wilayah ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,provinsi: provinsiID,kabupaten: kabupatenID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                    },
                    cache: true
                }
            })
        });
        $("#kecamatanForm").change(function() {
            var provinsiID = $('#provinsiForm :selected').val();var kabupatenID = $('#kabupatenForm :selected').val();
            var kecamatanID = $(this).val();var url_destination = '<?= base_url('Admin/Wilayah/getZonasi') ?>';
            // Initialize select2
            $("#zonasiForm").select2({
                theme: 'bootstrap4',
                placeholder: '--- Cari Zonasi ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,provinsi: provinsiID,kabupaten: kabupatenID,kecamatan: kecamatanID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                    },
                    cache: true
                }
            })
        });

        var url_destination = '<?= base_url('Admin/Wilayah/getProvinsi') ?>';
        $("#provinsiModalKab").select2({
            dropdownParent: $('#modal-kab'),
            theme: 'bootstrap4',
            placeholder: '--- Cari Provinsi ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                },
                cache: true
            }
        });

        var url_destination = '<?= base_url('Admin/Wilayah/getProvinsi') ?>';
        $("#provinsiModalKec").select2({
            dropdownParent: $('#modal-kec'),
            theme: 'bootstrap4',
            placeholder: '--- Cari Provinsi ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                },
                cache: true
            }
        });

        $("#provinsiModalKec").change(function() {
            var provinsiID = $(this).val();var url_destination = '<?= base_url('Admin/Wilayah/getKabupaten') ?>';
            // Initialize select2
            $("#kabupatenModalKec").select2({
                dropdownParent: $('#modal-kec'),
                theme: 'bootstrap4',
                placeholder: '--- Cari Kabupaten ---',
                ajax: {url: url_destination,provinsi: provinsiID,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,provinsi: provinsiID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                    },
                    cache: true
                }
            })
        });

        var url_destination = '<?= base_url('Admin/Wilayah/getProvinsi') ?>';
        $("#provinsiModalJenis").select2({
            dropdownParent: $('#modal-jenis'),
            theme: 'bootstrap4',
            placeholder: '--- Cari Provinsi ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                },
                cache: true
            }
        });

        $("#provinsiModalJenis").change(function() {
            var provinsiID = $(this).val();var url_destination = '<?= base_url('Admin/Wilayah/getKabupaten') ?>';
            // Initialize select2
            $("#kabupatenModalJenis").select2({
                dropdownParent: $('#modal-jenis'),
                theme: 'bootstrap4',
                placeholder: '--- Cari Kabupaten ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,provinsi: provinsiID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                    },
                    cache: false
                }
            })
        });

        var url_destination = '<?= base_url('Admin/Wilayah/getProvinsi') ?>';
        $("#provinsiModalZona").select2({
            dropdownParent: $('#modal-zona'),
            theme: 'bootstrap4',
            placeholder: '--- Cari Provinsi ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                },
                cache: true
            }
        });
        $("#provinsiModalZona").change(function() {
            var provinsiID = $(this).val();var url_destination = '<?= base_url('Admin/Wilayah/getKabupaten') ?>';
            // Initialize select2
            $("#kabupatenModalZona").select2({
                dropdownParent: $('#modal-zona'),
                theme: 'bootstrap4',
                placeholder: '--- Cari Kabupaten ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,provinsi: provinsiID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                    },
                    cache: false
                }
            })
        });
        $("#kabupatenModalZona").change(function() {
            var kabupatenID = $(this).val();var url_destination = '<?= base_url('Admin/Wilayah/getKecamatan') ?>';
            // Initialize select2
            $("#kecamatanModalZona").select2({
                dropdownParent: $('#modal-zona'),
                theme: 'bootstrap4',
                placeholder: '--- Cari Kecamatan ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,kabupaten: kabupatenID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data};
                    },
                    cache: false
                }
            })
        });

        $('#form-prov').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Wilayah/savemodal') ?>";
            $.ajax({
                url: url_destination,method: "POST",data: $(this).serialize(),dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn-prov').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-btn-prov').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn-prov').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-btn-prov').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'ModalProv').addClass('is-invalid');$("." + key + "ErrorModalProv").html(data.error[key]);
                            var element = $('#' + key + 'ModalProv');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                    } 
                    if (data.success==true) {
                        $("#modal-prov").modal('hide');
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["success"](data.msg, "Informasi");
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("nama_", "");
                            $("#" + remove + 'ModalProv').addClass('is-invalid');
                            $("." + remove + "ErrorModalProv").html(data.msg[key]);
                            var element = $('#' + remove + 'ModalProv');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"](data.error, "Informasi");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
            });
            return false;
        })

        $('#form-kab').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Wilayah/savemodal') ?>";
            $.ajax({url: url_destination,method: "POST",data: $(this).serialize(),dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn-kab').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-btn-kab').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn-kab').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-btn-kab').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'ModalKab').addClass('is-invalid');$("." + key + "ErrorModalKab").html(data.error[key]);
                            var element = $('#' + key + 'ModalKab');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                    } 
                    if (data.success==true) {
                        $("#modal-kab").modal('hide');
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["success"](data.msg, "Informasi");
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("nama_", "");
                            $("#" + remove + 'ModalKab').addClass('is-invalid');
                            $("." + remove + "ErrorModalKab").html(data.msg[key]);
                            var element = $('#' + remove + 'ModalKab');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"](data.error, "Informasi");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
            });
            return false;
        })

        $('#form-kec').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Wilayah/savemodal') ?>";
            $.ajax({url: url_destination,method: "POST",data: $(this).serialize(),dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn-kec').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-btn-kec').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn-kec').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-btn-kec').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'ModalKec').addClass('is-invalid');$("." + key + "ErrorModalKec").html(data.error[key]);
                            var element = $('#' + key + 'ModalKec');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                    }
                    if (data.success==true) {
                        $("#modal-kec").modal('hide');
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["success"](data.msg, "Informasi");
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("nama_", "");
                            $("#" + remove + 'ModalKec').addClass('is-invalid');
                            $("." + remove + "ErrorModalKec").html(data.msg[key]);
                            var element = $('#' + remove + 'ModalKec');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"](data.error, "Informasi");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
            });
            return false;
        })

        $('#form-jenis').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Wilayah/savemodal') ?>";
            $.ajax({url: url_destination,method: "POST",data: $(this).serialize(),dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn-jenis').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-btn-prov').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn-jenis').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-btn-jenis').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'ModalJenis').addClass('is-invalid');$("." + key + "ErrorModalJenis").html(data.msg[key]);
                            var element = $('#' + key + 'ModalJenis');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                    }
                    if (data.success==true) {
                        $("#modal-jenis").modal('hide');
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["success"](data.msg, "Informasi");
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("kode_", "");
                            var remove = key.replace("jenis_wilayah", "jenisWilayah");
                            $("#" + remove + 'ModalJenis').addClass('is-invalid');
                            $("." + remove + "ErrorModalJenis").html(data.msg[key]);
                            var element = $('#' + remove + 'ModalJenis');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"](data.error, "Informasi");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
            });
            return false;
        })

        $('#form-zona').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('Admin/Wilayah/savemodal') ?>";
            $.ajax({url: url_destination,method: "POST",data: $(this).serialize(),dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn-zona').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-btn-zona').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn-zona').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-btn-zona').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'ModalZona').addClass('is-invalid');$("." + key + "ErrorModalZona").html(data.error[key]);
                            var element = $('#' + key + 'ModalZona');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');;
                        });
                    }
                    if (data.success==true) {
                        $("#modal-zona").modal('hide');
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["success"](data.msg, "Informasi");
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("kode_", "");
                            var remove = key.replace("nama_", "");
                            $("#" + remove + 'ModalZona').addClass('is-invalid');
                            $("." + remove + "ErrorModalZona").html(data.msg[key]);
                            var element = $('#' + remove + 'ModalZona');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"](data.error, "Informasi");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
            });
            return false;
        })

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            if ($('#methodPage').val() === 'New') {var url_destination = "<?= base_url('Admin/Wilayah/Create') ?>";
            } else {var url_destination = "<?= base_url('Admin/Wilayah/Update') ?>";}
            $.ajax({url: url_destination,type: "POST",data: $(this).serialize(),dataType: "JSON",
                beforeSend: function() {
                    $('#submit-wilayah').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-wilayah').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-wilayah').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-wilayah').prop('disabled', false);
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
                        });
                    }
                    if (data.success==true) {
                        clearform();let timerInterval
                        swalWithBootstrapButtons.fire({
                            icon: 'success',title: 'Berhasil Memasukkan Data',
                            html: '<b>Otomatis Ke Table Wilayah!</b><br>' +
                                'Tekan No Jika Ingin Memasukkan Data Yang Lainnya',
                            timer: 3500,timerProgressBar: true,
                            showCancelButton: true,confirmButtonText: 'Ya, Kembali!',cancelButtonText: 'No, cancel!',reverseButtons: true,
                        }).then((result) => {
                            if (result.isConfirmed) {window.location.href = data.redirect;
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if ($('#methodPage').val() === 'New') {location.reload();
                                }else{window.location.replace("<?= base_url('Admin/Wilayah/new')?>");}
                            } else if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = data.redirect;
                            }
                        })
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            var remove = key.replace("kode_", "");
                            var remove = key.replace("jenis_wilayah", "jenisWilayah");
                            $("#" + remove + 'Form').addClass('is-invalid');
                            $("." + remove + "ErrorForm").html(data.msg[key]);
                            var element = $('#' + remove + 'Form');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"](data.error, "Informasi");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
            });
            return false;
        })

        function update() {
            if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {
                var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Admin/Wilayah/single_data') ?>";
                $.ajax({
                    url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        $('#submit-wilayah').removeClass("btn-success");
                        $('#submit-wilayah').addClass("btn-warning text-white");
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        $('#kodeForm').val(data.kode);
                        $("#provinsiForm").append($("<option selected='selected'></option>")
                        .val(data.provinsi.kode).text(data.provinsi.nama_provinsi)).trigger('change');
                        $("#kabupatenForm").append($("<option selected='selected'></option>")
                        .val(data.kabupaten.kode).text(data.kabupaten.nama_kabupaten)).trigger('change');
                        $("#kecamatanForm").append($("<option selected='selected'></option>")
                        .val(data.kecamatan.kode).text(data.kecamatan.nama_kecamatan)).trigger('change');
                        $("#jenisWilayahForm").append($("<option selected='selected'></option>")
                        .val(data.jenis.kode).text(data.jenis.jenis_wilayah)).trigger('change');
                        $("#zonasiForm").append($("<option selected='selected'></option>")
                        .val(data.zonasi.kode).text(data.zonasi.nama_zonasi)).trigger('change');
                        $('#submit-wilayah').html('<i class="fas fa-save"></i>&ensp;Update');
                    },
                    error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
            }
        }

        $('#generate-kode').click(function() {
            var url_destination = "<?= base_url('Admin/Wilayah/generator') ?>";
            $.ajax({
                url: url_destination,
                type: "POST",
                data: {
                    csrf_token_name: $('input[name=csrf_token_name]').val()
                },
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#kodeForm').val(data.kode);
                }
            })
        })
        $('#generate-kodeProv').click(function() {
            var url_destination = "<?= base_url('Admin/Wilayah/generatorProv') ?>";
            $.ajax({
                url: url_destination,
                type: "POST",
                data: {
                    csrf_token_name: $('input[name=csrf_token_name]').val()
                },
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#kodeModalProv').val(data.kode);
                }
            })
        })
        $('#generate-kodeKab').click(function() {
            var url_destination = "<?= base_url('Admin/Wilayah/generatorKab') ?>";
            $.ajax({
                url: url_destination,
                type: "POST",
                data: {
                    csrf_token_name: $('input[name=csrf_token_name]').val()
                },
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#kodeModalKab').val(data.kode);
                }
            })
        })
        $('#generate-kodeKec').click(function() {
            var url_destination = "<?= base_url('Admin/Wilayah/generatorKec') ?>";
            $.ajax({
                url: url_destination,
                type: "POST",
                data: {
                    csrf_token_name: $('input[name=csrf_token_name]').val()
                },
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#kodeModalKec').val(data.kode);
                }
            })
        })
        $('#generate-kodeJenis').click(function() {
            var url_destination = "<?= base_url('Admin/Wilayah/generatorJenis') ?>";
            $.ajax({
                url: url_destination,
                type: "POST",
                data: {
                    csrf_token_name: $('input[name=csrf_token_name]').val()
                },
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#kodeModalJenis').val(data.kode);
                }
            })
        })
        $('#generate-kodeZona').click(function() {
            var url_destination = "<?= base_url('Admin/Wilayah/generatorZona') ?>";
            $.ajax({
                url: url_destination,
                type: "POST",
                data: {
                    csrf_token_name: $('input[name=csrf_token_name]').val()
                },
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#kodeModalZona').val(data.kode);
                }
            })
        })


    })
</script>
<?= $this->endSection() ?>
