<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | <?= $title ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/AdminLTE/plugins/toastr/toastr.min.css">
    <!-- Costum CSS -->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/custom/css/style.css"> -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/jquery/jquery.min.js"></script>

</head>


<body class="hold-transition login-page layout-fixed">

    <div class="login-box">
        <?= $this->renderSection('content')?>
    </div>
    <!-- /.login-box -->

    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/moment/moment.min.js"></script>
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/assets/AdminLTE/dist/js/adminlte.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?= base_url() ?>/assets/AdminLTE/plugins/toastr/toastr.min.js"></script>
    <!-- Costum Js -->
    <script src="<?= base_url() ?>/assets/custom/js/custom.js"></script>
    <script type="text/javascript">
        // Jquery
        $(document).ready(function () {
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
