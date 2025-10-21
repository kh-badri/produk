<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DatasetModel;
use App\Models\HistoryModel; // TAMBAHKAN INI

class Klasifikasi extends BaseController
{
    protected $datasetModel;
    protected $historyModel; // TAMBAHKAN INI

    public function __construct()
    {
        $this->datasetModel = new DatasetModel();
        $this->historyModel = new HistoryModel(); // TAMBAHKAN INI
    }

    /**
     * Menampilkan halaman form input untuk klasifikasi.
     */
    public function index()
    {
        $data = [
            'title' => 'Halaman Klasifikasi KNN',
        ];
        return view('klasifikasi/index', $data);
    }

    /**
     * Memproses data input dan menjalankan algoritma KNN.
     */
    public function proses()
    {
        // 1. Validasi Input dari Form
        $rules = [
            'durasi_layar'  => 'required|numeric|greater_than[0]',
            'durasi_sosmed' => 'required|numeric|greater_than_equal_to[0]',
            'durasi_tidur'  => 'required|numeric|greater_than[0]',
            'k'             => 'required|integer|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Input tidak valid. Harap periksa kembali semua field.');
        }

        $dataset = $this->datasetModel->findAll();

        if (empty($dataset)) {
            return redirect()->back()->with('error', 'Data latih (dataset) masih kosong. Harap isi data terlebih dahulu.');
        }

        $dataUji = [
            'durasi_layar'  => (float) $this->request->getPost('durasi_layar'),
            'durasi_sosmed' => (float) $this->request->getPost('durasi_sosmed'),
            'durasi_tidur'  => (float) $this->request->getPost('durasi_tidur'),
        ];
        $k = (int) $this->request->getPost('k');

        if ($k > count($dataset)) {
            return redirect()->back()->withInput()->with('error', "Nilai K ({$k}) tidak boleh lebih besar dari jumlah data latih (" . count($dataset) . ").");
        }

        // --- MULAI ALGORITMA KNN ---
        $jarak = [];
        foreach ($dataset as $dataLatih) {
            $jarakEuclidean = sqrt(
                pow($dataLatih['durasi_layar'] - $dataUji['durasi_layar'], 2) +
                    pow($dataLatih['durasi_sosmed'] - $dataUji['durasi_sosmed'], 2) +
                    pow($dataLatih['durasi_tidur'] - $dataUji['durasi_tidur'], 2)
            );

            $jarak[] = [
                'id'             => $dataLatih['id'],
                'durasi_layar'   => $dataLatih['durasi_layar'],
                'durasi_sosmed'  => $dataLatih['durasi_sosmed'],
                'durasi_tidur'   => $dataLatih['durasi_tidur'],
                'resiko_depresi' => $dataLatih['resiko_depresi'],
                'jarak'          => $jarakEuclidean,
            ];
        }

        usort($jarak, function ($a, $b) {
            return $a['jarak'] <=> $b['jarak'];
        });

        $tetanggaTerdekat = array_slice($jarak, 0, $k);
        $voting = array_count_values(array_column($tetanggaTerdekat, 'resiko_depresi'));
        arsort($voting);
        $hasilKlasifikasi = key($voting);
        // --- SELESAI ALGORITMA KNN ---

        $dataHasil = [
            'title'            => 'Hasil Klasifikasi KNN',
            'data_uji'         => $dataUji,
            'k'                => $k,
            'perhitungan_jarak' => $jarak,
            'tetangga_terdekat' => $tetanggaTerdekat,
            'hasil_voting'     => $voting,
            'hasil_klasifikasi' => $hasilKlasifikasi,
        ];

        return view('klasifikasi/hasil', $dataHasil);
    }

    /**
     * FUNGSI BARU UNTUK MENYIMPAN HASIL KLASIFIKASI
     */
    public function simpan()
    {
        // Ambil data dari hidden form di halaman hasil
        $dataToSave = [
            'durasi_layar'      => $this->request->getPost('durasi_layar'),
            'durasi_sosmed'     => $this->request->getPost('durasi_sosmed'),
            'durasi_tidur'      => $this->request->getPost('durasi_tidur'),
            'k'                 => $this->request->getPost('k'),
            'hasil_klasifikasi' => $this->request->getPost('hasil_klasifikasi'),
        ];

        // Simpan data menggunakan HistoryModel
        $this->historyModel->save($dataToSave);

        // Redirect ke halaman history dengan pesan sukses
        // (Kita akan buat halaman history selanjutnya)
        return redirect()->to('/history')->with('success', 'Hasil klasifikasi berhasil disimpan ke riwayat.');
    }
}
