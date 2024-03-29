<?= $this->extend('kepala/layouts/default') ?>

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
                        <!-- <a class="btn btn-sm btn-outline-info float-right" tabindex="1" href="<?= base_url('') ?>/Kepala/rincian/new" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i> Add Data
                        </a> -->
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
                                        <div class="p-3 mb-0">
                                            <div class="invoice-info">
                                                <div class="col-sm-12 invoice-col">
                                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800" class="mb-0">RINCIAN BIAYA PERJALANAN DINAS</p>
                                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800;margin-bottom:8px;" class="mb-0">DINAS PERDAGANGAN DAN PERINDUSTRIAN</p>
                                                    <p style="font-size:25px;text-align:center;line-height: 1em;font-weight:800;" class="mb-3">KABUPATEN CIREBON</p>
                                                    <hr class="s5 mb-0 mt-0">
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
                                                            <td id="lampiranSpdNomor"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 30%;padding-left: 10px;">Tanggal</td>
                                                            <td id="tanggalBepergian"></td>
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
                                                    <table class="table table-bordered nopadding mt-2">
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
                                                                <td id="rincianDataTableRincianModalView1" style="padding: 0 10px;"></td>
                                                                <td id="jumlahDataTableRincianModalView1" style="padding: 0 10px;"></td>
                                                                <td id="keteranganDataTableRincianModalView1" style="padding: 0 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="indexSatuDataTableRincianModalView" class="text-center"></td>
                                                                <td id="rincian_biayaSatuDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                                <td id="jumlahSatuDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                                <td id="keteranganSatuDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="indexDuaDataTableRincianModalView" class="text-center"></td>
                                                                <td id="rincian_biayaDuaDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                                <td id="jumlahDuaDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                                <td id="keteranganDuaDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="indexTigaDataTableRincianModalView" class="text-center"></td>
                                                                <td id="rincian_biayaTigaDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                                <td id="jumlahTigaDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                                <td id="keteranganTigaDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="indexEmpatDataTableRincianModalView" class="text-center"></td>
                                                                <td id="rincian_biayaEmpatDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                                <td id="jumlahEmpatDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                                <td id="keteranganEmpatDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <td id="indexLimaDataTableRincianModalView" class="text-center"></td>
                                                                <td id="rincian_biayaLimaDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                                <td id="jumlahLimaDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                                <td id="keteranganLimaDataTableRincianModalView" style="padding: 0 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" style="padding-left: 10px;font-weight:800;">TOTAL : <span id="totalTableRincianModalView"></span></td>
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
                                                            <td style="text-align:center"><b id="bendaharaNamaTTD" style="text-decoration: underline;"></b><br><span id="bendahraNipTTD"></span></td>
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
                                                            <td style="text-align:center"><b id="kepalaBidangNamaTTD" style="text-decoration: underline;"></b><br><span id="kepalaBidangNipTTD"></span></td>
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
        var url_destination = "<?= base_url('Kepala/Rincian/load_data') ?>";
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
            "columnDefs": [{targets: 0,orderable: false,"width":"3%"}, {targets: -1,orderable: false,"class": "text-center","width":"10%"}, ],
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
            $('#indexSatuDataTableRincianModalView').empty();$('#jumlahSatuDataTableRincianModalView').empty();
            $('#rincian_biayaSatuDataTableRincianModalView').empty();$('#keteranganSatuDataTableRincianModalView').empty();
            $('#indexDuaDataTableRincianModalView').empty();$('#jumlahDuaDataTableRincianModalView').empty();
            $('#rincian_biayaDuaDataTableRincianModalView').empty();$('#keteranganDuaDataTableRincianModalView').empty();
            $('#indexTigaDataTableRincianModalView').empty();$('#jumlahTigaDataTableRincianModalView').empty();
            $('#rincian_biayaTigaDataTableRincianModalView').empty();$('#keteranganTigaDataTableRincianModalView').empty();
            $('#indexEmpatDataTableRincianModalView').empty();$('#jumlahEmpatDataTableRincianModalView').empty();
            $('#rincian_biayaEmpatDataTableRincianModalView').empty();$('#keteranganEmpatDataTableRincianModalView').empty();
            $('#indexLimaDataTableRincianModalView').empty();$('#jumlahLimaDataTableRincianModalView').empty();
            $('#rincian_biayaLimaDataTableRincianModalView').empty();$('#keteranganLimaDataTableRincianModalView').empty();
            $('#totalTableRincianModalView').empty();
            $('#bendaharaNamaTTD').empty();$('#bendahraNipTTD').empty();
            $('#kepalaBidangNamaTTD').empty();$('#kepalaBidangNipTTD').empty();
        });


        $(document).on('click', '.view', function() {
            var id = $(this).data('id');
            var url_destination = "<?= base_url('Kepala/Rincian/view_data') ?>";
            $.ajax({
                url: url_destination,type: "POST",
                data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#lampiranSpdNomor').append(': '+data.kode_spd);
                    var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                    var m_awal = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
                    var awal = new Date(data.awal);var awal_curr_date = awal.getDate();var awal_curr_month = awal.getMonth();var awal_curr_year = awal.getFullYear();
                    var akhir = new Date(data.akhir);var akhir_curr_date = akhir.getDate();var akhir_curr_month = akhir.getMonth();var akhir_curr_year = akhir.getFullYear();
                    $('#tanggalBepergian').append(': '+m_awal[awal_curr_date] + "-" + m_names[awal_curr_month] + "-" + awal_curr_year +" s/d "+ m_awal[akhir_curr_date] + "-" + m_names[akhir_curr_month] + "-" + akhir_curr_year);
                    $('#indexDataTableRincianModalView1').append("1");
                    $('#jumlahDataTableRincianModalView1').append('Rp. '+ numberWithDot(data.jumlah_uang)+ ', -');
                    $('#rincianDataTableRincianModalView1').append(data.rincian_sbuh);
                    $('#keteranganDataTableRincianModalView1').append("Kwitansi");
                    var m_namess = new Array("Satu","Dua","Tiga","Empat","Lima");var m_angka = new Array("2","3","4","5","6");
                    for (var urutan in data.json) { //json
                        var obj = data.json[urutan];
                        for (var prop in obj) {
                            $('#'+ prop + m_namess[urutan] +'DataTableRincianModalView').append(obj[prop]);
                        
                            if(prop == 'jumlah_biaya'){
                                $('#index' + m_namess[urutan] +'DataTableRincianModalView').append(m_angka[urutan]);
                                if(!!obj[prop]){
                                    $('#jumlah' + m_namess[urutan] +'DataTableRincianModalView').append('Rp. '+ numberWithDot(obj[prop]) + ', -');
                                }else if (obj[prop].length === 0){
                                    $('#jumlah' + m_namess[urutan] +'DataTableRincianModalView').append('');
                                }
                            }
                            if(prop == 'bukti_riil'){
                                if(!!obj[prop]){
                                    $('#keterangan' + m_namess[urutan] +'DataTableRincianModalView').append('Lembar Bukti');
                                }else if(obj[prop].length == 0){
                                    $('#keterangan' + m_namess[urutan] +'DataTableRincianModalView').append('Kosong');
                                }
                            } 
                            // $('#rincian_biayaSatuDataTableRincianModalView').empty();
                        }
                    }

                    $('#totalTableRincianModalView').append('Rp. ' + numberWithDot(data.sum) + ' ,-');
                    $('#terbilangTableRincianModalView').append(terbilang(data.sum));
                    $('#bendaharaNamaTTD').append(data.bendahara.nama);
                    $('#bendahraNipTTD').append('('+data.bendahara.nip+')');
                    $('#kepalaBidangNamaTTD').append(data.kepala.nama);
                    $('#kepalaBidangNipTTD').append('('+data.kepala.nip+')');
                    $('#modal-viewitem').modal('show');
                }
            })
        })
        function numberWithDot(x) {
            var parts = x.toString().split(".");
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return parts.join(".");
        }

    })
</script>
<?= $this->endSection() ?>
