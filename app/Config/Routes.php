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
$routes->group('/', ["filter" => "noauth"], function ($routes) {
    $routes->get('', 'Auth\Auth::index');
    $routes->get('', 'Auth\Auth::index');
    $routes->get('auth/login', 'Auth\Auth::login');
    $routes->get('auth/logout', 'Auth\Auth::logout');
});
// // $routes->get('/', ["filter" => "noauth"], 'Auth\Auth::index');
// $routes->match(['get', 'post'], 'login', 'Auth\Auth::index', ["filter" => "noauth"]);
$routes->get('forbidden', 'Auth\Auth::forbidden');
$routes->group('admin', ["filter" => "auth"], function ($routes) {
    $routes->get('', 'Admin\Dashboard::index');
    $routes->presenter('Pegawai', ['controller' =>'Admin\Pegawai', 'except' => 'show,remove']);
    $routes->get('pangol', 'Admin\Pangol::index');
    $routes->get('jabatan', 'Admin\Jabatan::index');
    $routes->presenter('Wilayah', ['controller' =>'Admin\Wilayah', 'except' => 'show,remove']);
    $routes->presenter('Instansi', ['controller' =>'Admin\Instansi', 'except' => 'show,remove']);
    $routes->presenter('Sbuh', ['except' => 'show,remove']);
    $routes->get('rekening', 'Admin\Rekening::index');
    $routes->group('Spt', function ($routes) {
        $routes->presenter('', ['controller' =>'Admin\Spt', 'except' => 'show,remove']);
        $routes->get('print/(:num)', 'Admin\Spt::print/$1');
        $routes->post('savemodal', 'Admin\Spt::savemodal');
    });
    $routes->group('Spd', function ($routes) {
        $routes->presenter('', ['controller' =>'Admin\Spd', 'except' => 'show,remove,edit,update']);
        $routes->get('edit-depan/(:any)', 'Admin\Spd::edit_depan/$1');
        $routes->post('update-depan/(:num)', 'Admin\Spd::update_depan/$1');
        $routes->get('edit-belakang/(:num)', 'Admin\Spd::edit_belakang/$1');
        $routes->post('update-belakang/(:num)', 'Admin\Spd::update_belakang/$1');
        $routes->get('print-depan/(:num)', 'Admin\Spd::print_depan/$1');
        $routes->get('print-belakang/(:num)', 'Admin\Spd::print_belakang/$1');
        $routes->get('print-detail/(:num)', 'Admin\Spd::print_template/$1');
        $routes->get('print/(:num)', 'Admin\Spd::print/$1');
    });
    $routes->group('lapspt', function ($routes) {
        $routes->get('', 'Admin\Lapspt::index');
        $routes->get('print-all-data', 'Admin\Lapspt::print_all');
        $routes->get('download-all-data', 'Admin\Lapspt::download_all');
        $routes->get('print-recap-data', 'Admin\Lapspt::print_recap');
        $routes->get('download-recap-data', 'Admin\Lapspt::download_recap');
    });
    $routes->group('lapspd', function ($routes) {
        $routes->get('', 'Admin\Lapspd::index');
        $routes->get('print-all-data', 'Admin\Lapspd::print_all');
        $routes->get('download-all-data', 'Admin\Lapspd::download_all');
        $routes->get('print-recap-data', 'Admin\Lapspd::print_recap');
        $routes->get('download-recap-data', 'Admin\Lapspd::download_recap');
    });

});
$routes->group('bendahara', ["filter" => "auth", "filter" => "auth"], function ($routes) {
    $routes->get('', 'Bendahara\Dashboard::index',);
    $routes->presenter('Kuitansi', ['controller' =>'Bendahara\Spt', 'except' => 'show,remove']);
    $routes->get('Kuitansi/print/(:num)', 'Bendahara\Kuitansi::print/$1');
    $routes->presenter('Rincian', ['controller' =>'Bendahara\Spt', 'except' => 'show,remove']);
    $routes->get('Rincian/print/(:num)', 'Bendahara\Rincian::print/$1');
});
$routes->group('kepala', ["filter" => "auth"], function ($routes) {
    $routes->get('', 'Kepala\Dashboard::index');
    $routes->presenter('Verifikasi', ['controller' =>'Kepala\Verifikasi', 'only' => ['index', 'update']]);
    $routes->resource('Kuitansi', ['controller' =>'Kepala\Spt', 'except' => 'show,remove']);
    $routes->get('Kuitansi/print/(:num)', 'Kepala\Kuitansi::print/$1');
    $routes->resource('Rincian', ['controller' =>'Kepala\Spt', 'except' => 'show,remove']);
    $routes->get('Rincian/print/(:num)', 'Kepala\Rincian::print/$1');
    $routes->group('lapspt', function ($routes) {
        $routes->get('', 'Kepala\Lapspt::index');
        $routes->get('print-all-data', 'Kepala\Lapspt::print_all');
        $routes->get('download-all-data', 'Kepala\Lapspt::download_all');
        $routes->get('print-recap-data', 'Kepala\Lapspt::print_recap');
        $routes->get('download-recap-data', 'Kepala\Lapspt::download_recap');
    });
    $routes->group('lapspd', function ($routes) {
        $routes->get('', 'Kepala\Lapspd::index');
        $routes->get('print-all-data', 'Kepala\Lapspd::print_all');
        $routes->get('download-all-data', 'Kepala\Lapspd::download_all');
        $routes->get('print-recap-data', 'Kepala\Lapspd::print_recap');
        $routes->get('download-recap-data', 'Kepala\Lapspd::download_recap');
    });
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
