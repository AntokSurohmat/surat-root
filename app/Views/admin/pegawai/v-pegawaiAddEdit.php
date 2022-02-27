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

                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title pt-1">Data <?= ucwords(strtolower($title)) ?></h3>
                        <!-- <a class="btn btn-sm btn-outline-info float-right" tabindex="1" href="#" data-rel="tooltip" data-placement="left" title="Tambah Data Baru">
                            <i class="fas fa-plus"></i> Add Data
                        </a> -->
                    </div>
                    <!-- /.card-header -->
                    <form class="form-horizontal" role="form" id="form-addedit" autocomplete="off" onsubmit="return false">
                        <div class="card-body">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                            <input type="hidden" id="methodPage" value="<?= $method ?>" />
                            <input type="hidden" name="hiddenID" id="hiddenIDPage" value="<?= $hiddenID ?>" />
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="kodeForm" class="col-sm-3 col-form-label">Kode</label>
                                            <div class="col-sm-7">
                                                <input type="number" name="kodeAddEditForm" class="form-control" id="kodeForm" placeholder="Kode Wilayah" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" autofocus />
                                                <div class="invalid-feedback kodeErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="provinsiForm" class="col-sm-3 col-form-label">Provinsi</label>
                                            <div class="col-sm-7">
                                                <select name="provinsiAddEditForm" id="provinsiForm" class="form-control " style="width: 100%;">
                                                    <option value="">--- Cari Provinsi ---</option>
                                                </select>
                                                <div class="invalid-feedback provinsiErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kabupatenForm" class="col-sm-3 col-form-label">Kabupaten/Kota</label>
                                            <div class="col-sm-7">
                                                <select name="kabupatenAddEditForm" id="kabupatenForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Provinsi Terlebih Dahulu ---</option>
                                                </select>
                                                <div class="invalid-feedback kabupatenErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jenisWilayahForm" class="col-sm-3 col-form-label">Jenis Wilayah</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="jenisWilayahAddEditForm" id="jenisWilayahForm" class="form-control" placeholder="Silahkan Pilih Provinsi & Kabupaten" readonly>
                                                <div class="invalid-feedback jenisWilayahErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="kecamatanForm" class="col-sm-3 col-form-label">Kecamatan</label>
                                            <div class="col-sm-7">
                                                <select name="kecamatanAddEditForm" id="kecamatanForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Pilih Kabupaten Terlebih Dahulu ---</option>
                                                </select>
                                                <div class="invalid-feedback kecamatanErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="zonasiForm" class="col-sm-3 col-form-label">Zonasi</label>
                                            <div class="col-sm-7">
                                                <input type="text" name="zonasiAddEditForm" id="zonasiForm" class="form-control" placeholder="Silahkan Pilih Kecamatan" readonly>
                                                <div class="invalid-feedback zonasiErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pangolForm" class="col-sm-3 col-form-label">pangkat & Golongan</label>
                                            <div class="col-sm-7">
                                                <select name="pangolAddEditForm" id="pangolForm" class="form-control select2bs4" style="width: 100%;">
                                                    <option value="">--- Cari Pangkat & Golongan ---</option>
                                                </select>
                                                <div class="invalid-feedback pangolErrorForm"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jumlahUangForm" class="col-sm-3 col-form-label">Jumlah Uang Harian</label>
                                            <!-- <div class="input-group-addon">
                                                Rp.
                                            </div> -->
                                            <div class="col-sm-7">
                                                <input type="text" name="jumlahUangAddEditForm" id="jumlahUangForm" class="form-control" placeholder="Masukkan Jumlah Uang Harian" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="6">
                                                <div class="invalid-feedback jumlahUangErrorForm"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer" style="text-align:center;">
                            <a type="button" href="<?= base_url('') ?>/Admin/Sbuh" class="btn btn-secondary mr-2"><i class="fas fa-arrow-left"></i>&ensp;Back</a>
                            <button type="submit" id="submit-sbuh" class="btn btn-success ml-2"><i class="fas fa-save"></i>&ensp;Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->

            </div>
        </div>

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {

    // var rupiah = document.getElementById('jumlahUangForm');
    //         rupiah.addEventListener('keyup', function(e){
    //         // tambahkan 'Rp.' pada saat form di ketik
    //         // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    //         rupiah.value = formatRupiah(this.value);
    //     });

    //   /* Fungsi formatRupiah */
    // function formatRupiah(angka, prefix){
    //     var number_string = angka.replace(/[^,\d]/g, '').toString(),
    //     split       = number_string.split(','),
    //     sisa        = split[0].length % 3,
    //     rupiah        = split[0].substr(0, sisa),
    //     ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

    //   // tambahkan titik jika yang di input sudah menjadi angka ribuan
    //     if(ribuan){
    //         separator = sisa ? '.' : '';
    //         rupiah += separator + ribuan.join('.');
    //     }

    //     rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    //     return prefix != undefined ? rupiah  : (rupiah ? 'Rp. ' + rupiah : '');
    // }
        // preventDefault to stay in modal when keycode 13
        $('form input').keydown(function(event) {if (event.keyCode == 13) {event.preventDefault();return false;}});

        $('#kodeForm').keydown(function(event){if(event.keyCode == 13){$('#provinsiForm').select2('open');}});
        $('#provinsiForm').on('select2:select', function(e) {$('#kabupatenForm').select2('open');});
        $('#kabupatenForm').on('select2:select', function(e) {if (event.keyCode == 13) {$('#jenisWilayahForm').focus();}});
        $('#jenisWilayahForm').keydown(function(event) {if (event.keyCode == 13) {$('#kecamatanForm').select2('open');}});
        $('#kecamatanForm').on('select2:select', function(e) {$('#zonasiForm').focus();});
        $('#zonasiForm').keydown(function(event) {if (event.keyCode == 13) {$('#pangolForm').select2('open');}});
        $('#pangolForm').on('select2:select', function(e) {$('#jumlahUangForm').focus();});
        $('#jumlahUangForm').keydown(function(event) {if (event.keyCode == 13) {$('#submit-sbuh').focus();}});
        update();

        function clearform() {
            $('#form-addedit')[0].reset();
            $("#kodeForm").empty();$("#kodeForm").removeClass('is-valid');$("#kodeForm").removeClass('is-invalid');
            $("#provinsiForm").empty();$("#provinsiForm").removeClass('is-valid');$("#provinsiForm").removeClass('is-invalid');
            $("#kabupatenForm").empty();$("#kabupatenForm").removeClass('is-valid');$("#kabupatenForm").removeClass('is-invalid');
            $("#jenisWilayahForm").empty();$("#jenisWilayahForm").removeClass('is-valid');$("#jenisWilayahForm").removeClass('is-invalid');
            $("#kecamatanForm").empty();$("#kecamatanForm").removeClass('is-valid');$("#kecamatanForm").removeClass('is-invalid');
            $("#zonasiForm").empty();$("#zonasiForm").removeClass('is-valid');$("#zonasiForm").removeClass('is-invalid');
            $("#pangolForm").empty();$("#pangolForm").removeClass('is-valid');$("#pangolForm").removeClass('is-invalid');
            $("#jumlahUangForm").empty();$("#jumlahUangForm").removeClass('is-valid');$("#jumlahUangForm").removeClass('is-invalid');
        }

        // Initialize select2
        var url_destination = '<?= base_url('Admin/Sbuh/getProvinsi') ?>';
        $("#provinsiForm").select2({
            theme: 'bootstrap4',
            tags: true,
            placeholder: '--- Cari Provinsi ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return {results: response.data,};
                },
                cache: true
            }
        });
        $("#provinsiForm").change(function() {
            var provinsiID = $(this).val();var url_destination = '<?= base_url('Admin/Sbuh/getKabupaten') ?>';
            // Initialize select2
            $("#kabupatenForm").select2({
                theme: 'bootstrap4',
                tags: true,
                placeholder: '--- Cari Kabupaten ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,provinsi: provinsiID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);
                        return {results: response.data};
                    },
                    cache: true
                }
            })
        });
        $("#kabupatenForm").change(function() {
            var provinsiID = $('#provinsiForm :selected').val(); var kabupatenID = $(this).val();
            // console.log(provinsiID);console.log(kabupatenID);
           var url_destination = "<?= base_url('Admin/Sbuh/getJenis') ?>";
            $.ajax({
                url: url_destination,type: "POST",data: {provinsi: provinsiID, kabupaten: kabupatenID,csrf_token_name: $('input[name=csrf_token_name]').val()},
                dataType: "JSON",
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#jenisWilayahForm').val(data.jenis_wilayah);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                },
            })
        });
        $("#kabupatenForm").change(function() {
            var kabupatenID = $(this).val();var url_destination = '<?= base_url('Admin/Sbuh/getKecamatan') ?>';
            // Initialize select2
            $("#kecamatanForm").select2({
                theme: 'bootstrap4',tags: true,
                placeholder: '--- Cari Kecamatan ---',
                ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                    data: function(params) {
                        return {searchTerm: params.term,kabupaten: kabupatenID,csrf_token_name: $('input[name=csrf_token_name]').val()};
                    },
                    processResults: function(response) {
                        $('input[name=csrf_token_name]').val(response.csrf_token_name);
                        return {results: response.data};
                    },
                    cache: true
                }
            })
        });
        $("#kecamatanForm").change(function() {
            var provinsiID = $('#provinsiForm :selected').val();var kabupatenID = $('#kabupatenForm :selected').val();var kecamatanID = $(this).val();

            var url_destination = '<?= base_url('Admin/Sbuh/getZonasi') ?>';
            $.ajax({
                url: url_destination,type: "POST",data: {provinsi: provinsiID, kabupaten: kabupatenID, kecamatan: kecamatanID,csrf_token_name: $('input[name=csrf_token_name]').val()},dataType: "JSON",
                success: function(data) {
                    // console.log(data);
                    $('input[name=csrf_token_name]').val(data.csrf_token_name);
                    $('#zonasiForm').val(data.nama_zonasi);
                },
                error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);},
            })
        });
        // Initialize select2
        var url_destination = '<?= base_url('Admin/Sbuh/getPangol') ?>';
        $("#pangolForm").select2({
            theme: 'bootstrap4',
            tags: true,
            placeholder: '--- Cari Pangkat & Golongan ---',
            ajax: {url: url_destination,type: "POST",dataType: "JSON",delay: 250,
                data: function(params) {
                    return {searchTerm: params.term,csrf_token_name: $('input[name=csrf_token_name]').val()};
                },
                processResults: function(response) {
                    $('input[name=csrf_token_name]').val(response.csrf_token_name);
                    return {results: response.data,};
                },
                cache: true
            }
        });

        $('#form-addedit').on('submit', function(event) {
            event.preventDefault();
            console.log($(this).serialize());
            if ($('#methodPage').val() === 'New') {var url_destination = "<?= base_url('Admin/Sbuh/Create') ?>";
            } else {var url_destination = "<?= base_url('Admin/Sbuh/Update') ?>";}
            $.ajax({url: url_destination,type: "POST",data: $(this).serialize(),dataType: "JSON",
                beforeSend: function() {
                    $('#submit-wilayah').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-wilayah').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-wilayah').html("<i class='fa fa-save'></i>&ensp;Submit");$('#submit-wilayah').prop('disabled', false);
                },
                success: function(data) {
                    $('input[name=csrf_token_name]').val(data.csrf_token_name)
                    if (data.error) {
                        Object.keys(data.error).forEach((key, index) => {
                            $("#" + key + 'Form').addClass('is-invalid');$("." + key + "ErrorForm").html(data.error[key]);
                            var element = $('#' + key + 'Form');
                            element.closest('.form-control')
                            element.closest('.select2-hidden-accessible') //access select2 class
                            element.removeClass(data.error[key].length > 0 ? ' is-valid' : ' is-invalid').addClass(data.error[key].length > 0 ? 'is-invalid' : 'is-valid');
                            // console.log(element);
                            // console.log(data.error[key].length);
                        });
                    } else {
                        if (data.success) {
                            clearform();let timerInterval
                            swalWithBootstrapButtons.fire({
                                icon: 'success',title: 'Berhasil Memasukkan Data',
                                html: '<b>Otomatis Ke Table SBUH!</b><br>' +
                                    'Tekan No Jika Ingin Memasukkan Data Yang Lainnya',
                                timer: 3500,timerProgressBar: true,
                                showCancelButton: true,confirmButtonText: 'Ya, Kembali!',cancelButtonText: 'No, cancel!',reverseButtons: true,
                            }).then((result) => {
                                if (result.isConfirmed) {window.location.href = data.redirect;
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    if ($('#methodPage').val() === 'New') {location.reload();
                                    }else{window.location.replace("<?= base_url('Admin/Sbuh/new')?>");}
                                } else if (result.dismiss === Swal.DismissReason.timer) {
                                    window.location.href = data.redirect;
                                }
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',title: 'Oops...',text: data.msg,
                                showConfirmButton: false,timer: 3000
                            });
                        }
                    }
                },error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
            });
            return false;
        })

        function update() {
            if ($('#methodPage').val() === "Update" && $('#hiddenIDPage').val() != "") {
                var id = $('#hiddenIDPage').val();var url_destination = "<?= base_url('Admin/sbuh/single_data') ?>";
                $.ajax({
                    url: url_destination,type: "POST",data: {id: id,csrf_token_name: $('input[name=csrf_token_name]').val()},
                    dataType: "JSON",
                    success: function(data) {
                        $('#submit-sbuh').removeClass("btn-success");
                        $('#submit-sbuh').addClass("btn-warning text-white");
                        $('input[name=csrf_token_name]').val(data.csrf_token_name);
                        $('#kodeForm').val(data.kode);
                        $("#provinsiForm").append($("<option selected='selected'></option>")
                        .val(data.provinsi.id).text(data.provinsi.nama_provinsi)).trigger('change');
                        $("#kabupatenForm").append($("<option selected='selected'></option>")
                        .val(data.kabupaten.id).text(data.kabupaten.nama_kabupaten)).trigger('change');
                        $('#jenisWilayahForm').val(data.jenis.nama_jenis);
                        $("#kecamatanForm").append($("<option selected='selected'></option>")
                        .val(data.kecamatan.id).text(data.kecamatan.nama_kecamatan)).trigger('change');
                        $("#zonasiForm").val(data.zonasi.nama_zonasi);
                        $("#pangolForm").append($("<option selected='selected'></option>")
                        .val(data.pangol.id).text(data.pangol.nama_pangol)).trigger('change');
                        $("#jumlahUangForm").val(data.jumlah_uang);
                        $('#submit-sbuh').html('<i class="fas fa-save"></i>&ensp;Update');
                    },error: function(xhr, ajaxOptions, thrownError) {alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);}
                })
            }
        }

    })
</script>
<?= $this->endSection() ?>
