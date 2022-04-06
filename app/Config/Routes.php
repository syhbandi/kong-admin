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

// Routing Verifikasi
$routes->add('verifikasi/top-up', 'Verifikasi::topUp');
$routes->add('verifikasi/pencairan-rider', 'Verifikasi::pencairanRider');
$routes->add('verifikasi/pencairan-toko', 'Verifikasi::pencairanToko');

// Routing rider
$routes->add('rider', 'Rider::index');
$routes->add('rider/top-up', 'Rider::topUp');
$routes->add('rider/detail/(:num)', 'Rider::detail/$1');
$routes->add('rider/pencairan', 'Rider::pencairan');
$routes->add('rider/pengajuan-kendaraan', 'Rider::pengajuanKendaraan');
$routes->add('rider/top-up/detail/(:segment)', 'Rider::detailTopUp/$1');
$routes->add('rider/pencairan/detail/(:segment)', 'Rider::detailPencairan/$1');

// routing toko
$routes->add('pos', 'Pos::index');
$routes->add('pos/detailPos/(:segment)', 'Pos::detailPos/$1');
$routes->add('pos/pencairan', 'Pos::pencairan/index');
$routes->add('pos/pencairan/(:segment)', 'Pos::pencairan/detailPencairan/$1');
$routes->add('pos/barang', 'Pos::barang');
$routes->add('pos/detailBarang/(:segment)', 'Pos::detailBarang/$1');

// routing User marketplace
$routes->add('market', 'Marketplace::index');

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
