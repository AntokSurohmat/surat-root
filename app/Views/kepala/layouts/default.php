<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | <?= $title ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/plugins/daterangepicker/daterangepicker.css">
    <!-- Datatables -->
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/plugins/toastr/toastr.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Costum CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/custom/css/style.css">

    <!-- jQuery -->
    <script src="<?= base_url() ?>/AdminLTE/plugins/jquery/jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url() ?>/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div> -->

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <?= $this->include('kepala/layouts/navbar') ?>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <?= $this->include('kepala/layouts/sidebar') ?>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?= $this->renderSection('content') ?>
        </div>
        <!-- /.content-wrapper -->

        <div class="modal fade" id="modal-logout" tabindex="-1">
            <div class="modal-dialog modal-outline-danger">
                <div class="modal-content">
                    <div class="modal-header card-outline">
                        <h5 class="modal-title">Ready to Leave?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Select "Logout" below if you are ready to end your current session.</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"> Close&ensp;<i class="fas fa-times"></i></button>
                        <a class="btn btn-sm btn-danger" tabindex="1" href="<?= base_url('auth/logout') ;?>">Logout&ensp;<i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
        <footer class="main-footer">
            <?= $this->include('kepala/layouts/footer') ?>
        </footer>

    </div>
    <!-- ./wrapper -->


    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url() ?>/AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url() ?>/AdminLTE/plugins/moment/moment.min.js"></script>
    <script src="<?= base_url() ?>/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= base_url() ?>/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url() ?>/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/AdminLTE/dist/js/adminlte.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?= base_url() ?>/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?= base_url() ?>/AdminLTE/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?= base_url() ?>/AdminLTE/plugins/toastr/toastr.min.js"></script>
    <!-- Select2 -->
    <script src="<?= base_url() ?>/AdminLTE/plugins/select2/js/select2.full.min.js"></script>
    <!-- Custom Input File -->
    <script src="<?= base_url() ?>/AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- Costum Js -->
    <script src="<?= base_url() ?>/custom/js/custom.js"></script>
    <script language="javascript">
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
