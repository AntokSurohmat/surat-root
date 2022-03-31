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
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title pt-1">Data <?= ucwords(strtolower($title)) ?></h3>
                        <a class="btn btn-sm btn-outline-info float-right" tabindex="1" href="<?= base_url('') ?>/bendahara/rincian/new" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i> Add Data
                        </a>
                        <button type="button" class="btn btn-sm btn-outline-primary float-right mr-1" tabindex="2" id="refresh" data-rel="tooltip" data-placement="top" data-container=".content" title="Reload Tabel"><i class="fa fa-retweet"></i>&ensp;Reload</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachRcn" id="seachRcn" type="text" placeholder="Search By NIM / Nama" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <table id="rcn_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No SPD</th>
                                    <th>Rincian Biaya</th>
                                    <th>Jumlah Uang Harian</th>
                                    <th>Jumlah Total</th>
                                    <th>Aksi</th>
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
                    <div class="col-12" style="padding:0">
                        <div class="p-3 mb-3">
                            <div class="invoice-info">
                                <div class="col-sm-12 invoice-col">
                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800" class="mb-0 mr-5">RINCIAN BIAYA PERJALANAN DINAS</p>
                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800;margin-bottom:8px;" class="mb-0 mr-5">DINAS PERDAGANGAN DAN PERINDUSTRIAN</p>
                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800;" class="mb-3 mr-5">KABUPATEN CIREBON</p>
                                    <hr class="s5 mb-3 mt-0">
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.col-12 -->

                    <div class="col-12">
                        <div class="p-3 mb-3">
                            <div class="invoice-info">
                                <div class="col-sm-12 invoice-col">
                                    <table class="table nopadding mt-2">
                                        <tr>
                                            <td style="width: 40%;padding-left: 10px;">Lampiran SPD Nomor</td>
                                            <td id="lampiranSpdNomor">: </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 40%;padding-left: 10px;">Tanggal</td>
                                            <td id="tanggalBepergian">: </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.col-12 -->

                    <div class="col-12">
                        <div class="p-3 mb-3">
                            <div class="invoice-info">
                                <div class="col-sm-12 invoice-col">
                                    <table class="table table-striped mt-2">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" class="text-center">No</th>
                                                <th class="text-center">Rincian Biaya</th>
                                                <th class="text-center">Jumlah</th>
                                                <th style="width: 30%;" class="text-center">Keteranganan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="dataTableRincianModalView">

                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td style="width: 40%;padding-left:10px;font-weight:800;">TOTAL</td>
                                                <td id="totalTableRincianModalView">: </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td id="terbilangTableRincianModalView" colspan="3" style="width: 40%;padding-left: 10px;font-weight:800;">TERBILANG : </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.col-12 -->

                    <div class="col-12">
                        <div class="p-3 mb-3">
                            <div class="invoice-info row">
                                <div class="col-sm-6 invoice-col">
                                    <table class="table nopadding mt-2">
                                        <tr>
                                            <td style="text-align:center;font-weight:800;height:80px; vertical-align:bottom;">Bendahara</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;height:100px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center" id="bendaharaNamaTTD">ok</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center" id="bendahraNipTTD">ok</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-6 invoice-col">
                                    <table class="table nopadding mt-2">
                                        <tr>
                                            <td style="text-align:center;font-weight:800;height:80px; vertical-align:bottom;">Kuasa Penggunaan Anggaran,<br>Kepala Bidang Metrologi Legal<br>Kabupaten Cirebon</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center;height:100px;"></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center" id="kepalaBidangNamaTTD">ok</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align:center" id="kepalaBidangNipTTD">ok</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- /.col-12 -->

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

        /*-- DataTable To Load Data Wilayah --*/
        var url_destination = "<?= base_url('Bendahara/Rincian/load_data') ?>";
        var rinci = $('#rcn_data').DataTable({
            "sDom": 'lrtip',
            "lengthChange": false,
            "order": [],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": {
                "url": url_destination,"timeout": 15000,"error": handleAjaxError
            },
            "columnDefs": [{targets: 0,orderable: false}, {targets: -1,orderable: false,"class": "text-center"}, ],
        });

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
        };
        $('#seachRcn').keyup(function() {
            rinci.search($(this).val()).draw();
        });
        $("#refresh").on('click', function() {
            document.getElementById("seachRcn").value = "";
            rinci.search("").draw();
        });
        /*-- /. DataTable To Load Data Mahasiswa --*/

        $('#modal-viewitem').on('hidden.bs.modal', function() {
            $('#tglKuitansiModalView').empty();$('#rekeningKuitansiModalView').empty();
            $('#banyaknyaKuitansiModalView').empty();$('#nominalKuitansiModalView').empty();
            $('#jenisWilayahModalView').empty();$('#untukModalView').empty();
            $('#namaInstansiModelView').empty();$('#lamaModalView').empty();
            $('#tglBerangkatModalView').empty();$('#tglKembaliModalView').empty();
            $('#pegawaiDiperintahModalView').empty();$('#tableCreatedKuitainsiModalView').empty();
            $('#tableYangMenerimaKuitansiModalView').empty();$('#tablekepalaJabatanKuitansiModalView').empty();
            $('#tableKuasaNamaKuitansiModalView').empty();$('#tablePejabatNamaKuitansiModalView').empty();
            $('#tableBendaharaNamaKuitansiModalView').empty();$('#tableKepalaNamaKuitansiModalView').empty();
            $('#tableKuasaNipKuitansiModalView').empty();$('#tablePejabatNipKuitansiModalView').empty();
            $('#tableBendaharaNipKuitansiModalView').empty();$('#tableKepalaNipKuitansiModalView').empty();
        });


        $(document).on('click', '.view', function() {
            var id = $(this).data('id');
            var url_destination = "<?= base_url('Bendahara/Kuitansi/view_data') ?>";
            $.ajax({
                url: url_destination,type: "POST",
                data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                    var created = new Date(data.created_at);var curr_date = created.getDate();var curr_month = created.getMonth();var curr_year = created.getFullYear();
                    $('#tglKuitansiModalView').append(curr_date + "-" + m_names[curr_month] + "-" + curr_year);
                    $('#rekeningKuitansiModalView').append(data.kode_rekening);
                    $('#banyaknyaKuitansiModalView').append(terbilang(data.jumlah_uang));
                    $('#nominalKuitansiModalView').append(data.jumlah_uang);
                    $('#jenisWilayahModalView').append(data.wilayah.jenis_wilayah);
                    $('#untukModalView').append(data.untuk);
                    $('#namaInstansiModelView').append(data.instansi.nama_instansi);
                    $('#lamaModalView').append(data.lama);
                    var awal = new Date(data.awal);var curr_date = awal.getDate();var curr_month = awal.getMonth();var curr_year = awal.getFullYear();
                    $('#tglBerangkatModalView').append(curr_date + "-" + m_names[curr_month] + "-" + curr_year);
                    var akhir = new Date(data.akhir);var curr_date = akhir.getDate();var curr_month = akhir.getMonth();var curr_year = akhir.getFullYear();
                    $('#tglKembaliModalView').append(curr_date + "-" + m_names[curr_month] + "-" + curr_year);
                    $('#pegawaiDiperintahModalView').append(data.pegawai.nama);
                    var created = new Date(data.created_at);var curr_date = created.getDate();var curr_month = created.getMonth();var curr_year = created.getFullYear();
                    $('#tableCreatedKuitainsiModalView').append(curr_date + "-" + m_names[curr_month] + "-" + curr_year);
                    $('#tableYangMenerimaKuitansiModalView').append(data.pegawai.nama);
                    $('#tablekepalaJabatanKuitansiModalView').append(data.jabatan.nama_jabatan);
                    $('#tableKuasaNamaKuitansiModalView').append(data.bendahara.nama);
                    $('#tablePejabatNamaKuitansiModalView').append(data.pejabat.nama);
                    $('#tableBendaharaNamaKuitansiModalView').append(data.bendahara.nama);
                    $('#tableKepalaNamaKuitansiModalView').append(data.kepala.nama);
                    $('#tableKuasaNipKuitansiModalView').append(data.bendahara.nip);
                    $('#tablePejabatNipKuitansiModalView').append(data.pejabat.nip);
                    $('#tableBendaharaNipKuitansiModalView').append(data.bendahara.nip);
                    $('#tableKepalaNipKuitansiModalView').append(data.kepala.nip);
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
                    var url_destination = "<?= base_url('Bendahara/Rincian/Delete') ?>";
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
                                $('#rcn_data').DataTable().ajax.reload(null, false);
                            } else {
                                swalWithBootstrapButtons.fire({
                                    icon: 'error',
                                    title: 'Not Deleted!',
                                    text: data.msg,
                                    showConfirmButton: true,
                                    timer: 4000
                                });
                                $('#rcn_data').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        }
                    });
                }
            })
        });
    })
</script>
<?= $this->endSection() ?>
