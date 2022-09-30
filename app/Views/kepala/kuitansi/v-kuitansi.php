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
                        <?=  session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title pt-1">Data <?= ucwords(strtolower($title)) ?></h3>
                        <!-- <a class="btn btn-sm btn-outline-info float-right" tabindex="1" href="<?= base_url('') ?>/Kepala/kuitansi/new" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i> Add Data
                        </a> -->
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
                                        <label for="namaPegawaiTable" class="col-sm-4 col-form-label">Nama Pegawai </label>
                                        <div class="col-sm-7">
                                            <select name="namaPegawaiAddEditForm" id="namaPegawaiTable" class="form-control " style="width: 100%;">
                                                <option value="">--- Cari Nama Pegawai ---</option>
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
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="namaInstansiTable" class="col-sm-4 col-form-label">Nama Instansi </label>
                                        <div class="col-sm-7">
                                            <select name="namaInstansiAddEditForm" id="namaInstansiTable" class="form-control " style="width: 100%;">
                                                <option value="">--- Cari Nama Instansi ---</option>
                                            </select>
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
                        <table id="kui_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No SPD</th>
                                    <th>Nama Pegawai</th>
                                    <th>Nama Instansi</th>
                                    <th>Tanggal Berangkat</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Jumlah</th>
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
            <div class="modal-dialog modal-xlg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">View Kuitansi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <div class="row p-3" style="background-color: #fff;">
                            <div class="col-12 invoice">
                                <div class="row">
                                    <div class="col-8" style="padding:0">
                                        <div class="p-3 mb-3">
                                            <div class="row invoice-info">
                                                <div class="col-sm-2 invoice-col text-center">
                                                    <img src="<?= base_url() ?>/assets/custom/img/logo.png" alt="" style="height:120px;">
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
                                                        <td id="tglKuitansiModalView"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40%;padding-left: 10px;">No. BKU</td>
                                                        <td id="bkuKuitansiModalView">:  </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40%;padding-left: 10px;">Kode Rekening</td>
                                                        <td id="rekeningKuitansiModalView"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div> <!-- /.col-3 -->
                                    <div class="col-12">
                                        <p style="font-size:20px;text-align:center;line-height: 1em;font-weight:800;text-decoration:underline" class="mb-0 mr-5">KUITANSI (TANDA BEMBAYARAN)</p>
                                    </div><br>
                                    <div class="col-12 mt-5 pl-5 pr-5">
                                        <table class="table table-borderless minimpadding" style="font-size: 16px;width:80%">
                                            <tbody>
                                                <tr>
                                                    <td style="width:20%;">TELAH DITERIMA DARI</td>
                                                    <td style="width:1%;">:</td>
                                                    <td> Bendahara Pengeluaran Pembantu Disperdagin Kabupaten Cirebon</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:20%;">BANYAKNYA</td>
                                                    <td style="width:1%;">:</td>
                                                    <td style="border: 1px solid;"  id="banyaknyaKuitansiModalView"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" style="width: 20%;">Rp. <span id="nominalKuitansiModalView"></span> ,-</td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 20%;">Yaitu Untuk</td>
                                                    <td style="width: 1%;">:</td>
                                                    <td ><p>Biaya Perjalanan Dinas <span id="jenisWilayahModalView"></span> dalam rangka <span id="untukModalView"></span> di <span id="namaInstansiModelView"></span> selama <span id="lamaModalView"></span> hari <br> pada tanggal <span id="tglBerangkatModalView"></span> sampai <span id="tglKembaliModalView"></span> a/n <span id="pegawaiDiperintahModalView"></span> </p></td>
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
                                                    <th style="vertical-align:middle;text-align:center;">Yang Menerima<br>Nama: <span id="tableYangMenerimaKuitansiModalView"></span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="vertical-align:bottom;text-align:center;width:25%;"><span id="tableKuasaNamaKuitansiModalView"></span></td>
                                                    <td style="vertical-align:bottom;text-align:center;width:25%;"><span id="tablePejabatNamaKuitansiModalView"></span></td>
                                                    <td style="vertical-align:bottom;text-align:center;width:25%;"><span id="tableBendaharaNamaKuitansiModalView"></span></td>
                                                    <td style="text-align:center;width:25%;">
                                                    <table class="table table-borderless nopadding">
                                                        <tr>
                                                            <td style="width: 40%;">Jabatan</td>
                                                            <td id="tablekepalaJabatanKuitansiModalView" style="text-align: left;">: </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 40%;">Sat. Kerja</td>
                                                            <td style="text-align: left;">: Disperdagin Kab. Cirebon</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="height: 40px;"></td>
                                                        </tr>
                                                    </table>
                                                    <span id="tableKepalaNamaKuitansiModalView"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:center;width:25%;" id="tableKuasaNipKuitansiModalView"></td>
                                                    <td style="text-align:center;width:25%;" id="tablePejabatNipKuitansiModalView"></td>
                                                    <td style="text-align:center;width:25%;" id="tableBendaharaNipKuitansiModalView"></td>
                                                    <td style="text-align:center;width:25%;" id="tableKepalaNipKuitansiModalView"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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

        var url_destination = '<?= base_url('Kepala/Kuitansi/getNoSpdTable') ?>';
        $("#noSpdTable").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari No SPD ---',
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

        var url_destination = '<?= base_url('Kepala/Kuitansi/getPegawaiTable') ?>';
        $("#namaPegawaiTable").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Nama Pegawai ---',
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

        var url_destination = '<?= base_url('Kepala/Kuitansi/getInstansiTable') ?>';
        $("#namaInstansiTable").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari Nama Instansi ---',
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
        var url_destination = "<?= base_url('Kepala/Kuitansi/load_data') ?>";
        var kui = $('#kui_data').DataTable({
            "sDom": 'lrtip',
            "lengthChange": false,
            "order": [],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": {
                "url": url_destination,
                data: function (d) {
                    d.noSpd = $('#noSpdTable').val();d.pegawai = $('#namaPegawaiTable').val();
                    d.awal = $('#awalTable').val();d.akhir = $('#akhirTable').val();d.instansi = $('#namaInstansiTable').val();
                },
                "timeout": 15000,"error": handleAjaxError
            },
            "columnDefs": [{ targets: 0, orderable: false,"width":"3%"},  { targets: -1, orderable: false, "class": "text-center","width":"10%"},],
        });
        $('#noSpdTable').change(function(event) {kui.ajax.reload();});
        $('#namaPegawaiTable').change(function(event) {kui.ajax.reload();});
        $('#awalTable').on('apply.daterangepicker', function(ev) {kui.ajax.reload();});
        $('#akhirTable').on('apply.daterangepicker', function(ev) {kui.ajax.reload();});
        $('#namaInstansiTable').change(function(event) {kui.ajax.reload();});

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
            $("#noSpdTable").val('').trigger('change');$("#namaPegawaiTable").val('').trigger('change');
            document.getElementById("awalTable").value = "";document.getElementById("akhirTable").value = "";
            $("#namaInstansiTable").val('').trigger('change');kui.ajax.reload();
        });
        /*-- /. DataTable To Load Data Wilayah --*/

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
            var url_destination = "<?= base_url('Kepala/Kuitansi/view_data') ?>";
            $.ajax({
                url: url_destination,type: "POST",
                data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},dataType: "JSON",
                success: function(data) {
                    // console.log(data);
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    var m_names = new Array("01","02","03","04","05","06","07","08","09","10","11","12");
                    var m_awal = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
                    var created = new Date(data.created_at);var created_curr_date = created.getDate();var created_curr_month = created.getMonth();var created_curr_year = created.getFullYear();
                    $('#tglKuitansiModalView').append(': '+ m_awal[created_curr_date] + "-" + m_names[created_curr_month] + "-" + created_curr_year);
                    $('#rekeningKuitansiModalView').append(': '+ data.kode_rekening);
                    $('#banyaknyaKuitansiModalView').append(terbilang(data.jumlah_uang));
                    $('#nominalKuitansiModalView').append(data.jumlah_uang);
                    $('#jenisWilayahModalView').append(data.wilayah.jenis_wilayah);
                    $('#untukModalView').append(data.untuk);
                    $('#namaInstansiModelView').append(data.instansi.nama_instansi);
                    $('#lamaModalView').append(data.lama);
                    var awal = new Date(data.awal);var awal_curr_date = awal.getDate();var awal_curr_month = awal.getMonth();var awal_curr_year = awal.getFullYear();
                    $('#tglBerangkatModalView').append(m_awal[awal_curr_date] + "-" + m_names[awal_curr_month] + "-" + awal_curr_year);
                    var akhir = new Date(data.akhir);var akhir_curr_date = akhir.getDate();var akhir_curr_month = akhir.getMonth();var akhir_curr_year = akhir.getFullYear();
                    $('#tglKembaliModalView').append(m_awal[akhir_curr_date] + "-" + m_names[akhir_curr_month] + "-" + akhir_curr_year);
                    $('#pegawaiDiperintahModalView').append(data.pegawai.nama);
                    $('#tableCreatedKuitainsiModalView').append(m_awal[created_curr_date] + "-" + m_names[created_curr_month] + "-" + created_curr_year);
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
                    var url_destination = "<?= base_url('Kepala/Kuitansi/Delete') ?>";
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
                                    icon: 'success',title: 'Deleted!',text: data.msg,
                                    showConfirmButton: true,timer: 4000
                                });
                                $('#kui_data').DataTable().ajax.reload(null, false);
                            } else {
                                swalWithBootstrapButtons.fire({
                                    icon: 'error',title: 'Not Deleted!',text: data.msg,
                                    showConfirmButton: true,timer: 4000
                                });
                                $('#kui_data').DataTable().ajax.reload(null, false);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                    });
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>
