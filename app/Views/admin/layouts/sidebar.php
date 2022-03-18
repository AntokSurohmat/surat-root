<!-- Brand Logo -->
<a href="<?= base_url('admin') ?>" class="brand-link">
    <img src="<?= base_url('') ?>/assets/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">E-Surat</span>
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
                <a href="<?= site_url('admin') ?>" class="nav-link <?= $parent=='1' ? 'active' : ''; ?>">
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
                        Data Master
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= site_url('admin/pegawai') ?>" class="nav-link <?= $pmenu=='2.1' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Data Pegawai</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/pangol') ?>" class="nav-link <?= $pmenu=='2.2' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Pangkat & Golongan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/jabatan') ?>" class="nav-link <?= $pmenu=='2.3' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Jabatan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                    <a href="<?= site_url('admin/wilayah') ?>" class="nav-link <?= $pmenu=='2.4' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Wilayah</p>
                        </a>
                    </li>
                    <li class="nav-item">
                    <a href="<?= site_url('admin/instansi') ?>" class="nav-link <?= $pmenu=='2.5' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Instansi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                    <a href="<?= site_url('admin/sbuh') ?>" class="nav-link <?= $pmenu=='2.6' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>SBUH</p>
                        </a>
                    </li>
                    <li class="nav-item">
                    <a href="<?= site_url('admin/rekening') ?>" class="nav-link <?= $pmenu=='2.7' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Kode Rekening</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?= $parent=='3' ? 'menu-open' : ''; ?>">
                <a href="#" class="nav-link <?= $parent=='3' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>
                        Surat
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= site_url('admin/spt') ?>" class="nav-link <?= $pmenu=='3.1' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>SPT</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/spd') ?>" class="nav-link <?= $pmenu=='3.2' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>SPD</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?= $parent=='4' ? 'menu-open' : ''; ?>">
                <a href="#" class="nav-link <?= $parent=='4' ? 'active' : ''; ?>">
                    <i class="nav-icon fas fa-file-pdf"></i>
                    <p>
                        Laporan
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= site_url('admin/lapspt') ?>" class="nav-link <?= $pmenu=='4.1' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Laporan SPT</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url('admin/lapspd') ?>" class="nav-link <?= $pmenu=='4.2' ? 'active' : ''; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Laporan SPD</p>
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
