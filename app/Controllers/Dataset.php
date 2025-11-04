<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DatasetModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Controller untuk mengelola dataset prediksi penurunan penjualan.
 * Diadaptasi untuk 7 kolom (6 Fitur X, 1 Target Y).
 */
class Dataset extends BaseController
{
    protected $datasetModel;

    public function __construct()
    {
        // Inisialisasi Model
        $this->datasetModel = new DatasetModel();
    }

    /**
     * Menampilkan halaman utama dataset dengan semua data.
     */
    public function index()
    {
        $data = [
            'title'     => 'Manajemen Data Latih (Dataset) Penjualan Produk',
            'dataset'   => $this->datasetModel->findAll(), // Ambil semua data
            'active_menu' => 'dataset'
        ];

        return view('dataset/index', $data); // Target: app/Views/dataset/index.php
    }

    /**
     * Menyimpan data baru dari form manual.
     */
    public function save()
    {
        // Validasi input disesuaikan dengan 7 kolom Anda
        $rules = [
            'waktu_penjualan'     => 'required|valid_date[Y-m-d]', // Asumsi input form adalah Y-m-d
            'nama_produk'         => 'required|string|max_length[150]',
            'kategori_produk'     => 'required|string|max_length[100]',
            'harga_produk_rp'     => 'required|numeric|integer',
            'jumlah_terjual_unit' => 'required|numeric|integer',
            'status_promosi'      => 'required|in_list[Ya,Tidak]',
            'terjadi_penurunan'   => 'required|in_list[Ya,Tidak]',
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal
            return redirect()->to('/dataset')->withInput()->with('error', 'Validasi gagal, mohon periksa kembali input Anda.');
        }

        // Simpan data ke database
        $this->datasetModel->save([
            'waktu_penjualan'     => $this->request->getPost('waktu_penjualan'),
            'nama_produk'         => $this->request->getPost('nama_produk'),
            'kategori_produk'     => $this->request->getPost('kategori_produk'),
            'harga_produk_rp'     => $this->request->getPost('harga_produk_rp'),
            'jumlah_terjual_unit' => $this->request->getPost('jumlah_terjual_unit'),
            'status_promosi'      => $this->request->getPost('status_promosi'),
            'terjadi_penurunan'   => $this->request->getPost('terjadi_penurunan'),
        ]);

        return redirect()->to('/dataset')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Memproses file CSV yang di-upload dan menyimpannya ke database.
     */
    public function upload()
    {
        $file = $this->request->getFile('dataset_csv');

        // 1. Validasi File
        if ($file === null || !$file->isValid() || !in_array($file->getMimeType(), ['text/csv', 'application/csv', 'text/plain'])) {
            return redirect()->to('/dataset')->with('error', 'Upload gagal. Pastikan Anda memilih file CSV yang valid.');
        }

        $filePath = $file->getRealPath();
        
        // Membaca file baris per baris
        $fileContent = file($filePath); 
        if ($fileContent === false) {
            return redirect()->to('/dataset')->with('error', 'Gagal membaca isi file CSV.');
        }

        // 2. Parsing CSV dengan delimiter ';'
        try {
            // Kita gunakan str_getcsv dengan delimiter ';'
            $csvData = array_map(function($v){return str_getcsv($v, ";");}, $fileContent);
            
            // Hapus baris header
            array_shift($csvData); 
        } catch (\Exception $e) {
             return redirect()->to('/dataset')->with('error', 'Format CSV tidak valid. Pastikan delimiter adalah titik koma (;).');
        }


        $dataToInsert = [];
        $insertedCount = 0;
        $rowCount = 1; // Mulai dari 1 (setelah header)

        // 3. Loop dan Peta Data
        foreach ($csvData as $row) {
            $rowCount++;
            if (empty($row) || empty($row[0])) {
                continue; // Lewati baris kosong
            }
            
            // Pastikan jumlah kolom sesuai
            if (count($row) < 7) {
                 return redirect()->to('/dataset')->with('error', "Format data salah di baris {$rowCount}. Harap periksa file CSV Anda.");
            }

            // A. Mengolah 'waktu_penjualan' (dari DD/MM/YYYY ke YYYY-MM-DD)
            $waktu_penjualan_raw = trim($row[0]);
            // Cek format, bisa d/m/Y atau Y-m-d (dari file py)
            $dateObj = \DateTime::createFromFormat('d/m/Y', $waktu_penjualan_raw);
            if ($dateObj === false) {
                // Coba format lain jika gagal
                 $dateObj = \DateTime::createFromFormat('Y-m-d', $waktu_penjualan_raw);
            }
            
            if ($dateObj === false) {
                // Jika format tanggal salah
                return redirect()->to('/dataset')->with('error', "Format tanggal salah di baris {$rowCount}. Seharusnya DD/MM/YYYY atau YYYY-MM-DD. Ditemukan: {$waktu_penjualan_raw}");
            }
            $waktu_penjualan_db = $dateObj->format('Y-m-d');

            // B. Mengolah kolom lain (trim untuk hapus spasi)
            // (Kita asumsikan angka sudah bersih dari titik ribuan, sesuai file terakhir Anda)
            $nama_produk = trim($row[1]);
            $kategori_produk = trim($row[2]);
            $harga_produk_rp = (int) trim($row[3]);
            $jumlah_terjual_unit = (int) trim($row[4]);
            $status_promosi = trim($row[5]);
            $terjadi_penurunan = trim($row[6]);

            $dataToInsert[] = [
                'waktu_penjualan'     => $waktu_penjualan_db,
                'nama_produk'         => $nama_produk,
                'kategori_produk'     => $kategori_produk,
                'harga_produk_rp'     => $harga_produk_rp,
                'jumlah_terjual_unit' => $jumlah_terjual_unit,
                'status_promosi'      => $status_promosi,
                'terjadi_penurunan'   => $terjadi_penurunan,
            ];
        }

        // 4. Simpan ke Database
        if (!empty($dataToInsert)) {
            try {
                // Hapus data lama (TRUNCATE) agar data selalu fresh
                $this->datasetModel->emptyTable();
                
                // Insert batch
                $insertedCount = $this->datasetModel->insertBatch($dataToInsert);

            } catch (\Exception $e) {
                return redirect()->to('/dataset')->with('error', 'Terjadi error saat menyimpan ke database: ' . $e->getMessage());
            }
        }

        return redirect()->to('/dataset')->with('success', "Upload selesai! {$insertedCount} baris data baru berhasil diimpor.");
    }

    /**
     * Menghapus semua data dari tabel dataset.
     */
    public function hapusSemua()
    {
        try {
            $tableName = $this->datasetModel->table;
            $countBefore = $this->datasetModel->countAllResults(false);

            if ($countBefore == 0) {
                return redirect()->to('/dataset')->with('info', 'Tidak ada data untuk dihapus.');
            }

            // Gunakan fungsi emptyTable (TRUNCATE) dari model
            $this->datasetModel->emptyTable(); 

            return redirect()->to('/dataset')->with('success', "Semua data ({$countBefore} baris) berhasil dihapus dan di-reset.");
        
        } catch (\Exception $e) {
            log_message('error', 'Error hapusSemua: ' . $e->getMessage());
            return redirect()->to('/dataset')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus satu baris data berdasarkan ID.
     */
    public function delete($id = null)
    {
        // Validasi $id untuk keamanan
        if (!is_numeric($id) || $id === null) {
             return redirect()->to('/dataset')->with('error', 'ID data tidak valid.');
        }

        $dataset = $this->datasetModel->find($id);
        if ($dataset) {
            $this->datasetModel->delete($id);
            return redirect()->to('/dataset')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('/dataset')->with('error', 'Data tidak ditemukan.');
    }

    /**
     * Mengunduh semua data dari tabel sebagai file CSV.
     */
    public function export()
    {
        $data = $this->datasetModel->findAll();
        $filename = 'export_dataset_penjualan_' . date('Y-m-d') . '.csv';

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; charset=utf-8"); // Tambah charset

        $file = fopen('php://output', 'w');
        fputs($file, (chr(0xEF) . chr(0xBB) . chr(0xBF))); // Tambah BOM untuk Excel

        // Tulis baris header (sesuai dengan 7 kolom + id)
        $header = [
            'id',
            'waktu_penjualan',
            'nama_produk',
            'kategori_produk',
            'harga_produk_rp',
            'jumlah_terjual_unit',
            'status_promosi',
            'terjadi_penurunan',
            'created_at',
            'updated_at'
        ];
        // Gunakan ; sebagai delimiter
        fputcsv($file, $header, ';'); 

        // Tulis data baris per baris
        foreach ($data as $row) {
            fputcsv($file, $row, ';'); // Gunakan ; sebagai delimiter
        }

        fclose($file);
        exit;
    }
}

