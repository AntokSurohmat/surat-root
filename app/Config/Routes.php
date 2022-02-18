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
$routes->add('/', 'Home::index');
$routes->add('login', 'Auth\LoginController::index');
$routes->group('admin', function ($routes) {
    $routes->add('', 'Admin\DashboardController::index', ['as' => 'admin.index']);
    $routes->add('pegawai', 'Admin\PegawaiController::index', ['as' => 'admin.pegawai']);
    $routes->add('pangol', 'Admin\PangolController::index', ['as' => 'admin.pangol']);
    $routes->add('jabatan', 'Admin\JabatanController::index', ['as' => 'admin.jabatan']);
    $routes->add('wilayah', 'Admin\WilayahController::index', ['as' => 'admin.wilayah']);
    $routes->add('instansi', 'Admin\InstansiController::index', ['as' => 'admin.instansi']);
    $routes->add('sbuh', 'Admin\SbuhController::index', ['as' => 'admin.sbuh']);
    $routes->add('rekening', 'Admin\RekeningController::index', ['as' => 'admin.rekening']);
    $routes->add('spt', 'Admin\SptController::index', ['as' => 'admin.spt']);
    $routes->add('spd', 'Admin\SpdController::index', ['as' => 'admin.spd']);
    $routes->add('lapspt', 'Admin\LapsptController::index', ['as' => 'admin.lapspt']);
    $routes->add('lapspd', 'Admin\LapspdController::index', ['as' => 'admin.lapspd']);
});
$routes->group('pegawai', function ($routes) {
    $routes->add('', 'Pegawai\DashboardController::index', ['as' => 'pegawai.index']);
    $routes->add('spt', 'Pegawai\SptController::index', ['as' => 'pegawai.spt']);
    $routes->add('spd', 'Pegawai\SpdController::index', ['as' => 'pegawai.spd']);
});
$routes->group('bendahara', function ($routes) {
    $routes->add('', 'Bendahara\DashboardController::index', ['as' => 'bendahara.index']);
    $routes->add('kuitansi', 'Bendahara\KuitansiController::index', ['as' => 'bendahara.kuitansi']);
    $routes->add('rincian', 'Bendahara\RincianController::index', ['as' => 'bendahara.rincian']);
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
