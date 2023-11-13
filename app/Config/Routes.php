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
$routes->add('rider/kendaraan', 'Rider::Kendaraan');
$routes->add('rider/verifikasi', 'Rider::verifikasi');
$routes->add('rider/update_app', 'Rider::update_app');
$routes->add('rider/top-up/detail/(:segment)', 'Rider::detailTopUp/$1');
$routes->add('rider/pencairan/detail/(:segment)', 'Rider::detailPencairan/$1');

// routing toko
$routes->add('pos', 'Pos::index');
$routes->add('pos/detailPos/(:segment)', 'Pos::detailPos/$1');
$routes->add('pos/pencairan', 'Pos::pencairan/index');
$routes->add('pos/pencairan/(:segment)', 'Pos::pencairan/detailPencairan/$1');
$routes->add('pos/barang', 'Pos::barang');
$routes->add('pos/barangc/(:segment)', 'Pos::barangc/$1');
$routes->add('pos/detailBarang/(:segment)', 'Pos::detailBarang/$1');
$routes->add('pos/update_app', 'Pos::update_app');
$routes->add('pos/verifikasiPencairan', 'Pos::verifikasiPencairan');

// routing User marketplace
$routes->add('market', 'Marketplace::index');
$routes->add('market/detailMp/(:segment)', 'Marketplace::detail_user/$1');

// kontrak
$routes->add('kontrak', 'KontrakController::index');
$routes->add('kontrak/detailkontrak/(:segment)', 'KontrakController::detailkontrak/$1');

// mapper
$routes->add('bayar-mapper', 'MapperController::index');
$routes->add('verifikasi', 'MapperController::verifikasiPembayaran');
// $routes->add('kontrak/detailkontrak/(:segment)', 'KontrakController::detailkontrak/$1');

//tarif
$routes->add('tarif', 'Transaksi::index');
$routes->add('transaksi', 'Alltransaksi::index');
// bank
$routes->add('bank', 'BankController::index');
//atribut
$routes->add('atribut', 'AtributController::index');
$routes->add('atribut/transaksi', 'AtributController::transaksi');
// analisis toko dan rider
$routes->add('cek_rider', 'Ridertokoon::index');
$routes->add('cek_toko', 'Ridertokoon::toko');
$routes->add('cek_driver', 'Ridertokoon::driver');

//ajax  routes
$routes->add('pos/getToko/(:segment)', 'Pos::getToko/$1');
$routes->add('pos/getBarang/(:segment)', 'Pos::getBarang/$1');
$routes->add('pos/getjmlbrng/(:segment)', 'Pos::getjmlbrng/$1');
$routes->add('pos/getPencairan/(:segment)', 'Pos::getPencairan/$1');
$routes->add('pos/verivikasiBarang', 'Pos::verivikasiBarang');
$routes->add('pos/verivikasiToko', 'Pos::verivikasiToko');
$routes->add('pos/editkategori', 'Pos::editkategori');

$routes->add('AtributController/getattr', 'AtributController::getattr');
$routes->add('AtributController/getbaykd', 'AtributController::getbaykd');
$routes->add('AtributController/editattr', 'AtributController::editattr');


$routes->add('BankController/getbank', 'BankController::getbank');
$routes->add('BankController/getbaykd', 'BankController::getbaykd');
$routes->add('BankController/editbank', 'BankController::editbank');

$routes->add('getkontrak/(:any)', 'KontrakController::getkontrak/$1');
$routes->add('KontrakController/updatekontrak', 'KontrakController::updatekontrak');

$routes->add('rider/getRider/(:segment)', 'Rider::getRider/$1');
$routes->add('rider/getKendaraan/(:segment)', 'Rider::getKendaraan/$1');
$routes->add('rider/getPencairan/(:any)', 'Rider::getPencairan/$1');
$routes->add('rider/getTopUp/(:any)', 'Rider::getTopUp/$1');
$routes->add('rider/perbaikan', 'Rider::perbaikan');
$routes->add('rider/verifikasi', 'Rider::verifikasi');
$routes->add('rider/verifikasiPencairan', 'Rider::verifikasiPencairan');
$routes->add('rider/verifikasiTopUp', 'Rider::verifikasiTopUp');

$routes->add('Ridertokoon/getDriver/(:segment)', 'Ridertokoon::getDriver/$1');
$routes->add('Ridertokoon/getRider/(:segment)', 'Ridertokoon::getRider/$1');
$routes->add('Ridertokoon/getToko/(:segment)', 'Ridertokoon::getToko/$1');

$routes->add('Transaksi/updatezona', 'Transaksi::updatezona');
$routes->add('Transaksi/addzona', 'Transaksi::addzona');
$routes->add('Transaksi/show', 'Transaksi::show');
$routes->add('Transaksi/tarif', 'Transaksi::tarif');

$routes->add('Marketplace/getmpUser/(:segment)', 'Marketplace::getmpUser/$1');
$routes->add('Marketplace/update', 'Marketplace::update');



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
