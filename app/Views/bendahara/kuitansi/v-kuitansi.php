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

                <?php if ($errors = session()->getFlashdata('error')) : ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        <?=  session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title pt-1">Data <?= ucwords(strtolower($title)) ?></h3>
                        <a class="btn btn-sm btn-outline-info float-right" tabindex="1" href="<?= base_url('') ?>/bendahara/kuitansi/new" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i> Add Data
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-primary float-right mr-1" tabindex="2" id="refresh" data-rel="tooltip" data-placement="top" data-container=".content" title="Reload Tabel"><i class="fa fa-retweet"></i>&ensp;Reload</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachKuit" id="seachKuit" type="text" placeholder="Search By NIM / Nama" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <table id="kui_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No SPD</th>
                                    <th>Nama Pegawai</th>
                                    <th>Maksud Perjalanan Dinas</th>
                                    <th>Lama Perjalanan</th>
                                    <th>Jumlah</th>
                                    <th style="width: 10%;">Aksi</th>
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
        <div class="row p-3" style="background-color: #fff;">
            <div class="col-12 invoice">
                <div class="row">
                    <div class="col-8" style="padding:0">
                        <div class="p-3 mb-3">
                            <div class="row invoice-info">
                                <div class="col-sm-2 invoice-col text-center">
                                    <img src="<?= base_url() ?>/custom/img/logo/logo.png" alt="" style="height:120px;">
                                </div>

                                <div class="col-sm-10 invoice-col">
                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800" class="mb-0 mr-5">PEMERINTAH KABUPATEN CIREBON</p>
                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800;margin-bottom:8px;" class="mb-0 mr-5">DINAS PERDAGANGAN DAN PERINDUSTRIAN</p>
                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800;" class="mb-3 mr-5">KABUPATEN CIREBON</p>
                                    <hr class="s5 mb-3 mt-0">
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.col-9 -->
                    <div class="col-4" style="padding:0">
                        <div class="p-3 mb-3">
                            <div class="row invoice-info">
                                <table class="table nopadding">
                                    <tr>
                                        <td style="width: 40%;text-align:right;font-size:20px;font-weight:800">MODEL. U</td>
                                        <td style="font-size:20px;text-align:center;font-weight:800">XVI</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <hr class="s9" style="margin:0;margin-bottom:0px;margin-top:0px;">
                                </div>
                            </div>
                            <div class="row invoice-info">
                                <table class="table nopadding mt-2">
                                    <tr>
                                        <td style="width: 40%;padding-left: 10px;">Tanggal</td>
                                        <td id="tglKuitansiModelView">:</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 40%;padding-left: 10px;">No. BKU</td>
                                        <td id="bkuKuitansiModelView">:</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 40%;padding-left: 10px;">Kode Rekening</td>
                                        <td id="rekeningKuitansiModelView">:</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div> <!-- /.col-3 -->
                    <div class="col-12">
                        <p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800;text-decoration:underline" class="mb-0 mr-5">KUITANSI (TANDA BEMBAYARAN)</p>
                    </div><br>
                    <div class="col-12 mt-5 pl-5 pr-5">
                        <table class="table table-borderless minimpadding" style="font-size: 16px;">
                            <tbody>
                                <tr>
                                    <td style="width:15%;">TELAH DITERIMA DARI</td>
                                    <td style="width:1%;">:</td>
                                    <td> Bendahara Pengeluaran Pembantu Disperdagin Kabupaten Cirebon</td>
                                </tr>
                                <tr>
                                    <td style="width:15%;">BANYAKNYA</td>
                                    <td style="width:1%;">:</td>
                                    <td style="border: 1px solid;"  id="namaPegawaiModalViewTableLooping"></td>
                                </tr>
                                <tr>
                                    <td style="width: 15%;">Rp.</td>
                                    <td style="width: 1%;">:</td>
                                    <td id="untukModalView"></td>
                                </tr>
                                <tr>
                                    <td style="width: 15%;">Yaitu Untuk</td>
                                    <td style="width: 1%;">:</td>
                                    <td ><p>Biaya Perjalanan Dinas <span id="jenisWilayahModalView"></span> dalam rangka <span id="untukModalView"></span> di <span id="namaInstansiModelView"></span> selama <span id="lamaModalView"></span> hari pada tanggal <span id="tglBerangkatModalView"></span> sampai <span id="tglKembaliModalView"></span> a/n <span id="pegawaiDiperintahModalView"></span> </p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 mt-5 pl-5 pr-5">
                        <table class="table table-bordered" style="font-size: 16px;">
                            <thead>
                                <tr>
                                    <th style="vertical-align:middle;text-align:center;">Mengetahui/Menyetujui :</br>Kuasa Pengguna Anggaran</td>
                                    <th style="vertical-align:middle;text-align:center;">Pejabat Pelaksana Teknis Kegiatan</th>
                                    <th style="vertical-align:middle;text-align:center;">Tanggal: <span id="tableCreatedKuitainsiModalView"></span><br>Lunas Dibayar: <br>Bendahara Pengeluaran Pembantu</th>
                                    <th style="vertical-align:middle;text-align:center;">Yang Menerima<br>Nama: <span id="tablePegawaiKuitansiModalView"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="height:180px;vertical-align:bottom;text-align:center;">OK</td>
                                    <td style="height:180px;vertical-align:bottom;text-align:center;">OKI</td>
                                    <td style="height:180px;vertical-align:bottom;text-align:center;">OKII</td>
                                    <td style="height:180px;vertical-align:bottom;text-align:center;">OKIII</td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">OK</td>
                                    <td style="text-align:center;">OKI</td>
                                    <td style="text-align:center;">OKII</td>
                                    <td style="text-align:center;">OKIII</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> <!-- /.row -->
            </div> <!-- /.col-12 -->
        </div> <!-- /.row -->

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {
        
        toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["error"]("Error", "Informasi");
        console.log(terbilang(1800000));
        /*-- DataTable To Load Data Wilayah --*/
        var url_destination = "<?= base_url('Bendahara/Kuitansi/load_data') ?>";
        var kui = $('#kui_data').DataTable({
            "sDom": 'lrtip',
            "lengthChange": false,
            "order": [],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": {
                "url": url_destination,
                "type": 'POST',
                "data": {
                    "csrf_token_name": $('input[name=csrf_token_name]').val()
                },
                "data": function(data) {
                    data.csrf_token_name = $('input[name=csrf_token_name]').val()
                },
                "dataSrc": function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return response.data;
                },
                "timeout": 15000,
                "error": handleAjaxError
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }, {
                "targets": [6],
                "orderable": false,
                "class": "text-center",
            }, ],
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
                        document.getElementById("seachKuit").value = "";
                        kui.search("").draw();
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
                        document.getElementById("seachKuit").value = "";
                        kui.search("").draw();
                    }
                });
            }
        }
        $('#seachKuit').keyup(function() {
            kui.search($(this).val()).draw();
        });
        $("#refresh").on('click', function() {
            document.getElementById("seachKuit").value = "";
            kui.search("").draw();
        });
        /*-- /. DataTable To Load Data Wilayah --*/

        $('#modal-viewitem').on('hidden.bs.modal', function() {

        });

        $(document).on('click', '.view', function() {
            var id = $(this).data('id');
            var url_destination = "<?= base_url('Bendahara/Kuitansi/view_data') ?>";
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
                    var url_destination = "<?= base_url('Bendahara/Kuitansi/Delete') ?>";
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
                                $('#kui_data').DataTable().ajax.reload(null, false);
                            } else {
                                swalWithBootstrapButtons.fire({
                                    icon: 'error',
                                    title: 'Not Deleted!',
                                    text: data.msg,
                                    showConfirmButton: true,
                                    timer: 4000
                                });
                                $('#kui_data').DataTable().ajax.reload(null, false);
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
