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
<style>
    @media print {
    .content-wrapper {
        height: 29,7cm;
    }
    div#modal-viewitem {
        height: 29.7cm;
    }
    .modal-header, .modal-footer, .main-footer {
        display: none;
    }
    .modal-content {
        z-index: 9999999;
        height: 29,7cm;
    }
    .modal-lg, .modal-xl {
        max-width: 100%;
    }
    .modal.show .modal-dialog {
        margin: 0 !important;
    }
    .invoice {
        border: 0;
    }
    }
</style>
<script>
function printPageArea(areaID){
    var printContent = document.getElementById(areaID);
    var WinPrint = window.open('', '', 'width=900,height=650');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
}
</script>
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
                        <button type="button" class="btn btn-sm btn-outline-primary float-right mr-1" tabindex="2" id="refresh" data-rel="tooltip" data-placement="top" data-container=".content" title="Reload Tabel"><i class="fa fa-retweet"></i>&ensp;Reload</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="input-group ">
                            <input class="form-control col-sm-12" name="seachSPT" id="seachSPT" type="text" placeholder="Search By NIM / Nama" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                        <table id="spt_data" class="table table-bordered table-hover table-striped display wrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No SPT</th>
                                    <th style="width: 100px">Nama</th>
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
                            <div id="areaID" class="row">
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
                            <a href="javascript:void(0);" onclick="printPageArea('printableArea')">Print</a>
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
        var url_destination = "<?= base_url('Admin/Spt/load_data') ?>";
        var spt = $('#spt_data').DataTable({
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
                        document.getElementById("seachSPT").value = "";
                        spt.search("").draw();
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
                        document.getElementById("seachSPT").value = "";
                        spt.search("").draw();
                    }
                });
            }
        }
        $('#seachSPT').keyup(function() {
            spt.search($(this).val()).draw();
        });
        $("#refresh").on('click', function() {
            document.getElementById("seachSPT").value = "";
            spt.search("").draw();
        });
        /*-- /. DataTable To Load Data Mahasiswa --*/

        $(document).on('click', '.view', function() {
            var id = $(this).data('id');
            var url_destination = "<?= base_url('Admin/Spt/view_data') ?>";
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
                    $('#no_sptModalView').text(data.kode);
                    $('#dasarModalView').append(data.dasar);
                    $('#untukModalView').append(data.untuk);
                    var m_names = new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Augustus","September","Oktober","November","Desember");
                    var d = new Date(data.created_at);var curr_date = d.getDate();var curr_month = d.getMonth();var curr_year = d.getFullYear();
                    // document.write(curr_date + "-" + m_names[curr_month] 
                    // + "-" + curr_year);
                    $('#createdatModalView').text(curr_date + " " + m_names[curr_month] + " " + curr_year);
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
                                $('#spt_data').DataTable().ajax.reload(null, false);
                            } else {
                                swalWithBootstrapButtons.fire({
                                    icon: 'error',
                                    title: 'Not Deleted!',
                                    text: data.msg,
                                    showConfirmButton: true,
                                    timer: 4000
                                });
                                $('#spt_data').DataTable().ajax.reload(null, false);
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
