<?php

namespace App\Controllers;

// Import Model baru
use App\Models\HistoryModel;

class Analisis extends BaseController
{
    protected $session;
    protected $db;
    protected $historyModel; // Tambahkan properti model

    protected $pythonCmd = 'python';

    public function __construct()
    {
        $this->session = session();
        $this->db = \Config\Database::connect();
        $this->historyModel = new HistoryModel(); // Inisialisasi model
    }

    /**
     * Halaman form analisis (Tombol "Mulai Analisis")
     */
    public function index()
    {
        $data = [
            'title'       => 'Analisis Prediksi Naive Bayes',
            'error'       => $this->session->getFlashdata('error'),
            'active_menu' => 'analisis'
        ];
        return view('analisis/index', $data);
    }

    /**
     * Proses analisis Naive Bayes (hybrid Python)
     */
    public function proses()
    {
        try {
            // 1. Ambil Kredensial DB
            $db_host = $this->db->hostname;
            $db_user = $this->db->username;
            $db_pass = $this->db->password;
            $db_name = $this->db->database;

            // Path ke skrip di folder 'writable'
            $scriptPath = WRITEPATH . "python/run_analysis_nb.py";

            if (!file_exists($scriptPath)) {
                 throw new \RuntimeException("File skrip Python tidak ditemukan. Path: " . $scriptPath);
            }

            // Amankan argumen
            $host_arg = escapeshellarg($db_host);
            $user_arg = escapeshellarg($db_user);
            $pass_arg = escapeshellarg($db_pass);
            $name_arg = escapeshellarg($db_name);

            // 2. Bangun Perintah
            $command = "{$this->pythonCmd} \"{$scriptPath}\" {$host_arg} {$user_arg} {$pass_arg} {$name_arg} 2>&1";

            exec($command, $output, $returnVar);
            $fullOutput = implode("\n", $output);

            if ($returnVar !== 0) {
                throw new \RuntimeException("Error saat menjalankan Python Naive Bayes: " . $fullOutput);
            }

            $hasil = json_decode($fullOutput, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException("Gagal parsing hasil Python (bukan JSON). Output: " . $fullOutput);
            }

            if (isset($hasil['error']) || $hasil['status'] == 'error') {
                $errorMsg = $hasil['message'] ?? 'Error tidak diketahui dari Python';
                throw new \RuntimeException("Script Python melaporkan error: " . $errorMsg);
            }

            // --- PERUBAHAN BARU: Simpan hasil ke session ---
            // Persis seperti contoh Apriori Anda
            $this->session->set('hasil_analisis_terakhir', $hasil);
            // ---------------------------------------------

            // 3. Tampilkan Halaman Hasil
            return view('analisis/hasil', [
                'title'       => 'Hasil Analisis Naive Bayes',
                'hasil'       => $hasil,
                'active_menu' => 'analisis'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error Analisis Naive Bayes: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Simpan hasil dari session ke database history
     */
    public function simpan()
    {
        // Ambil data dari session
        $hasilTerakhir = $this->session->get('hasil_analisis_terakhir');
        
        if (empty($hasilTerakhir)) {
            return redirect()->to('analisis')->with('error', 'Tidak ada hasil analisis untuk disimpan.');
        }

        try {
            // Siapkan data untuk disimpan
            $dataToSave = [
                'tanggal_analisis' => date('Y-m-d H:i:s'),
                'accuracy'         => $hasilTerakhir['evaluasi']['accuracy'],
                'total_data'       => $hasilTerakhir['evaluasi']['total_data'],
                'hasil_analisis'   => json_encode($hasilTerakhir['analisis']),
                'hasil_evaluasi'   => json_encode($hasilTerakhir['evaluasi']) // Simpan semua data evaluasi
            ];

            // Simpan ke DB menggunakan Model
            $this->historyModel->save($dataToSave);

            // Hapus session agar tidak bisa disimpan dua kali
            $this->session->remove('hasil_analisis_terakhir');

            // Arahkan ke halaman history (yang akan kita buat)
            return redirect()->to('history')->with('success', 'Hasil analisis berhasil disimpan ke riwayat.');

        } catch (\Exception $e) {
            log_message('error', 'Gagal simpan history: ' . $e->getMessage());
            return redirect()->to('analisis')->with('error', 'Terjadi kesalahan saat menyimpan ke database: ' . $e->getMessage());
        }
    }
}