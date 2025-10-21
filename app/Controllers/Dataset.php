<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DatasetModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Dataset extends BaseController
{
    protected $datasetModel;

    public function __construct()
    {
        // Inisialisasi Model di constructor agar bisa dipakai di semua method
        $this->datasetModel = new DatasetModel();
    }

    /**
     * Menampilkan halaman utama dataset dengan semua data.
     */
    public function index()
    {
        $data = [
            'title'   => 'Manajemen Data Latih (Dataset)',
            'dataset' => $this->datasetModel->findAll(), // Ambil semua data
        ];

        return view('dataset/index', $data); // Pastikan view ada di 'app/Views/dataset/index.php'
    }

    /**
     * Menyimpan data baru dari form manual.
     */
    public function save()
    {
        // Validasi input
        $rules = [
            'durasi_layar'   => 'required|numeric',
            'durasi_sosmed'  => 'required|numeric',
            'durasi_tidur'   => 'required|numeric',
            'resiko_depresi' => 'required|in_list[Rendah,Sedang,Tinggi]',
        ];

        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan dengan pesan error
            return redirect()->to('/dataset')->withInput()->with('error', 'Validasi gagal, mohon periksa kembali input Anda.');
        }

        // Simpan data ke database menggunakan model
        $this->datasetModel->save([
            'durasi_layar'   => $this->request->getPost('durasi_layar'),
            'durasi_sosmed'  => $this->request->getPost('durasi_sosmed'),
            'durasi_tidur'   => $this->request->getPost('durasi_tidur'),
            'resiko_depresi' => $this->request->getPost('resiko_depresi'),
        ]);

        return redirect()->to('/dataset')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Memproses file CSV yang di-upload dan menyimpannya ke database.
     */
    public function upload()
    {
        // 1. Validasi File
        $validationRule = [
            'dataset_csv' => [
                'label' => 'File CSV',
                'rules' => 'uploaded[dataset_csv]'
                    . '|ext_in[dataset_csv,csv]'
                    . '|max_size[dataset_csv,2048]', // max 2MB
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->to('/dataset')->withInput()->with('error', $this->validator->getErrors()['dataset_csv']);
        }

        $file = $this->request->getFile('dataset_csv');

        // Cek apakah file valid dan benar-benar bisa dibaca sebelum diproses
        if (!$file->isValid() || $file->hasMoved()) {
            return redirect()->to('/dataset')->with('error', 'Terjadi masalah saat mengupload file.');
        }

        // 2. Baca file CSV dengan lebih aman
        $filePath = $file->getRealPath();
        if ($filePath === false) {
            return redirect()->to('/dataset')->with('error', 'Gagal mendapatkan path file sementara.');
        }

        $fileContent = file($filePath);
        if ($fileContent === false) {
            return redirect()->to('/dataset')->with('error', 'Gagal membaca isi file CSV.');
        }
        $csvData = array_map('str_getcsv', $fileContent);

        // Hapus baris header
        array_shift($csvData);

        $dataToInsert = [];
        $insertedCount = 0;

        // 3. Looping setiap baris data
        foreach ($csvData as $row) {
            // Pastikan baris tidak kosong untuk menghindari error
            if (empty($row) || empty($row[0])) {
                continue;
            }

            // PENTING: Sesuaikan indeks [ ] dengan urutan kolom di file CSV Anda
            // Asumsi struktur CSV: user_id,age,gender,durasi_layar,durasi_sosmed,durasi_tidur,resiko_depresi
            $dataToInsert[] = [
                'durasi_layar'   => (float) ($row[3] ?? 0),
                'durasi_sosmed'  => (float) ($row[4] ?? 0),
                'durasi_tidur'   => (float) ($row[5] ?? 0),
                'resiko_depresi' => trim($row[6] ?? 'Rendah'),
            ];
        }

        // 4. Simpan data secara massal (batch insert) jika ada data yang akan dimasukkan
        if (!empty($dataToInsert)) {
            try {
                $insertedCount = $this->datasetModel->insertBatch($dataToInsert);
            } catch (\Exception $e) {
                // Tangkap jika ada error dari database
                return redirect()->to('/dataset')->with('error', 'Terjadi error saat menyimpan ke database: ' . $e->getMessage());
            }
        }

        return redirect()->to('/dataset')->with('success', "Upload selesai! {$insertedCount} baris data baru berhasil diimpor.");
    }

    /**
     * Menghapus semua data dari tabel dataset.
     */
    /**
     * Menghapus semua data dari tabel dataset.
     */
    /**
     * Menghapus semua data dari tabel dataset.
     */
    public function hapusSemua()
    {
        // Terima POST atau DELETE method
        $method = strtolower($this->request->getMethod());

        // Jika bukan POST/DELETE, coba cek apakah ada method spoofing
        if (!in_array($method, ['post', 'delete'])) {
            // Cek _method dari form (method spoofing CI4)
            $spoofedMethod = strtolower($this->request->getPost('_method') ?? '');
            if (!in_array($spoofedMethod, ['post', 'delete'])) {
                log_message('debug', 'hapusSemua - Method tidak valid: ' . $method);
                return redirect()->to('/dataset')->with('error', 'Akses tidak diizinkan.');
            }
        }

        try {
            // Ambil nama tabel dari model
            $tableName = $this->datasetModel->table;

            // Cek jumlah data sebelum dihapus
            $countBefore = $this->datasetModel->countAllResults(false);

            if ($countBefore == 0) {
                return redirect()->to('/dataset')->with('info', 'Tidak ada data untuk dihapus.');
            }

            // Metode 1: Menggunakan emptyTable() - paling efektif untuk menghapus semua data
            $this->datasetModel->emptyTable();

            // Reset auto-increment
            $this->datasetModel->db->query("ALTER TABLE {$tableName} AUTO_INCREMENT = 1");

            return redirect()->to('/dataset')->with('success', "Semua data berhasil dihapus ({$countBefore} baris).");
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
        // Gunakan method spoofing, jadi kita cek method DELETE
        if ($this->request->getMethod() === 'delete') {
            $dataset = $this->datasetModel->find($id);
            if ($dataset) {
                $this->datasetModel->delete($id);
                return redirect()->to('/dataset')->with('success', 'Data berhasil dihapus.');
            }
            return redirect()->to('/dataset')->with('error', 'Data tidak ditemukan.');
        }
        // Redirect jika diakses dengan cara yang tidak seharusnya
        return redirect()->to('/dataset')->with('error', 'Akses tidak diizinkan.');
    }

    /**
     * Mengunduh semua data dari tabel sebagai file CSV.
     */
    public function export()
    {
        $data = $this->datasetModel->findAll();
        $filename = 'export_dataset_' . date('Y-m-d') . '.csv';

        // Set header untuk memicu download di browser
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        // Buka output stream PHP untuk menulis file
        $file = fopen('php://output', 'w');

        // Tulis baris header
        $header = ['id', 'durasi_layar', 'durasi_sosmed', 'durasi_tidur', 'resiko_depresi', 'created_at', 'updated_at'];
        fputcsv($file, $header);

        // Tulis data baris per baris
        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
        // Hentikan eksekusi skrip agar tidak ada output lain yang tercetak
        exit;
    }
}
