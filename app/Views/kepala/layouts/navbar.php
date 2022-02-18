    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= route_to('pegawai.index') ?>" role="button" data-trigger="hover" data-container="body" data-rel="popover" data-placement="bottom" data-content="Ke Halaman Dashboard">Home</a></li>
                <li class="breadcrumb-item active" role="button" data-trigger="hover" data-container="body" data-rel="popover" data-placement="bottom" data-content="Halaman Saat Ini"><?= ucwords(strtolower($title)) ?></li>
            </ol>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a role="button" class="nav-link" data-toggle="dropdown" href="#" data-trigger="hover" data-container="body" data-rel="popover" data-placement="bottom" data-content="All Notification">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button" data-trigger="hover" data-container="body" data-rel="popover" data-placement="bottom" data-content="Zoom">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a role="button" style="margin-right:5px;" href="javascript:void(0)" class="nav-link" onclick="logout()" data-trigger="hover" data-container="body" data-rel="popover" data-placement="bottom" data-content="Logout">
                <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
            </a>
        </li>
    </ul>
