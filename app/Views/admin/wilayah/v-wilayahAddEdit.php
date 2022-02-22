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
                    <form class="form-horizontal" role="form" id="form-addedit" autocomplete="off">
                        <div class="card-body">

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
                                            <label for="provinsi" class="col-sm-3 col-form-label">Provinsi</label>
                                            <div class="col-sm-7">
                                                <select name="" id="provinsi" class="form-control select2" style="width: 100%;">
                                                    <option value="">Silahkan Pilih Provinsi</option>
                                                </select>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-info" data-rel="tooltip" data-placement="top" title="Tambah Provinsi" id="generate-kode" onclick="generate_kode()"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="provinsi" class="col-sm-3 col-form-label">Kabupaten</label>
                                            <div class="col-sm-7">
                                                <select name="" id="provinsi" class="form-control">
                                                    <option value="">Silahkan Pilih Kabupaten</option>
                                                </select>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-primary" data-rel="tooltip" data-placement="top" title="Tambah Kabupaten" id="generate-kode" onclick="generate_kode()"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                        <div class="form-group row">
                                            <label for="provinsi" class="col-sm-3 col-form-label">Provinsi</label>
                                            <div class="col-sm-7">
                                                <select name="" id="provinsi" class="form-control">
                                                    <option value="">Silahkan Pilih Kecamatan</option>
                                                </select>
                                            </div>
                                            <span>
                                                <button type="button" class="btn btn-outline-success" data-rel="tooltip" data-placement="top" title="Tambah Kecamatan" id="generate-kode" onclick="generate_kode()"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="lapspdPejabat" class="col-sm-6 col-form-label">Jenis Wilayah</label>
                                            <div class="col-sm-6">
                                                <select name="nama_pej" id="lapspdPejabat" class="form-control">
                                                    <option value="">Pilih Nama Pejabat</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lapsptdPegawai" class="col-sm-6 col-form-label">Zonasi</label>
                                            <div class="col-sm-6">
                                                <select name="nama_peg" id="lapsptdPegawai" class="form-control">
                                                    <option value="">Pilih Nama Pegawai</option>
                                                </select>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">

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
    $(function() {

    })
</script>
<?= $this->endSection() ?>
