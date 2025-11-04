<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- RUTE YANG WAJIB LOGIN (Dijaga oleh 'auth') ---
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Rute utama aplikasi
    $routes->get('/', 'Home::index');
    $routes->addRedirect('home', '/'); // Alihkan 'home' ke '/'

    // Rute untuk halaman Akun
    $routes->get('akun', 'Akun::index');
    $routes->post('akun/update_profil', 'Akun::updateProfil');
    $routes->post('akun/update_sandi', 'Akun::updateSandi');

    // --- RUTE UNTUK DATASET (SUDAH DIPERBAIKI) ---
    // Mendefinisikan rute secara manual agar sesuai persis dengan controller dan view
    $routes->get('dataset', 'Dataset::index');
    $routes->post('dataset/save', 'Dataset::save');       // Untuk form tambah manual
    $routes->post('dataset/upload', 'Dataset::upload');   // Untuk form upload CSV
    $routes->get('dataset/export', 'Dataset::export');    // Untuk tombol export
    $routes->delete('dataset/hapusSemua', 'Dataset::hapusSemua');   
    $routes->delete('dataset/delete/(:num)', 'Dataset::delete/$1');

$routes->get('analisis', 'Analisis::index');
$routes->post('analisis/proses', 'Analisis::proses');

// --- RUTE BARU DI BAWAH INI ---
$routes->post('analisis/simpan', 'Analisis::simpan'); // Untuk tombol simpan

// Rute untuk Halaman History
$routes->get('history', 'History::index');
$routes->get('history/delete/(:num)', 'History::delete/$1'); // Hapus pakai method GET agar form-nya mudah
$routes->get('history/detail/(:num)', 'History::detail/$1');

    // ... (kode routes lainnya)


});


// --- RUTE UNTUK TAMU (Dijaga oleh 'guest') ---
$routes->group('', ['filter' => 'guest'], function ($routes) {
    $routes->get('login', 'Auth::index', ['as' => 'login']);
    $routes->get('register', 'Auth::register', ['as' => 'register']);
});


// --- RUTE AKSI PUBLIK (Proses Login, Register, Logout) ---
$routes->post('login', 'Auth::login');
$routes->post('register', 'Auth::processRegister');
$routes->get('logout', 'Auth::logout');
