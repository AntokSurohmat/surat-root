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

        <div id="modal-viewitem" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ViewModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Surat Perjalanan Dinas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="row p-3" style="background-color: #fff;">
                            <div class="col-12 invoice">
                                <div class="row">
                                    <div class="col-12" style="padding:0">
                                        <div class="p-3 mb-3">
                                            <div class="invoice-info">
                                                <div class="col-sm-12 invoice-col">
                                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800" class="mb-0">RINCIAN BIAYA PERJALANAN DINAS</p>
                                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800;margin-bottom:8px;" class="mb-0">DINAS PERDAGANGAN DAN PERINDUSTRIAN</p>
                                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800;" class="mb-3">KABUPATEN CIREBON</p>
                                                    <hr class="s5 mb-3 mt-0">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- /.col-12 -->

                                    <div class="col-12">
                                        <div class="p-3 mb-0">
                                            <div class="invoice-info">
                                                <div class="col-sm-12 invoice-col">
                                                    <table class="table nopadding mt-2">
                                                        <tr>
                                                            <td style="width: 30%;padding-left: 10px;">Lampiran SPD Nomor</td>
                                                            <td id="lampiranSpdNomor">: </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;padding-left: 10px;">Tanggal</td>
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
                                                    <table class="table nopadding mt-2">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5%;" class="text-center">No</th>
                                                                <th >Rincian Biaya</th>
                                                                <th>Jumlah</th>
                                                                <th style="width: 30%;">Keteranganan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dataTableRincianModalView">
                                                            <tr>
                                                                <td id="indexDataTableRincianModalView1" class="text-center"></td>
                                                                <td id="rincianDataTableRincianModalView1"></td>
                                                                <td id="jumlahDataTableRincianModalView1"></td>
                                                                <td id="keteranganDataTableRincianModalView1"></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="indexDataTableRincianModalView2" class="text-center"></td>
                                                                <td id="rincianDataTableRincianModalView2"></td>
                                                                <td id="jumlahDataTableRincianModalView2"></td>
                                                                <td id="keteranganDataTableRincianModalView2"></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="indexDataTableRincianModalView3" class="text-center"></td>
                                                                <td id="rincianDataTableRincianModalView3"></td>
                                                                <td id="jumlahDataTableRincianModalView3"></td>
                                                                <td id="keteranganDataTableRincianModalView3"></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="indexDataTableRincianModalView4" class="text-center"></td>
                                                                <td id="rincianDataTableRincianModalView4"></td>
                                                                <td id="jumlahDataTableRincianModalView4"></td>
                                                                <td id="keteranganDataTableRincianModalView4"></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="indexDataTableRincianModalView5" class="text-center"></td>
                                                                <td id="rincianDataTableRincianModalView5"></td>
                                                                <td id="jumlahDataTableRincianModalView5"></td>
                                                                <td id="keteranganDataTableRincianModalView5"></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="indexDataTableRincianModalView6" class="text-center"></td>
                                                                <td id="rincianDataTableRincianModalView6"></td>
                                                                <td id="jumlahDataTableRincianModalView6"></td>
                                                                <td id="keteranganDataTableRincianModalView6"></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-left:10px;font-weight:800;">TOTAL</td>
                                                                <td colspan="3" id="totalTableRincianModalView">: </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" style="padding-left: 10px;font-weight:800;">TERBILANG : <span style="font-size:14px;" id="terbilangTableRincianModalView"></span></td>
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
                                                            <td style="text-align:center" id="bendaharaNamaTTD"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:center" id="bendahraNipTTD"></td>
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
                                                            <td style="text-align:center" id="kepalaBidangNamaTTD"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:center" id="kepalaBidangNipTTD"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- /.col-12 -->

                                </div> <!-- /.row -->
                            </div> <!-- /.col-12 -->
                        </div> <!-- /.row -->
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
            $('#lampiranSpdNomor').empty();$('#tanggalBepergian').empty();
            $('#indexDataTableRincianModalView1').empty();$('#jumlahDataTableRincianModalView1').empty();
            $('#rincianDataTableRincianModalView1').empty();$('#keteranganDataTableRincianModalView1').empty();
            $('#indexDataTableRincianModalView2').empty();$('#jumlahDataTableRincianModalView2').empty();
            $('#rincianDataTableRincianModalView2').empty();$('#keteranganDataTableRincianModalView2').empty();
            $('#indexDataTableRincianModalView3').empty();$('#jumlahDataTableRincianModalView3').empty();
            $('#rincianDataTableRincianModalView3').empty();$('#keteranganDataTableRincianModalView3').empty();
            $('#indexDataTableRincianModalView4').empty();$('#jumlahDataTableRincianModalView4').empty();
            $('#rincianDataTableRincianModalView4').empty();$('#keteranganDataTableRincianModalView4').empty();
            $('#indexDataTableRincianModalView5').empty();$('#jumlahDataTableRincianModalView5').empty();
            $('#rincianDataTableRincianModalView5').empty();$('#keteranganDataTableRincianModalView5').empty();
            $('#indexDataTableRincianModalView6').empty();$('#jumlahDataTableRincianModalView6').empty();
            $('#rincianDataTableRincianModalView6').empty();$('#keteranganDataTableRincianModalView6').empty();
            $('#totalTableRincianModalView').empty();
            $('#bendaharaNamaTTD').empty();$('#bendahraNipTTD').empty();
            $('#kepalaBidangNamaTTD').empty();$('#kepalaBidangNipTTD').empty();
        });


        $(document).on('click', '.view', function() {
            var id = $(this).data('id');
            var url_destination = "<?= base_url('Bendahara/Rincian/view_data') ?>";
            $.ajax({
                url: url_destination,type: "POST",
                data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},dataType: "JSON",
                success: function(data) {
                    // console.log(data);
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#lampiranSpdNomor').append(data.kode_spd);
                    var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                    var awal = new Date(data.awal);var awal_curr_date = awal.getDate();var awal_curr_month = awal.getMonth();var awal_curr_year = awal.getFullYear();
                    var akhir = new Date(data.akhir);var akhir_curr_date = akhir.getDate();var akhir_curr_month = akhir.getMonth();var akhir_curr_year = akhir.getFullYear();
                    $('#tanggalBepergian').append(awal_curr_date + "-" + m_names[awal_curr_month] + "-" + awal_curr_year +" s/d "+ akhir_curr_date + "-" + m_names[akhir_curr_month] + "-" + akhir_curr_year);
                    $('#indexDataTableRincianModalView1').append("1");
                    $('#jumlahDataTableRincianModalView1').append('Rp. '+ numberWithDot(data.jumlah_uang)+ ' ,-');
                    $('#rincianDataTableRincianModalView1').append(data.rincian_sbuh);
                    $('#keteranganDataTableRincianModalView1').append("Kwitansi");
                    data.looping.forEach((items, index) => {
                        items.forEach((content, row) => {
                            if(index == 0){
                                $('#indexDataTableRincianModalView'+(row+2)).append(row+2);
                                $('#jumlahDataTableRincianModalView'+(row+2)).append('Rp. '+ numberWithDot(content)+ ' ,-');
                            }else if(index == 1){
                                $('#rincianDataTableRincianModalView'+(row+2)).append(content);
                            }else{
                                // console.log(content == '')
                                if(content == ''){var keterangan = 'Kosong'}else{var keterangan = 'Lembar Bukti'}
                                $('#keteranganDataTableRincianModalView'+(row+2)).append(keterangan);
                            }
                        })
                    })
                    $('#totalTableRincianModalView').append('Rp. ' + numberWithDot(data.sum) + ' ,-');
                    $('#terbilangTableRincianModalView').append(terbilang(data.sum));
                    $('#bendaharaNamaTTD').append(data.bendahara.nama);
                    $('#bendahraNipTTD').append(data.bendahara.nip);
                    $('#kepalaBidangNamaTTD').append(data.kepala.nama);
                    $('#kepalaBidangNipTTD').append(data.kepala.nip);
                    $('#modal-viewitem').modal('show');
                }
            })
        })
        function numberWithDot(x) {
            var parts = x.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return parts.join(".");
        }

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
