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
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <div class="form-group row">
                                                <label for="noSpdTable" class="col-sm-2 col-form-label">No SPD </label>
                                                <div class="col-sm-7">
                                                    <select name="noSpdAddEditForm" id="noSpdTable" class="form-control " style="width: 100%;">
                                                        <option value="">--- Cari No SPD ---</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="namaPegawaiTable" class="col-sm-2 col-form-label">Rincian Biaya </label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" placeholder="Biaya Uang Harian" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="namaPegawaiTable" class="col-sm-2 col-form-label">Jumlah </label>
                                                <div class="col-sm-7">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">Rp.</span>
                                                        </div>
                                                        <input type="text" name="usernameAddEditForm" id="usernameForm" class="form-control" placeholder="Jumlah Uang" readonly>
                                                        <div class="invalid-feedback usernameErrorForm"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                </div><!-- /.card -->
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

    })
</script>
<?= $this->endSection() ?>
