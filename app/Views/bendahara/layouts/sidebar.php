<!-- Brand Logo -->
<a href="index3.html" class="brand-link">
    <img src="<?= base_url() ?>/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
                <a href="<?= route_to('bendahara.index') ?>" class="nav-link <?= $parent=='1' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>

            <li class="nav-item <?= $parent=='2' ? 'menu-open' : ''; ?>">
                <a href="#" class="nav-link <?= $parent=='2' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Keuangan
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= route_to('bendahara.kuitansi') ?>" class="nav-link <?= $pmenu=='2.1' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kuitansi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= route_to('bendahara.rincian') ?>" class="nav-link <?= $pmenu=='2.2' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Rincian Biaya</p>
                        </a>
                    </li>
                </ul>
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
