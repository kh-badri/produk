<?php

namespace App\Controllers;

class Home extends BaseController
{
    /**
     * Menampilkan halaman beranda (home).
     */
    public function index()
    {
        // Menyiapkan data untuk dikirim ke view
        $data = [
            'title'       => 'Beranda | Aplikasi Klasifikasi KNN',
            'active_menu' => 'home' // Variabel untuk menandai menu 'home' aktif
        ];

        // Memuat view home/index.php dan mengirimkan data di atas
        return view('home/index', $data);
    }
}
