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
                        <a class="btn btn-sm btn-outline-info float-right" tabindex="1" href="<?= base_url('') ?>/Admin/Spt/new" data-rel="tooltip" data-placement="top" data-container=".content" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i> Add Data
                        </a>
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
                        <table id="spt_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 3%;">No</th>
                                    <th>No SPT</th>
                                    <th style="width: 100px">Nama</th>
                                    <th>Nama Instansi</th>
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
                        <div class="row p-3">
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
                                                        <td class="text-center">
                                                            <p style="font-size:20px;text-align:center;line-height: 1.1em;font-weight:500;text-decoration: underline;" class="mb-0">SURAT PERINTAH TUGAS</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td  class="text-center">Nomer : 090/ <b><span id="no_sptModalView"></span></b> /Bid.ML</td>
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
                                                        <td style="width: 15%;">Untuk</td>
                                                        <td style="width: 1%;">:</td>
                                                        <td id="untukModalView"></td>
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
                                                        <td style="width:50%;text-align:center;padding:5px;">Ditetapkan di</td>
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
                                                    A.n Kepala Dinas Perdagangan dan Perindustrian Kabupaten Cirebon
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6"></div>
                                        <div class="col-6">
                                            <br><br>
                                            <p style="font-size: 16px;text-align:center;text-decoration: underline;font-weight:800;" class="mb-0" id="diperintahModalView"></p>
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

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(function() {

        var url_destination = '<?= base_url('Admin/Spt/getNoSptTable') ?>';
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

        var url_destination = '<?= base_url('Admin/Spt/getPegawaiTable') ?>';
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

        var url_destination = '<?= base_url('Admin/Spt/getInstansiTable') ?>';
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
        var url_destination = "<?= base_url('Admin/Spt/load_data') ?>";
        var spt = $('#spt_data').DataTable({
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
            "columnDefs": [{ targets: 0, orderable: false},  { targets: -1, orderable: false, "class": "text-center"},],
        });
        $('#noSptTable').change(function(event) {spt.ajax.reload();});
        $('#namaPegawaiTable').change(function(event) {spt.ajax.reload();});
        $('#awalTable').on('apply.daterangepicker', function(ev) {spt.ajax.reload();});
        $('#akhirTable').on('apply.daterangepicker', function(ev) {spt.ajax.reload();});
        $('#namaInstansiTable').change(function(event) {spt.ajax.reload();});

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
            $("#namaInstansiTable").val('').trigger('change');spt.ajax.reload();
        });
        /*-- /. DataTable To Load Data Wilayah --*/

        $('#modal-viewitem').on('hidden.bs.modal', function() {
            $('#no_sptModalView').empty();$('#dasarModalView').empty();
            $('#namaPegawaiModalViewTableLooping').empty();$('#untukModalView').empty();
            $('#createdatModalView').empty();$('#diperintahModalView').empty();$('#diperintahNIPModalView').empty();
            $('#namaPegawaiModalViewTableLooping').empty();$('#tujuanModalView').empty();
        });

        $(document).on('click', '.view', function() {
            var id = $(this).data('id');
            var url_destination = "<?= base_url('Admin/Spt/view_data') ?>";
            $.ajax({
                url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                dataType: "JSON",
                success: function(data) {
                    // console.log(data);
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#no_sptModalView').text(data.kode);
                    $('#dasarModalView').append(data.dasar);
                    $('#untukModalView').append(data.untuk);
                    var m_names = new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Augustus","September","Oktober","November","Desember");
                    var m_awal = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
                    var d = new Date(data.created_at);var curr_date = d.getDate();var curr_month = d.getMonth();var curr_year = d.getFullYear();
                    $('#createdatModalView').text(m_awal[curr_date] + " " + m_names[curr_month] + " " + curr_year);
                    $('#diperintahModalView').text(data.pegawai.nama);
                    $('#diperintahNIPModalView').text('('+data.pegawai.nip+')');
                    data.looping.forEach((pegawailoop, index) => {
                        // console.log('index: '+ (index + 1)  + ', Value: ' +pegawailoop.id);
                        $('#namaPegawaiModalViewTableLooping').append('<table class="table table-borderless nopadding"><tbody><tr><td style="width:5%;font-weight:600;text-align:center">' + (index + 1) + '.' +'</td><td style="width:30%;font-weight:600;">Nama</td><td style="width:1%;font-weight:600;">:</td><td>' + pegawailoop.nama + '</td></tr><tr><td style="width:5%;font-weight:600;text-align:center"></td><td style="width:30%;font-weight:600;">Pangkat Golongan</td><td style="width: 1%;font-weight:600;">:</td><td>' + pegawailoop.nama_pangol +'</td></tr><tr><td style="width:5%;font-weight:600;text-align:center"></td><td style="width:30%;font-weight:600;">NIP</td><td style="width: 1%;font-weight:600;">:</td><td>' + pegawailoop.nip + '</td></tr><tr><td style="width:5%;font-weight:600;text-align:center"></td><td style="width:30%;font-weight:600;">Jabatan</td><td style="width: 1%;font-weight:600;">:</td><td>' + pegawailoop.nama_jabatan + '</td></tr></tbody></table>');
                    });
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
                    var url_destination = "<?= base_url('Admin/Spt/Delete') ?>";
                    $.ajax({
                        url: url_destination,method: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                        dataType: "JSON",
                        success: function(data) {
                            $('input[name=csrf_token_name]').val(data.csrf_token_name)
                            if (data.success) {
                                swalWithBootstrapButtons.fire({
                                    icon: 'success',
                                    title: 'Deleted!',text: data.msg,
                                    showConfirmButton: true,timer: 4000
                                });
                                $('#spt_data').DataTable().ajax.reload(null, false);
                            } else {
                                swalWithBootstrapButtons.fire({
                                    icon: 'error',title: 'Not Deleted!',text: data.msg,
                                    showConfirmButton: true,timer: 4000
                                });
                                $('#spt_data').DataTable().ajax.reload(null, false);
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
