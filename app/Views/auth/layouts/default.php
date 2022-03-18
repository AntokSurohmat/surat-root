<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in (v2)</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/dist/css/adminlte.min.css?v=3.2.0">
</head>

<body class="hold-transition login-page layout-fixed">

    <div class="login-box">
        <?= $this->renderSection('content')?>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/assets/AdminLTE/dist/js/adminlte.min.js?v=3.2.0"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/toastr/toastr.min.js"></script>
    <!-- Costum Js -->
    <!-- <script src="<?= base_url() ?>/assets/custom/js/custom.js"></script> -->
    <script type="text/javascript">
        <?php if (session()->getFlashdata('success')) {?>
            toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["success"]('<?= session()->getFlashdata('success') ?>', "Informasi");
        <?php } else if (session()->getFlashdata('error')) {?>
            toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["error"]('<?= session()->getFlashdata('error')?>', "Informasi");
        <?php } else if (session()->getFlashdata('warning')) {?>
            toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["warning"]('<?= session()->getFlashdata('warnong')?>', "Informasi");
        <?php } else if (session()->getFlashdata('info')) {?>
            toastr.options = {"positionClass": "toast-top-right","closeButton": true};toastr["info"]('<?= session()->getFlashdata('info')?>', "Informasi");
        <?php }?>
        // Jquery
        jQuery(function($) {
            $('[data-rel="popover"]').popover()
            $('[data-rel="tooltip"]').tooltip({
                trigger: 'hover'
            })
            $("body").tooltip({
                selector: '[data-rel="tooltip"]',
                trigger: 'hover'
            });
            // $('[data-rel="tooltip"]').hover(function() {
            //     $('.tooltip').css('top', parseInt($('.tooltip').css('left')) + 15 + 'px')
            // });
            // $('.select2bs4').select2({
            //     theme: 'bootstrap4'
            // })
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>
