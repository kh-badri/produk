<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HistoryModel;

class History extends BaseController
{
    protected $historyModel;

    public function __construct()
    {
        $this->historyModel = new HistoryModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Riwayat Klasifikasi',
            'history' => $this->historyModel->orderBy('created_at', 'DESC')->findAll(),
        ];
        return view('history/index', $data);
    }

    /**
     * Menghapus satu data riwayat berdasarkan ID.
     */
    public function delete($id = null)
    {
        // PERBAIKAN: Hapus pengecekan metode request.
        // Fungsi ini sekarang akan langsung memproses penghapusan.
        $data = $this->historyModel->find($id);
        if ($data) {
            $this->historyModel->delete($id);
            return redirect()->to('/history')->with('success', 'Data riwayat berhasil dihapus.');
        }

        // Baris ini akan dijalankan jika data dengan ID tersebut tidak ditemukan.
        return redirect()->to('/history')->with('error', 'Data tidak ditemukan.');
    }
}
