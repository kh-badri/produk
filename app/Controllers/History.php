<?php

// --- PERBAIKAN DI SINI ---
// Namespace harus 'App\Controllers'
namespace App\Controllers;

// Kita harus meng-import BaseController karena kita ada di namespace yang sama
use App\Controllers\BaseController;
// --- AKHIR PERBAIKAN ---

use App\Models\HistoryModel;

class History extends BaseController
{
    protected $historyModel;

    public function __construct()
    {
        $this->historyModel = new HistoryModel();
        helper(['session', 'form']);
    }

    /**
     * Menampilkan halaman riwayat analisis
     */
    public function index()
    {
        $data = [
            'title'       => 'Riwayat Analisis',
            'history'     => $this->historyModel->orderBy('id', 'DESC')->findAll(),
            'active_menu' => 'history' // Untuk menandai menu aktif di layout
        ];

        return view('history/index', $data);
    }

    /**
     * Menghapus satu data riwayat
     */
    public function delete($id = null)
    {
        if ($id === null) {
            return redirect()->to('history')->with('error', 'ID tidak valid.');
        }

        $item = $this->historyModel->find($id);
        if ($item) {
            $this->historyModel->delete($id);
            return redirect()->to('history')->with('success', 'Data riwayat berhasil dihapus.');
        } else {
            return redirect()->to('history')->with('error', 'Data riwayat tidak ditemukan.');
        }
    }

    /**
     * FUNGSI BARU: Menampilkan halaman detail untuk satu riwayat analisis
     */
    public function detail($id = null)
    {
        if ($id === null) {
            return redirect()->to('history')->with('error', 'ID tidak valid.');
        }

        $item = $this->historyModel->find($id);

        if (!$item) {
            return redirect()->to('history')->with('error', 'Data riwayat tidak ditemukan.');
        }

        // Rekonstruksi array $hasil agar view 'hasil.php' bisa membacanya
        // Kita gabungkan kembali data yang tersimpan di DB
        $hasil = [
            'status'   => 'success', // Asumsikan sukses karena data ada
            'analisis' => json_decode($item['hasil_analisis'], true), // decode kolom JSON
            'evaluasi' => json_decode($item['hasil_evaluasi'], true)  // decode kolom JSON
        ];

        $data = [
            'title'       => 'Detail Riwayat Analisis #' . $item['id'],
            'hasil'       => $hasil,
            'item'        => $item, // Kirim juga item aslinya (misal, untuk tanggal)
            'active_menu' => 'history'
        ];

        // Kita akan buat view baru 'history/detail.php'
        return view('history/detail', $data);
    }
}