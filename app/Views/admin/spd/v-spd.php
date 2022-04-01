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

                <div class="card card-outline card-info">
                    <div class="card-header">
                    <h3 class="card-title pt-1">Data <?= ucwords(strtolower($title)) ?></h3>
                    <button type="button" class="btn btn-sm btn-outline-info float-right mr-1" tabindex="1" id="print" data-rel="tooltip" data-placement="top" data-container=".content" title="Print Format"><i class="fa fa-print"></i>&ensp;Print</button>
                        <button type="button" class="btn btn-sm btn-outline-primary float-right mr-1" tabindex="2" id="refresh" data-rel="tooltip" data-placement="top" data-container=".content" title="Reload Tabel"><i class="fa fa-retweet"></i>&ensp;Reload</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachSpd" id="seachSpd" type="text" placeholder="Search By NIM / Nama" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <table id="spd_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No SPD</th>
                                    <th >Pejabat Yang Memberikan Perintah</th>
                                    <th>Pegawai Yang Diperintah</th>
                                    <th>Maksud Perjalanan Dinas</th>
                                    <th>Kendaraan</th>
                                    <th>Keterangan</th>
                                    <th style="width: 12%;">Aksi</th>
                                    <th>Status</th>
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
                                            <p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800" class="mr-5">SUMBER</p>
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
                                                        <td style="width:20%;">Nama pegawai yang dipertintah</td>
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
                                                                Pembebanana anggaran
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
                                            <table class="table table-sm table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 50%;"></td>
                                                        <td>
                                                            <table class="table table-border minimpadding">
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
                                                                        <td colspan="4" class="text-center">Pejabat yang memberikan perintah<br><br><br><br>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="mt-5">
                                                                        <td colspan="4" class="text-center" id="diperintahslide2ModelView"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="4" class="text-center" id="nipslide2ModelView"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 50%;">
                                                            <table class="table table-sm">
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
                                                            <table class="table minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="berangkatdarislide2ModelViewfirst"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
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
                                                            <table class="table  minimpadding">
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
                                                            <table class="table minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="berangkatdarislide2ModelViewsecond"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
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
                                                            <table class="table minimpadding">
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
                                                            <table class="table minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="berangkatdarislide2ModelViewthird"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
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
                                                            <table class="table minimpadding">
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
                                                            <table class="table minimpadding">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
                                                                        <td style="width: 5%;"> : </td>
                                                                        <td id="berangkatdarislide2ModelViewfourth"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="width: 5%;"></td>
                                                                        <td style="width: 38%;">Berangkat dari</td>
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
                                                        <td colspan="2"><b>VI.</b> CATATAN LAIN - LAIN</td>
                                                        <td></td>
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
        /*-- DataTable To Load Data Mahasiswa --*/
        var url_destination = "<?= base_url('Admin/Spd/load_data') ?>";
        var spd = $('#spd_data').DataTable({
            "sDom": 'lrtip',"lengthChange": false,"order": [],
            "processing": true,"responsive": true,"serverSide": true,
            "ajax": {"url": url_destination,"type": 'POST',
                "data": {"csrf_token_name": $('input[name=csrf_token_name]').val()},
                "data": function(data) {data.csrf_token_name = $('input[name=csrf_token_name]').val()},
                "dataSrc": function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return response.data;
                },
                "timeout": 15000,"error": handleAjaxError
            },
            "columnDefs": [
                {"targets": [0],"orderable": false},
                {"targets": [6],"orderable": false,"class": "text-center"},
                {"targets": [7],"class": "text-center"}
            ],
        });

        function handleAjaxError(xhr, textStatus, error) {
            if (textStatus === 'timeout') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'The server took too long to send the data.',
                    showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i>&ensp;Refresh',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("seachSpd").value = "";
                        spd.search("").draw();
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error while loading the table data. Please refresh',
                    showConfirmButton: true,
                    confirmButtonText: '<i class="fa fa-retweet" aria-hidden="true"></i>&ensp;Refresh',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("seachSpd").value = "";
                        spd.search("").draw();
                    }
                });
            }
        }
        $('#seachSpd').keyup(function() {
            spd.search($(this).val()).draw();
        });
                $("#refresh").on('click', function() {
            document.getElementById("seachSpd").value = "";
            spd.search("").draw();
        });
        /*-- /. DataTable To Load Data Mahasiswa --*/


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
            var url_destination = "<?= base_url('Admin/Spd/view_data') ?>";
            $.ajax({
                url: url_destination,
                type: "POST",
                data: {
                    id: id,
                    csrf_token_name: $('input[name=csrf_token_name]').val()
                },
                dataType: "JSON",
                success: function(data) {
                    // console.log(data);
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
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
                    var awal = new Date(data.awal);var curr_date = awal.getDate();var curr_month = awal.getMonth();var curr_year = awal.getFullYear();
                    $('#awalmodalView').append(curr_date + "-" + m_names[curr_month] + "-" + curr_year);
                    var akhir = new Date(data.akhir);var curr_date = akhir.getDate();var curr_month = akhir.getMonth();var curr_year = akhir.getFullYear();
                    $('#akhirModalView').append(curr_date + "-" + m_names[curr_month] + "-" + curr_year);
                    $('#untukModalView').append(data.untuk);
                    var month_fullnames = new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Augustus","September","Oktober","November","Desember");
                    var d = new Date(data.created_at);var curr_date = d.getDate();var curr_month = d.getMonth();var curr_year = d.getFullYear();
                    $('#createdatModalView').text(curr_date + " " + month_fullnames[curr_month] + " " + curr_year);
                    data.looping.forEach((pegawailoop, index) => {
                        // console.log('index: '+ (index + 1)  + ', Value: ' +pegawailoop.id);
                        var lahir = new Date(pegawailoop.tgl_lahir);var curr_date = lahir.getDate();var curr_month = lahir.getMonth();var curr_year = lahir.getFullYear();
                        $('#pengikutModalView').append('<ul class="list-unstyled mb-0"><li>'+pegawailoop.nama+'</li></ul>');
                        $('#pengikutTTLModalView').append('<ul class="list-unstyled mb-0"><li>'+curr_date + "-" + m_names[curr_month] + "-" + curr_year+'</li></ul>');
                        $('#ketPengikutModalView').append('<ul class="list-unstyled mb-0"><li>'+pegawailoop.nama_jabatan+'</li></ul>');
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
                    $('#nipslide2ModelView').append(data.diperintah.nip);
                    for (var urutan in data.json) { //json
                        // console.log(urutan);
                        var obj = data.json[urutan];
                        for (var prop in obj) {
                            // // your code
                            // console.log(prop + " = " + obj[prop]);
                            $('#'+ prop +'slide2ModelView' + urutan).append(obj[prop]);
                            // if(prop = 'tanggalberangkat' && urutan == 'first'){
                            //     var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                            //     var first = new Date(obj['tanggalberangkat']);var curr_date = first.getDate();var curr_month = first.getMonth();var curr_year = first.getFullYear();
                            //     $('#tanggalberangkatslide2ModelViewfirst').append(curr_date + "-" + m_names[curr_month] + "-" + curr_year);
                            // }
                            // if(prop = 'tanggaltiba' && urutan == 'first'){
                            //     var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                            //     var first = new Date(obj['tanggaltiba']);var curr_date = first.getDate();var curr_month = first.getMonth();var curr_year = first.getFullYear();
                            //     $('#tanggaltibaslide2ModelViewfirst').append(curr_date + "-" + m_names[curr_month] + "-" + curr_year);
                            // }
                        }
                    }
                    $('#modal-viewitem').modal('show');
                }
            })
        })

        $(document).on('click', '.delete', function() {
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).data('id');
                    var url_destination = "<?= base_url('Admin/Spd/Delete') ?>";
                    $.ajax({
                        url: url_destination,
                        method: "POST",
                        data: {
                            id: id,
                            csrf_token_name: $('input[name=csrf_token_name]').val()
                        },
                        dataType: "JSON",
                        success: function(data) {
                            $('input[name=csrf_token_name]').val(data.csrf_token_name)
                            if (data.success) {
                                swalWithBootstrapButtons.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: data.msg,
                                    showConfirmButton: true,
                                    timer: 4000
                                });
                                $('#spd_data').DataTable().ajax.reload(null, false);
                            } else {
                                swalWithBootstrapButtons.fire({
                                    icon: 'error',
                                    title: 'Not Deleted!',
                                    text: data.msg,
                                    showConfirmButton: true,
                                    timer: 4000
                                });
                                $('#spd_data').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>
