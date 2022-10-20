<?= $this->extend('auth/layouts/default') ?>    

<?= $this->section('content') ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="<?= base_url() ?>/AdminLTE/index2.html" class="h1"><b>E-</b>Surat</a>
        </div>
        <div class="card-body login-card-body">
            <p class="login-box-msg">Silahkan Login Terlebih Dahulu</p>

            <form role="form" id="form-login" autocomplete="off" onsubmit="return false" method="post">
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                <div class="input-group mb-3">
                    <input type="username" class="form-control" name="username" id="usernameForm" placeholder="Username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback usernameErrorForm"></div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" id="passwordForm" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback passwordErrorForm"></div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <!-- <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div> -->
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" id="submit-btn" class="btn btn-primary btn-block"><i class='fa fa-save'></i>&ensp;Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {

        // preventDefault to stay in modal when keycode 13
        $('form input').keydown(function(event) {if (event.keyCode == 13) {event.preventDefault();return false;}});

        $('#usernameForm').keydown(function(event){if(event.keyCode == 13){$('#passwordForm').focus();}});
        $('#passwordForm').keydown(function(event){if(event.keyCode == 13){$('#submit-btn').focus();}});

        function clearform() {
            $('#form-login')[0].reset();
            $("#usernameForm").empty();$("#usernameForm").removeClass('is-valid');$("#usernameForm").removeClass('is-invalid');
            $("#passwordForm").empty();$("#passwordForm").removeClass('is-valid');$("#passwordForm").removeClass('is-invalid');
        }

        $('#form-login').on('submit', function(event) {
            event.preventDefault();
            var url_destination = "<?= base_url('auth/auth/login') ?>";
            $.ajax({url: url_destination,type: "POST",data: $(this).serialize(),dataType: "JSON",
                beforeSend: function() {
                    $('#submit-btn').html("<i class='fa fa-spinner fa-spin'></i>&ensp;Proses");$('#submit-btn').prop('disabled', true);
                },
                complete: function() {
                    $('#submit-btn').html("<i class='fa fa-save'></i>&ensp;Sign In");$('#submit-btn').prop('disabled', false);
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
                        });
                        Swal.fire({
                            icon: 'error',title: 'Oops...',
                            text: data.msg,
                            timer: 2000,timerProgressBar: true,
                        })
                    }
                    if (data.success == true) {
                        clearform();let timerInterval
                        Swal.fire({
                            icon: 'success',title: 'Berhasil Login',
                            html: '<b>'+data.msg+ '</b><br>' +
                                'Otomatis diarahkan ke halaman Dashboard',
                            timer: 2000,timerProgressBar: true,
                            showConfirmButton: false,
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = data.redirect;
                            }
                        })
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
