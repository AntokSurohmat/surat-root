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
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function(){
    return view('auth/error_404');
});
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Auth\Auth::index', ["filter" => "noauth"]);
// // $routes->get('/', ["filter" => "noauth"], 'Auth\Auth::index');
// $routes->match(['get', 'post'], 'login', 'Auth\Auth::index', ["filter" => "noauth"]);
$routes->get('logout', 'Auth\Auth::logout');
$routes->get('forbidden', 'Auth\Auth::forbidden');
$routes->group('admin', ["filter" => "auth"], function ($routes) {
    $routes->get('', 'Admin\Dashboard::index');
    $routes->presenter('Pegawai', ['except' => 'show,remove']);
    $routes->get('pangol', 'Admin\Pangol::index');
    $routes->get('jabatan', 'Admin\Jabatan::index');
    $routes->presenter('Wilayah', ['except' => 'show,remove']);
    $routes->presenter('Instansi', ['except' => 'show,remove']);
    $routes->presenter('Sbuh', ['except' => 'show,remove']);
    $routes->get('rekening', 'Admin\Rekening::index');
    $routes->presenter('Spt', ['except' => 'show,remove']);
    $routes->presenter('Spd', ['except' => 'show,remove']);
    $routes->get('lapspt', 'Admin\Lapspt::index');
    $routes->get('lapspd', 'Admin\Lapspd::index');
});
$routes->group('bendahara', ["filter" => "auth"], function ($routes) {
    $routes->get('', 'Bendahara\Dashboard::index',);
    $routes->presenter('Kuitansi', ['except' => 'show,remove']);
    $routes->get('rincian', 'Bendahara\Rincian::index');
});
$routes->group('kepala', ["filter" => "auth"], function ($routes) {
    $routes->get('', 'Kepala\Dashboard::index');
    $routes->presenter('Verifikasi', ['only' => ['index', 'update']]);
});
$routes->group('pegawai', ["filter" => "auth"], function ($routes) {
    $routes->get('', 'Pegawai\Dashboard::index');
    $routes->get('spt', 'Pegawai\Spt::index');
    $routes->get('spd', 'Pegawai\Spd::index');
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
