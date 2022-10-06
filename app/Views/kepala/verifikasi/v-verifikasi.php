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
                        <button type="button" class="btn btn-sm btn-outline-primary float-right mr-1" tabindex="2" id="refresh" data-rel="tooltip" data-placement="top" data-container=".content" title="Reload Tabel"><i class="fa fa-retweet"></i>&ensp;Reload</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="noSptTable" class="col-sm-4 col-form-label">No SPT </label>
                                            <div class="col-sm-7">
                                                <select name="noSpdAddEditForm" id="noSptTable" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari No SPT ---</option>
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
                        <table id="veri_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No SPT</th>
                                    <th>Nama Pegawai</th>
                                    <th>Instansi</th>
                                    <th>Awal</th>
                                    <th>Akhir</th>
                                    <th style="width: 10%;">Pejabat Yang Memberikan Perintah</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
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
                            <div class="row">
                                <div class="col-12">
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
                                                <div class="col-sm-11 invoice-col">
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
                                            <div class="col-sm-12" style="margin: auto;">
                                                <table style="margin: 0 auto;">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="3"  class="text-center">
                                                                <p style="font-size:20px;text-align:center;line-height: 1.1em;font-weight:500;text-decoration: underline;" class="mb-0">SURAT PERINTAH TUGAS</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td  class="text-center">Nomer</td>
                                                            <td> : </td>
                                                            <td>090/ <b><span id="no_sptModalView"></span></b> /Bid.ML</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-12 table-responsive pl-5 ml-5 mr-5">
                                                <table class="table table-borderless minimpadding" style="font-size: 16px;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width:15%;">Dasar</td>
                                                            <td style="width:1%;">:</td>
                                                            <td id="dasarModalView"></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:15%;">Kepada</td>
                                                            <td style="width:1%;">:</td>
                                                            <td id="namaPegawaiModalViewTableLooping">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 15%;vertical-align: top;">Untuk</td>
                                                            <td style="width: 1%;vertical-align: top;">:</td>
                                                            <td>
                                                                <span id="untukModalView"></span> di <span id="namaInstansiModalView"></span><br><span id="alamatInstansiModalView"></span><br>pada tanggal <span id="awalModalView"></span> sampai <span id="akhirModalView"></span><br>selama <span id="lamaModalView"></span> hari 
                                                            </td>
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
                                                <div class="table-responsive mb-0">
                                                    <table class="table table-borderless" style="line-height: 1em;">
                                                        <tr>
                                                            <td style="width:50%;text-align:center;padding:5px;">Ditetapkan di</td>
                                                            <td style="padding:5px;"> : </td>
                                                            <td style="padding:5px;">Sumber</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width:50%;text-align:center;padding:5px;">Pada Tanggal</td>
                                                            <td style="padding:5px;"> : </td>
                                                            <td style="padding:5px;" id="createdatModalView"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <hr class="s9" style="margin:0;margin-bottom:0px;margin-top:0px;">
                                                <div class="col-sm-12">
                                                    <p style="font-size: 16px;text-align:center">
                                                        A.n Kepala Dinas Perdagangan dan Perindustrian Kabupaten Cirebon
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">

                                            <div class="col-6"></div>

                                            <div class="col-6">
                                                <br><br>
                                                <p style="font-size: 16px;text-align:center;text-decoration: underline;" class="mb-0" id="diperintahModalView"></p>
                                                <p style="font-size: 16px;text-align:center" class="mb-0" id="diperintahNIPModalView"></p>
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

        <div id="modal-verifikasiitem" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="VerifikasiModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Verifikasi Surat Perjalanan Dinas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <form role="form" id="form-verfikasi" autocomplete="off" onsubmit="return false">
                            <div class="modal-body">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                <div class="form-group row">
                                    <div class="form-check ml-1 mr-2">
                                        <input class="form-check-input" type="radio" name="radioAddEditModalVerifikasi" value="Disetujui" id="setujuiModalVerfikasi">
                                        <label class="form-check-label">Setujui</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radioAddEditModalVerifikasi" value="Revisi" id="revisiModalVerfikasi" checked>
                                        <label class="form-check-label">Revisi</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan(<span style="font-weight: 900">Hanya Diisi Jika Revisi</span>)</label>
                                    <textarea class="form-control" rows="3" placeholder="Masukkan Alasan" name="ketAddEditModalVerifikasi" id="ketModalVerifikasi" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="20"></textarea>
                                    <div class="invalid-feedback ketErrorModalVerifikasi"></div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>&ensp;Close</button>
                                <button type="submit" id="submit-verifikasi" class="btn btn-sm btn-success"><i class="fas fa-save"></i>&ensp;Submit</button>
                            </div>
                        </form>
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

        // preventDefault to stay in modal when keycode 13
        $('form input').keydown(function(event) {if (event.keyCode == 13) {event.preventDefault();return false;}});

        var url_destination = '<?= base_url('Kepala/Verifikasi/getNoSptTable') ?>';
        $("#noSptTable").select2({
            theme: 'bootstrap4',
            placeholder: '--- Cari No SPT ---',
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

        var url_destination = '<?= base_url('Kepala/Verifikasi/getPegawaiTable') ?>';
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

        var url_destination = '<?= base_url('Kepala/Verifikasi/getInstansiTable') ?>';
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
        var url_destination = "<?= base_url('Kepala/Verifikasi/load_data') ?>";
        var veri = $('#veri_data').DataTable({
            "sDom": 'lrtip',
            "lengthChange": false,
            "order": [],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": {
                "url": url_destination,
                data: function (d) {
                    d.noSpt = $('#noSptTable').val();d.pegawai = $('#namaPegawaiTable').val();
                    d.awal = $('#awalTable').val();d.akhir = $('#akhirTable').val();d.instansi = $('#namaInstansiTable').val();
                },
                "timeout": 15000,"error": handleAjaxError
            },
            "columnDefs": [{ targets: 0, orderable: false,"width":"3%"},  { targets: -1, orderable: false, "class": "text-center","width":"10%"},],
        });
        $('#noSptTable').change(function(event) {veri.ajax.reload();});
        $('#namaPegawaiTable').change(function(event) {veri.ajax.reload();});
        $('#awalTable').on('apply.daterangepicker', function(ev) {veri.ajax.reload();});
        $('#akhirTable').on('apply.daterangepicker', function(ev) {veri.ajax.reload();});
        $('#namaInstansiTable').change(function(event) {veri.ajax.reload();});

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
            $("#noSptTable").val('').trigger('change');$("#namaPegawaiTable").val('').trigger('change');
            document.getElementById("awalTable").value = "";document.getElementById("akhirTable").value = "";
            $("#namaInstansiTable").val('').trigger('change');veri.ajax.reload();
        });
        /*-- /. DataTable To Load Data Wilayah --*/

        $('#modal-viewitem').on('hidden.bs.modal', function() {
            $('#no_sptModalView').empty();$('#dasarModalView').empty();
            $('#namaPegawaiModalViewTableLooping').empty();
            $('#untukModalView').empty();
            $('#namaInstansiModalView').empty();$('#alamatInstansiModalView').empty();
            $('#awalModalView').empty();$('#akhirModalView').empty();$('#lamaModalView').empty();
            $('#createdatModalView').empty();$('#diperintahModalView').empty();$('#diperintahNIPModalView').empty();
            $('#namaPegawaiModalViewTableLooping').empty();$('#tujuanModalView').empty();
        });

        $(document).on('click', '.view', function() {
            var id = $(this).data('id');
            var url_destination = "<?= base_url('Kepala/Verifikasi/view_data') ?>";
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
                    // console.log(data.jabatan);
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    var m_names = new Array("Januari", "Februari", "Maret","April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "Desember");
                    var m_date = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
                    var d = new Date(data.created_at);var curr_date = d.getDate();var curr_month = d.getMonth();var curr_year = d.getFullYear();
                    var awal = new Date(data.awal);var curr_date_awal = awal.getDate();var curr_month_awal = awal.getMonth();var curr_year_awal = awal.getFullYear();
                    var akhir = new Date(data.akhir);var curr_date_akhir = akhir.getDate();var curr_month_akhir = akhir.getMonth();var curr_year_akhir = akhir.getFullYear();
                    $('#no_sptModalView').text(data.kode);
                    $('#dasarModalView').text(data.dasar);
                    $('#untukModalView').append(data.untuk.tujuan);
                    $('#namaInstansiModalView').append(data.instansi.nama_instansi);
                    $('#alamatInstansiModalView').append(data.alamat_instansi);
                    $('#awalModalView').text(m_date[curr_date_awal] + " " + m_names[curr_month_awal] + " " + curr_year_awal);
                    $('#akhirModalView').text(m_date[curr_date_akhir] + " " + m_names[curr_month_akhir] + " " + curr_year_akhir);
                    $('#createdatModalView').append(m_date[curr_date] + " " + m_names[curr_month] + " " + curr_year);
                    $('#diperintahModalView').text(data.pegawai.nama);
                    $('#diperintahNIPModalView').text(data.pegawai.nip);
                    data.looping.forEach((pegawailoop, index) => {
                        // console.log('index: '+ (index + 1)  + ', Value: ' +pegawailoop.id);
                        $('#namaPegawaiModalViewTableLooping').append('<table class="table table-borderless nopadding"><tbody><tr><td style="width:2%;">' + (index + 1) + '.' +'</td><td style="width:30%;">Nama</td><td style="width:1%;">:</td><td>' + pegawailoop.nama + '</td></tr><tr><td style="width:2%;"></td><td style="width:30%;">Pangkat Golongan</td><td style="width: 1%;">:</td><td>' + pegawailoop.nama_pangol +'</td></tr><tr><td style="width:2%;"></td><td style="width:30%;">NIP</td><td style="width: 1%;">:</td><td>' + pegawailoop.nip + '</td></tr><tr><td style="width:2%;"></td><td style="width:30%;">Jabatan</td><td style="width: 1%;">:</td><td>' + pegawailoop.nama_jabatan + '</td></tr></tbody></table>');
                    });
                    $('#modal-viewitem').modal('show');
                }
            })
        })

        $('#modal-verifikasiitem').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $("#ketModalVerifikasi").empty();$("#ketModalVerifikasi").removeClass('is-valid');$("#ketModalVerifikasi").removeClass('is-invalid');
        });
        $('#modal-verifikasiitem').on('shown.bs.modal', function() {
            $('input:radio[name=radioAddEditModalVerifikasi]')[1].focus();
            $('input:radio[name=radioAddEditModalVerifikasi]').change(function () {setTimeout(function() { $("#ketModalVerifikasi").focus(); }, 0)});
            $('#ketModalVerifikasi').keydown(function(event) {if (event.keyCode == 13) {$('#submit-verifikasi').focus();}});
        });

        $('#modal-viewitem').on('hidden.bs.modal', function() {
            $('#no_sptModalView').empty();$('#dasarModalView').empty();
            $('#namaPegawaiModalViewTableLooping').empty();$('#untukModalView').empty();
            $('#createdatModalView').empty();$('#diperintahModalView').empty();$('#diperintahNIPModalView').empty();
            $('#namaPegawaiModalViewTableLooping').empty();$('#tujuanModalView').empty();
        });

        $(document).on('click', '.verifikasi', function() {
            var id = $(this).data('id');
            var url_destination = "<?= base_url('Kepala/Verifikasi/view_data') ?>";
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
                    // console.log(data);
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $("#revisiModalVerfikasi").prop("checked", true);
                    $('#hidden_id').val(data.id);
                    $('#modal-verifikasiitem').modal('show');
                }
            })
        })

        $('#form-verfikasi').on('submit', function(event) {
            event.preventDefault();
            // console.log($(this).serialize());
            $.ajax({
                url: "<?= base_url('Kepala/Verifikasi/update') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                beforeSend: function() {
                    $('#submit-verfikasi').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-verfikasi').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-verfikasi').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-verfikasi').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    // console.log(data.error);
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'ModalVerifikasi').addClass('is-invalid');$("." + key + "ErrorModalVerifikasi").html(data.error[key]);
                            var element = $('#' + key + 'ModalVerifikasi');
                            element.closest('.form-control');element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                        });
                    }
                    if (data.success == true) {
                        $("#modal-verifikasiitem").modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil..',
                            text: data.msg,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#veri_data').DataTable().ajax.reload(null, false);
                    } else {
                        Object.keys(data.msg).forEach((key, index) => {
                            // var remove = key.replace("nama_", "");
                            $("#" + key + 'ModalVerifikasi').addClass('is-invalid');$("." + key + "ErrorModalVerifikasi").html(data.msg[key]);
                            var element = $('#' + key + 'ModalVerifikasi');
                            element.closest('.form-control');element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                            // console.log("#"+remove+"Form");
                            console.log(key + ' => '+index );
                        });
                        if(data.msg != ""){
                            toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"](data.error, "Informasi");
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
            return false;
        })

    })
</script>
<?= $this->endSection() ?>
