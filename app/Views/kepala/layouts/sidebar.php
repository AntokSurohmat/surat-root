<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
    <img src="<?= base_url() ?>/assets/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">AdminLTE 3</span>
</a>

<!-- Sidebar -->
<div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
    with font-awesome or any other icon font library -->
            <li class="nav-header">NAVIGATIONS</li>
            <li class="nav-item">
                <a href="<?= site_url('kepala') ?>" class="nav-link <?= $parent=='1' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('kepala/verifikasi') ?>" class="nav-link <?= $parent=='2' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-envelope-open"></i>
                    <p>
                        Verifikasi
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= site_url('kepala/lapspt') ?>" class="nav-link <?= $parent=='3' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>
                        Laporan SPT
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="javascript:void(0)" onclick="logout()" class="nav-link">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>
                        Logout
                    </p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
