<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');

// Routes Stok Ikan (CRUD)
$routes->get('/stok-ikan', 'StokIkan::index');
$routes->post('/stok-ikan/simpan', 'StokIkan::simpan');
$routes->post('/stok-ikan/simpan-kategori', 'StokIkan::simpanKategori');
$routes->post('/stok-ikan/update/(:num)', 'StokIkan::update/$1');
$routes->get('/stok-ikan/hapus/(:num)', 'StokIkan::hapus/$1');

// Routes Laporan
$routes->get('/laporan-in-out', 'Laporan::inOut');
$routes->get('/cetak-laporan', 'Laporan::cetak');

// Route Live Header Search API
$routes->get('/api/search', 'Search::suggest');

// Routes Profil
$routes->get('/profil/get', 'Profil::get');
$routes->post('/profil/update', 'Profil::update');

// Routes Pengaturan
$routes->get('/pengaturan/get', 'Pengaturan::get');
$routes->post('/pengaturan/update', 'Pengaturan::update');

// Routes Kalender Note
$routes->get('/kalender/notes', 'Kalender::getNotes');
$routes->post('/kalender/save', 'Kalender::saveNote');
$routes->post('/kalender/delete', 'Kalender::deleteNote');

// Routes Kasir (POS Interface)
$routes->get('/kasir/get-ikan', 'Kasir::getIkan');
$routes->post('/kasir/proses', 'Kasir::proses');

// Route Backup & Ekspor Data
$routes->get('/backup/export', 'Backup::export');
