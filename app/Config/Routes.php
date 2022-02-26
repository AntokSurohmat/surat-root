<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth\LoginController::index');
$routes->group('admin', function ($routes) {
    $routes->get('', 'Admin\Dashboard::index');
    $routes->get('pegawai', 'Admin\Pegawai::index');
    $routes->get('pangol', 'Admin\Pangol::index');
    $routes->get('jabatan', 'Admin\Jabatan::index');
    $routes->presenter('Wilayah', ['except' => 'show,remove']);
    $routes->presenter('Instansi', ['except' => 'show,remove']);
    $routes->presenter('Sbuh', ['except' => 'show,remove']);
    $routes->get('rekening', 'Admin\Rekening::index');
    $routes->get('spt', 'Admin\Spt::index');
    $routes->get('spd', 'Admin\Spd::index');
    $routes->get('lapspt', 'Admin\Lapspt::index');
    $routes->get('lapspd', 'Admin\Lapspd::index');
});
$routes->group('pegawai', function ($routes) {
    $routes->get('', 'Pegawai\DashboardController::index');
    $routes->get('spt', 'Pegawai\SptController::index');
    $routes->get('spd', 'Pegawai\SpdController::index');
});
$routes->group('bendahara', function ($routes) {
    $routes->get('', 'Bendahara\DashboardController::index',);
    $routes->get('kuitansi', 'Bendahara\KuitansiController::index');
    $routes->get('rincian', 'Bendahara\RincianController::index');
});
$routes->group('kepala', function ($routes) {
    $routes->get('', 'Kepala\DashboardController::index');
    $routes->get('verifikasi', 'Kepala\VerifikasiController::index');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
