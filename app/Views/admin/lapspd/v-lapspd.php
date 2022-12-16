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

                <?php if (session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="card card-info">
                    <div class="card-header">
                    <h3 class="card-title pt-1">Data <?= ucwords(strtolower($title)) ?></h3>
                    <button type="button" class="btn btn-sm btn-outline-info float-right mr-1" tabindex="1" id="print" data-rel="tooltip" data-placement="top" data-container=".content" title="Print Format"><i class="fa fa-print"></i>&ensp;Print</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="noSpdTable" class="col-sm-4 col-form-label">No SPD </label>
                                            <div class="col-sm-7">
                                                <select name="noSpdAddEditForm" id="noSpdTable" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari No SPD ---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="namaInstansiTable" class="col-sm-4 col-form-label">Nama Instansi </label>
                                            <div class="col-sm-7">
                                                <select name="namaInstansiAddEditForm" id="namaInstansiTable" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari Nama Instansi ---</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="namaPejabatTable" class="col-sm-4 col-form-label">Nama Pejabat </label>
                                            <div class="col-sm-7">
                                                <select name="namaPejabatAddEditForm" id="namaPejabatTable" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari Nama Pejabat ---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="namaPegawaiTable" class="col-sm-4 col-form-label">Nama Pegawai </label>
                                            <div class="col-sm-7">
                                                <select name="namaPegawaiAddEditForm" id="namaPegawaiTable" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari Nama Pegawai ---</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pengikutTable" class="col-sm-4 col-form-label">Pengikut </label>
                                            <div class="col-sm-7">
                                                <select name="pengikutAddEditForm" id="pengikutTable" class="form-control " style="width: 100%;">
                                                    <option value="">--- Pilih Pengikut ---</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="awalTable" class="col-sm-4 col-form-label">Tanggal Berangkat </label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="startAddEditForm" id="awalTable" placeholder="Tanggal Berangkat" autocomplete="off"/>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="akhirTable" class="col-sm-4 col-form-label">Tanggal Kembali </label>
                                            <div class="col-sm-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="endAddEditForm"  id="akhirTable" placeholder="Tanggal Kembali" autocomplete="off"/>
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer" style="text-align:center;">
                                <button type="submit" class="btn btn-outline-danger" id="reset"  data-rel="tooltip" data-placement="top" data-container=".content" title="Reset Form"><i class="fas fa-retweet"></i>&ensp;Reset</button>
                            </div>
                        <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->

                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <table id="spd_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 3%;">No</th>
                                    <th>No SPD</th>
                                    <th>Pegawai Yang Diperintah</th>
                                    <th>Pengikut</th>
                                    <th>Instansi</th>
                                    <th>Awal</th>
                                    <th>Akhir</th>
                                    <th>Pejabat Yang Memberikan Perintah</th>
                                    <th>Status</th>
                                    <th style="width: 12%;">Aksi</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>

        </div>

        <div class="container col-sm-6">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <form class="form-horizontal">
                            <div class="card-body">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="cetakSeSurat" class="col-sm-9 col-form-label">Cetak Semua Surat</label>
                                                <div class="col-sm-3">
                                                    <a href="<?= base_url('admin/lapspd/print-all-data')?>" target="_blank" class="btn btn-default" data-rel="tooltip" data-container=".content" data-placement="top" title="Cetak Semua Surat"><i class="fas fa-print"></i></a>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="CetakReSurat" class="col-sm-9 col-form-label">Cetak Rekap Surat</label>
                                                <div class="col-sm-3">
                                                    <a href="<?= base_url('admin/lapspd/print-recap-data')?>" target="_blank" class="btn btn-default" data-rel="tooltip" data-container=".content" data-placement="top" title="Cetak Semua Surat"><i class="fas fa-print"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group row">
                                                <label for="downSeSurat" class="col-sm-9 col-form-label">Download Semua Surat</label>
                                                <div class="col-sm-3">
                                                    <a href="<?= base_url('admin/lapspd/download-all-data')?>" target="_blank" class="btn btn-default" data-rel="tooltip" data-container=".content" data-placement="top" title="Download Semua Surat"><i class="fas fa-download"></i></a>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="downReSurat" class="col-sm-9 col-form-label">Download Rekap Surat</label>
                                                <div class="col-sm-3">
                                                    <a href="<?= base_url('admin/lapspd/download-recap-data')?>" target="_blank" class="btn btn-default" data-rel="tooltip" data-container=".content" data-placement="top" title="Download Rekap Surat"><i class="fas fa-download"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container -->

        <div id="modal-viewitem" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ViewModal" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Surat Perjalanan Dinas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="row p-3">
                            <div class="col-6" style="padding:0px;">
                                <div class="invoice p-3 mb-3">
                                    <div class="row invoice-info">
                                        <div class="col-sm-2 invoice-col text-center">
                                            <img src="<?= base_url() ?>/assets/custom/img/logo.png" alt="" style="height:120px;">
                                        </div>

                                        <div class="col-sm-10 invoice-col">
                                            <p style="font-size:20px;text-align:center;line-height: 1em;font-weight:500" class="mb-0 mr-5">PEMERINTAH KABUPATEN CIREBON</p>
                                            <p style="font-size:22px;text-align:center;line-height: 1em;font-weight:800;margin-bottom:8px;" class="mr-5">DINAS PERDAGANGAN DAN PERINDUSTRIAN</p>
                                            <p style="font-size:16px;text-align:center;line-height: 16px;" class="mb-0 mr-5">Jl. Sunan Kalijaga Nomor 10</p>
                                            <p style="font-size:16px;text-align:center;line-height: 16px;margin-bottom:8px;" class="mr-5">Pusat Pemerintah Cirebon Telp.(0231) 321495 - 321073</p>
                                            <div class="row">
                                            <div class="col-sm-10 invoice-col">
                                            <p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800" class="ml-5">SUMBER</p>
                                            </div>
                                            <div class="col-sm-1">
                                                45611
                                            </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <hr class="s5 mb-3 mt-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-7"></div>
                                        <div class="col-sm-5">
                                            <table style="margin: 0 auto;">
                                                <tbody>
                                                    <tr>
                                                        <td>Lembaran</td>
                                                        <td> : </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kode No</td>
                                                        <td> : </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nomer</td>
                                                        <td> : </td>
                                                        <td><span id="no_sptModalView"></span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12" style="margin: auto;">
                                            <table style="margin: 0 auto;">
                                                <tbody>
                                                    <tr>
                                                        <td  class="text-center">
                                                            <p style="font-size:20px;text-align:center;line-height: 1.1em;font-weight:500;text-decoration: underline;" class="mb-0">SURAT PERJALANAN DINAS</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  class="text-center">
                                                            <p style="font-size:20px;text-align:center;line-height: 1.1em;font-weight:500;" class="mb-0">(SPD)</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-borderless table-sm ml-4">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:5%;">1.</th>
                                                        <td style="width:20%;">Pejabat yang memberikan perintah</td>
                                                        <td id="diperintahModalView" colspan="2">: </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:5%;">2.</th>
                                                        <td style="width:20%;">Nama pegawai yang diperintah</td>
                                                        <td id="pegawaimodalView" colspan="2">: </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:5%;">3.</th>
                                                        <td style="width:20%;">
                                                            <ol type="a">
                                                                <li>Pangkat dan golongan</li>
                                                                <li>Jabatan/Instansi</li>
                                                                <li>Tingkat Biaya Perjalanan</li>
                                                            </ol>
                                                        </td>
                                                        <td colspan="2">
                                                        <ul class="list-unstyled">
                                                            <li id="pangolModelView">: </li>
                                                            <li id="jabatan_instansiModalView">: </li>
                                                            <li id="tinkatBiayaMovelView">: </li>
                                                        </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:5%;">4.</th>
                                                        <td style="width: 40%;">Maksud perjalanan dinas</td>
                                                        <td id="untukModalView" colspan="2">: </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:5%;">5.</th>
                                                        <td style="width: 40%;">Alat angkutan yang dipergunakan</td>
                                                        <td id="jenisKendaraanModalView" colspan="2">: </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:5%;">6.</th>
                                                        <td style="width:20%;">
                                                            <ol type="a">
                                                                <li>Tempat berangkat</li>
                                                                <li>Tempat tujuan</li>
                                                            </ol>
                                                        </td>
                                                        <td colspan="2">
                                                            <ul class="list-unstyled">
                                                                <li id="berangkatModalView">: </li>
                                                                <li id="tujuanModalView">: </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:5%;">7.</th>
                                                        <td style="width:20%;">
                                                            <ol type="a">
                                                                <li>Lama perjalanan dinas</li>
                                                                <li>Tanggal berangkat</li>
                                                                <li>Tanggal harus kembali</li>
                                                            </ol>
                                                        </td>
                                                        <td colspan="2">
                                                        <ul class="list-unstyled">
                                                            <li id="lamaModalView">: </li>
                                                            <li id="awalmodalView">: </li>
                                                            <li id="akhirModalView">: </li>
                                                        </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:5%;">8.</td>
                                                        <td style="width: 40%;">Pengikut</td>
                                                        <td style="width: 25%">Tanggal Lahir</td>
                                                        <td style="width: 25%">Keterangan</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 5%;"></td>
                                                        <td style="width:20%;" id="pengikutModalView"></td>
                                                        <td style="width:25%;" id="pengikutTTLModalView"></td>
                                                        <td style="width:25%;" id="ketPengikutModalView"></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:5%;">9.</td>
                                                        <td style="width:20%;">
                                                        <ul class="list-unstyled">
                                                                <li>
                                                                Pembebanan anggaran
                                                                </li>
                                                                <li>
                                                                    <ol type="a">
                                                                        <li>Instansi</li>
                                                                        <li>Mata anggaran/kode rekening</li>
                                                                    </ol>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                        <td colspan="2">
                                                        <ul class="list-unstyled">
                                                                <li><br></li>
                                                                <li>
                                                                    <ul class="list-unstyled">
                                                                        <li id="biayaInstansiModalViews">: </li>
                                                                        <li id="kodeRekeningModalView">: </li>
                                                                    </ul>
                                                                </li>
                                                        </ul>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:5%;">10.</th>
                                                        <td style="width:20%;">Keterangan</td>
                                                        <td id="keteranganModalView" colspan="2">: </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="col-10 pr-5">
                                            <p style="font-size: 16px;">
                                                Demikian pemerintah tugas ini dibuat untuk dilaksanakan dengan penuh tanggung jawab.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-6"></div>

                                        <div class="col-6">
                                            <!-- <p class="lead">Amount Due 2/22/2014</p> -->
                                            <div class="table-responsive">
                                                <table class="table table-borderless" style="line-height: 1em;">
                                                    <tr>
                                                        <td style="width:50%;text-align:center;padding:5px;">Dikeluarkan di</td>
                                                        <td style="padding:5px;"> : </td>
                                                        <td style="padding:5px;">Sumber</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:50%;text-align:center;padding:5px;">Pada Tanggal</td>
                                                        <td style="padding:5px;"> : </td>
                                                        <td style="padding:5px;"><p id="createdatModalView"></p></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <hr class="s9" style="margin:0;margin-bottom:0px;margin-top:0px;">
                                            <div class="col-sm-12">
                                                <p style="font-size: 16px;text-align:center">
                                                    Pejabat yang memberikan perintah
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-6"></div>
                                        <div class="col-6">
                                            <br><br>
                                            <p style="font-size: 16px;text-align:center;text-decoration: underline;" class="mb-0" id="diperintahTTDModalView"></p>
                                            <p style="font-size: 16px;text-align:center" class="mb-0" id="nipTTDModalView"></p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-6" style="padding:0px;">
                                <div class="invoice p-3 mb-3">
                                    <div class="row invoice-info">
                                        <div class="col-sm-12 invoice-col">
                                            <table class="table table-sm table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 50%;"></td>
                                                        <td>
                                                            <table class="table table-borderless minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <th style="width: 5%;">I.</th>
                                                                        <td style="width: 38%;">SPD No</td>
                                                                        <td style="width: 10%;"> : </td>
                                                                        <td id="nospdslide2ModelView"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
                                                                        <td style="width: 10%;"> : </td>
                                                                        <td id="berangkatdarislide2ModelView">Sumber</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Pada tanggal</td>
                                                                        <td style="width: 10%;"> : </td>
                                                                        <td id="tglberangkatslide2ModelView"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Ke</td>
                                                                        <td style="width: 10%;"> : </td>
                                                                        <td id="tujuanslide2ModelView"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4" class="text-center" style="height: 100px;">Pejabat yang memberikan perintah
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="mt-5">
                                                                        <td colspan="4" class="text-center"><span id="diperintahslide2ModelView" style="font-weight: 800;"></span><br><span id="nipslide2ModelView"></span></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 50%;">
                                                            <table class="table table-borderless minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <th style="width: 5%;">II.</th>
                                                                        <td style="width: 38%;">Tiba di</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tibadislide2ModelViewfirst"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Pada tanggal</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tanggaltibaslide2ModelViewfirst"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Kepala</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="kepalatibaslide2ModelViewfirst"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td style="width: 50%;">
                                                            <table class="table table-borderless minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="berangkatdarislide2ModelViewfirst"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Tujuan</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tujuanslide2ModelViewfirst"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Pada tanggal</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tanggalberangkatslide2ModelViewfirst"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Kepala</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="kepalaberangkatslide2ModelViewfirst"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 50%;">
                                                            <table class="table table-borderless minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <th style="width: 5%;">III.</th>
                                                                        <td style="width: 38%;">Tiba di</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tibadislide2ModelViewsecond"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Pada tanggal</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tanggaltibaslide2ModelViewsecond"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Kepala</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="kepalatibaslide2ModelViewsecond"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td style="width: 50%;">
                                                            <table class="table table-borderless minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="berangkatdarislide2ModelViewsecond"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Tujuan</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tujuanslide2ModelViewsecond"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Pada tanggal</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tanggalberangkatslide2ModelViewsecond"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Kepala</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="kepalaberangkatslide2ModelViewsecond"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 50%;">
                                                            <table class="table table-borderless minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <th style="width: 5%;">VI.</th>
                                                                        <td style="width: 38%;">Tiba di</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tibadislide2ModelViewthird"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Pada tanggal</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tanggaltibaslide2ModelViewthird"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Kepala</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="kepalatibaslide2ModelViewthird"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td style="width: 50%;">
                                                            <table class="table table-borderless minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="berangkatdarislide2ModelViewthird"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Tujuan</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tujuanslide2ModelViewthird"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Pada tanggal</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tanggalberangkatslide2ModelViewthird"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Kepala</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="kepalaberangkatslide2ModelViewthird"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 50%;">
                                                            <table class="table table-borderless minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <th style="width: 5%;">V.</td>
                                                                        <td style="width: 38%;">Tiba di</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tibadislide2ModelViewfourth"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Pada tanggal</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tanggaltibaslide2ModelViewfourth"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Kepala</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="kepalatibaslide2ModelViewfourth"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                        <td style="width: 50%;">
                                                            <table class="table table-borderless minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="berangkatdarislide2ModelViewfourth"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Tujuan</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tujuanslide2ModelViewfourth"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Pada tanggal</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="tanggalberangkatslide2ModelViewfourth"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Kepala</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="kepalaberangkatslide2ModelViewfourth"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="height: 164px;"><b>VI.</b> CATATAN LAIN - LAIN</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" class="text-justify"><p><b>VII.</b> Pejabat yang berwenang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba serta Bendaharawan yang bertanggung jawab, berdasarkan pengaturan-pengaturan Keuangan Negara apabila Negara mendapatkan akibat kesalahan, kelupaannya.</p></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                        <!-- <button type="submit" id="submit-btn" class="btn btn-sm btn-success"><i class="fa fas-save"></i>&ensp;Submit</button> -->
                    </div>
                </div>
            </div>
        </div><!-- /.modal  -->

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(function() {

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Lapspd/getNoSpdTable') ?>'; // display data no SPD, buddle it using select2, get data using ajax
        $("#noSpdTable").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari No SPD ---', // select2 for NO SPD
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data,};
                },
                cache: true
            }
        });

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Lapspd/getPegawaiTable') ?>';  // display data Pegawai, buddle it using select2, get data using ajax
        $("#namaPejabatTable").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Nama Pejabat ---', // select2 for Nama Pejabat
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data,};
                },
                cache: true
            }
        });

        var url_destination = '<?= base_url('Admin/Lapspd/getPegawaiTable') ?>'; // display data Pegawai, buddle it using select2, get data using ajax
        $("#namaPegawaiTable").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Nama Pegawai ---', // select2 for Nama Pegawai same as above funtion
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data,};
                },
                cache: true
            }
        });

        var url_destination = '<?= base_url('Admin/Lapspd/getPegawaiTable') ?>'; // display data Pegawai, buddle it using select2, get data using ajax
        $("#pengikutTable").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Nama Pengikut ---', // select2 for Nama Pegawai same as above funtion
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data,};
                },
                cache: true
            }
        });

        var url_destination = '<?= base_url('Admin/Lapspd/getInstansiTable') ?>'; // display data Pegawai, buddle it using select2, get data using ajax
        $("#namaInstansiTable").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Nama Instansi ---', // select2 for Nama Instansi
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);return {results: response.data,};
                },
                cache: true
            }
        });

        $('#awalTable').daterangepicker({singleDatePicker: true,showDropdowns: true,autoUpdateInput: false,locale: { cancelLabel: 'Clear',format: 'DD/MM/YYYY'}});
        $('#awalTable').on('apply.daterangepicker', function(ev, picker) {$(this).val(picker.startDate.format('DD/MM/YYYY'));});
        $('#akhirTable').daterangepicker({singleDatePicker: true,showDropdowns: true,autoUpdateInput: false,startDate: moment().add(7, 'days'),locale: {cancelLabel: 'Clear',format: 'DD/MM/YYYY'}});
        $('#akhirTable').on('apply.daterangepicker', function(ev, picker) {$(this).val(picker.startDate.format('DD/MM/YYYY'));});

        /*-- DataTable To Load Data Wilayah --*/
        var url_destination = "<?= base_url('Admin/Lapspd/load_data') ?>";
        var spd = $('#spd_data').DataTable({
            "sDom": 'lrtip',
            "lengthChange": false,
            "order": [],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": {
                "url": url_destination,
                data: function (d) {
                    d.noSpd = $('#noSpdTable').val();d.pejabat = $('#namaPejabatTable').val();
                    d.pegawai = $('#namaPegawaiTable').val();d.pengikut = $('#pengikutTable').val();
                    d.instansi = $('#namaInstansiTable').val();d.awal = $('#awalTable').val();d.akhir = $('#akhirTable').val();
                },
                "timeout": 15000,"error": handleAjaxError
            },
            "columns" : [
				{data: 'no'},
				{data: 'kode'},
				{data: 'pegawai_diperintah'},
				{
                    data: 'pegawai_all',
                    render: function (data, type, row, meta) {
                        var arr = row.pegawai_all
                        arr = arr.filter(item => item !== row.pegawai_diperintah)
                        return arr;
                    }
                },
				{data: 'nama_instansi'},
				{data: 'awal'},
				{data: 'akhir'},
				{data: 'nama'},
				{data: 'status'},
				{data: 'aksi'},
			],
            "columnDefs": [{ targets: 0, orderable: false,"width": "3%"},  { targets: -1, orderable: false, "class": "text-center","width": "10%"},],
        });
        $('#noSpdTable').change(function(event) {spd.ajax.reload();});
        $('#namaPegawaiTable').change(function(event) {spd.ajax.reload();});
        $('#namaPejabatTable').change(function(event) {spd.ajax.reload();});
        $('#pengikutTable').change(function(event) {spd.ajax.reload();});
        $('#namaInstansiTable').change(function(event) {spd.ajax.reload();});
        $('#awalTable').on('apply.daterangepicker', function(ev) {spd.ajax.reload();});
        $('#akhirTable').on('apply.daterangepicker', function(ev) {spd.ajax.reload();});

        function handleAjaxError(xhr, textStatus, error) {
            if (textStatus === 'timeout') {
                Swal.fire({
                    icon: 'error',title: 'Oops...',
                    text: 'The server took too long to send the data.',showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i>&ensp;Refresh',
                }).then((result) => {if (result.isConfirmed) {location.reload();}});
            } else {
                Swal.fire({
                    icon: 'error',title: 'Oops...',
                    text: 'Error while loading the table data. Please refresh',showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i>&ensp;Refresh',
                }).then((result) => {if (result.isConfirmed) {location.reload();}});
            }
        }
        $("#reset").on('click', function() {
            $("#noSpdTable").val('').trigger('change');$("#namaPejabatTable").val('').trigger('change');
            $("#namaPegawaiTable").val('').trigger('change');$("#pengikutTable").val('').trigger('change');$("#namaInstansiTable").val('').trigger('change');
            document.getElementById("awalTable").value = "";document.getElementById("akhirTable").value = "";spd.ajax.reload();
        });
        /*-- /. DataTable To Load Data Wilayah --*/

        $('#modal-viewitem').on('hidden.bs.modal', function() {
            $('#no_sptModalView').empty();$('#diperintahModalView').empty();
            $('#pegawaimodalView').empty();$('#pangolModelView').empty();
            $('#jabatan_instansiModalView').empty();$('#tinkatBiayaMovelView').empty();$('#jenisKendaraanModalView').empty();
            $('#berangkatModalView').empty();$('#tujuanModalView').empty();
            $('#lamaModalView').empty();$('#awalmodalView').empty();$('#akhirModalView').empty();
            $('#untukModalView').empty();$('#pengikutModalView').empty();$('#pengikutTTLModalView').empty();
            $('#ketPengikutModalView').empty();$('#biayaInstansiModalViews').empty();$('#kodeRekeningModalView').empty();
            $('#keteranganModalView').empty();$('#diperintahTTDModalView').empty();$('#nipTTDModalView').empty();
            //slide 2
            $('#nospdslide2ModelView').empty();$('#tglberangkatslide2ModelView').empty();$('#tujuanslide2ModelView').empty();
            $('#diperintahslide2ModelView').empty();$('#nipslide2ModelView').empty();

            $('#tibadislide2ModelViewfirst').empty();$('#tanggaltibaslide2ModelViewfirst').empty();$('#kepalatibaslide2ModelViewfirst').empty();
            $('#berangkatdarislide2ModelViewfirst').empty();$('#tujuanslide2ModelViewfirst').empty();
            $('#tanggalberangkatslide2ModelViewfirst').empty();$('#kepalaberangkatslide2ModelViewfirst').empty();

            $('#tibadislide2ModelViewsecond').empty();$('#tanggaltibaslide2ModelViewsecond').empty();$('#kepalatibaslide2ModelViewsecond').empty();
            $('#berangkatdarislide2ModelViewsecond').empty();$('#tujuanslide2ModelViewsecond').empty();
            $('#tanggalberangkatslide2ModelViewsecond').empty();$('#kepalaberangkatslide2ModelViewsecond').empty();

            $('#tibadislide2ModelViewthird').empty();$('#tanggaltibaslide2ModelViewthird').empty();$('#kepalatibaslide2ModelViewthird').empty();
            $('#berangkatdarislide2ModelViewthird').empty();$('#tujuanslide2ModelViewthird').empty();
            $('#tanggalberangkatslide2ModelViewthird').empty();$('#kepalaberangkatslide2ModelViewthird').empty();

            $('#tibadislide2ModelViewfourth').empty();$('#tanggaltibaslide2ModelViewfourth').empty();$('#kepalatibaslide2ModelViewfourth').empty();
            $('#berangkatdarislide2ModelViewfourth').empty();$('#tujuanslide2ModelViewfourth').empty();
            $('#tanggalberangkatslide2ModelViewfourth').empty();$('#kepalaberangkatslide2ModelViewfourth').empty();
        });

        $(document).on('click', '.view', function() {
            var id = $(this).data('id');
            var url_destination = "<?= base_url('Admin/Lapspd/view_data') ?>";
            $.ajax({
                url: url_destination,
                type: "POST",
                data: {
                    id: id,
                    csrf_token_name: $('input[name=csrf_token_name]').val()
                },
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    if (data.success == true) { 

                        $('#no_sptModalView').append(data.kode);
                        $('#diperintahModalView').append(data.diperintah.nama);
                        $('#pegawaimodalView').append(data.pegawai[0].nama);
                        $('#pangolModelView').append(data.pegawai[0].nama_pangol);
                        $('#jabatan_instansiModalView').append(data.pegawai[0].nama_jabatan+'/'+data.instansi.nama_instansi);
                        $('#tinkatBiayaMovelView').append(data.tingkat_biaya);
                        $('#jenisKendaraanModalView').append(data.jenis_kendaraan);
                        $('#berangkatModalView').append('Sumber');
                        $('#tujuanModalView').append(data.instansi.nama_instansi);
                        $('#lamaModalView').append(data.lama+' Hari');
                        var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                        var m_awal = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
                        var awal = new Date(data.awal);var awal_curr_date = awal.getDate();var awal_curr_month = awal.getMonth();var awal_curr_year = awal.getFullYear();
                        $('#awalmodalView').append(m_awal[awal_curr_date] + "-" + m_names[awal_curr_month] + "-" + awal_curr_year);
                        var akhir = new Date(data.akhir);var akhir_curr_date = akhir.getDate();var akhir_curr_month = akhir.getMonth();var akhir_curr_year = akhir.getFullYear();
                        $('#akhirModalView').append(m_awal[akhir_curr_date] + "-" + m_names[akhir_curr_month] + "-" + akhir_curr_year);
                        $('#untukModalView').append(data.untuk);
                        var month_fullnames = new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Augustus","September","Oktober","November","Desember");
                        var d = new Date(data.created_at);var full_curr_date = d.getDate();var full_curr_month = d.getMonth();var full_curr_year = d.getFullYear();
                        $('#createdatModalView').text(m_awal[full_curr_date] + " " + month_fullnames[full_curr_month] + " " + full_curr_year);
                        data.looping.forEach((pegawailoop, index) => {
                            pegawailoop.forEach((dataloop, index) => {
                                var lahir = new Date(dataloop.tgl_lahir);var lahir_curr_date = lahir.getDate();var lahir_curr_month = lahir.getMonth();var lahir_curr_year = lahir.getFullYear();
                                $('#pengikutModalView').append('<ul class="list-unstyled mb-0"><li>'+dataloop.nama+'</li></ul>');
                                $('#pengikutTTLModalView').append('<ul class="list-unstyled mb-0"><li>'+m_awal[lahir_curr_date] + "-" + m_names[lahir_curr_month] + "-" + lahir_curr_year+'</li></ul>');
                                $('#ketPengikutModalView').append('<ul class="list-unstyled mb-0"><li>'+dataloop.nama_jabatan+'</li></ul>');
                            })
                        });
                        $('#biayaInstansiModalViews').append('--');
                        $('#kodeRekeningModalView').append(data.kode_rekening);
                        $('#keteranganModalView').append(data.keterangan);
                        $('#diperintahTTDModalView').append(data.diperintah.nama);
                        $('#nipTTDModalView').append(data.diperintah.nip);
                        //slide ke 2
                        $('#nospdslide2ModelView').append(data.kode);
                        $('#tglberangkatslide2ModelView').append(data.awal);
                        $('#tujuanslide2ModelView').append('');
                        $('#diperintahslide2ModelView').append(data.diperintah.nama);
                        $('#nipslide2ModelView').append('('+data.diperintah.nip+')');
                        var u_namess = new Array("first","second","third","fourth");
                        for (var urutan in data.json) { //json
                            var obj = data.json[urutan];
                            for (var prop in obj) {
                                // your code
                                $('#'+ prop +'slide2ModelView' +u_namess[urutan]).append(obj[prop]);
                            }
                        }
                        $('#modal-viewitem').modal('show');
                    }else{
                        toastr.options = {"positionClass": "toast-top-right","closeButton": true,"showDuration": "500",};toastr["error"]("Tidak bisa dilihat karena surat belum di buat", "Informasi");
                    }
                },
            })
        })

    })
</script>
<?= $this->endSection() ?>
