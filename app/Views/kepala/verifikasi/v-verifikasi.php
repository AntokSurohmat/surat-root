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

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachVerifi" id="seachVerifi" type="text" placeholder="Search By NIM / Nama" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <table id="veri_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No SPT</th>
                                    <th>Nama</th>
                                    <th>Dasar Perjalanan Dinas</th>
                                    <th>Maksud Perjalanan Dinas</th>
                                    <th>Pejabat Yang Memberikan Perintah</th>
                                    <th style="width: 10%;">Aksi</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
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
                                                <img src="<?= base_url() ?>/custom/img/logo/logo.png" alt="" style="height:120px;">
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
                                                                <!-- <table class="table table-bordered table-striped">
                                                                    <tbody>

                                                                        <tr>
                                                                            <td style="width:2%;">1</td>
                                                                            <td style="width:15%;">Nama</td>
                                                                            <td style="width:1%;">:</td>
                                                                            <td></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:2%;"></td>
                                                                            <td style="width:15%;">Pangkat Golongan</td>
                                                                            <td style="width: 1%;">:</td>
                                                                            <td>Pangkat Golongan</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:2%;"></td>
                                                                            <td style="width:15%;">NIP</td>
                                                                            <td style="width: 1%;">:</td>
                                                                            <td>NIP</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="width:2%;"></td>
                                                                            <td style="width:15%;">Jabatan</td>
                                                                            <td style="width: 1%;">:</td>
                                                                            <td>Jabatan</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table> -->

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

        /*-- DataTable To Load Data Mahasiswa --*/
        var url_destination = "<?= base_url('Kepala/Verifikasi/load_data') ?>";
        var veri = $('#veri_data').DataTable({
            "sDom": 'lrtip',
            "lengthChange": false,
            "order": [],
            "processing": true,
            "responsive": true,
            "serverSide": true,
            "ajax": {
                "url": url_destination,"type": 'POST',
                "data": {"csrf_token_name": $('input[name=csrf_token_name]').val()},
                "data": function(data) {data.csrf_token_name = $('input[name=csrf_token_name]').val()},
                "dataSrc": function(response) {$('input[name=csrf_token_name]').val(response.csrf_token_name);return response.data;},
                "timeout": 15000,"error": handleAjaxError
            },
            "columnDefs": [{"targets":[0],"orderable":false},{"targets":[6],"orderable":false,"class":"text-center"},{"targets":[7],"class":"text-center"}],
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
                        document.getElementById("seachVerifi").value = "";
                        veri.search("").draw();
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
                        document.getElementById("seachVerifi").value = "";
                        veri.search("").draw();
                    }
                });
            }
        }
        $('#seachVerifi').keyup(function() {
            veri.search($(this).val()).draw();
        });
        $("#refresh").on('click', function() {
            document.getElementById("seachVerifi").value = "";
            veri.search("").draw();
        });
        /*-- /. DataTable To Load Data Mahasiswa --*/

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
                    console.log(data);
                    console.log(data.jabatan);
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#no_sptModalView').text(data.kode);
                    $('#dasarModalView').text(data.dasar);
                    $('#untukModalView').text(data.untuk);
                    var m_names = new Array("Januari", "Februari", "Maret","April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "Desember");
                    var d = new Date(data.created_at);var curr_date = d.getDate();var curr_month = d.getMonth();var curr_year = d.getFullYear();
                    $('#createdatModalView').append(curr_date + " " + m_names[curr_month] + " " + curr_year);
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
            console.log($(this).serialize());
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
                        // console.log(data.msg);
                        Object.keys(data.msg).forEach((key, index) => {
                            // var remove = key.replace("nama_", "");
                            $("#" + key + 'ModalVerifikasi').addClass('is-invalid');$("." + key + "ErrorModalVerifikasi").html(data.msg[key]);
                            var element = $('#' + key + 'ModalVerifikasi');
                            element.closest('.form-control');element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.msg[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.msg[key].length > 0 ? 'is-invalid' : 'is-valid');
                            // console.log("#"+remove+"Form");
                            // console.log(index);
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
