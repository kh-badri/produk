<?php 
// File: app/Views/analisis/hasil.php
helper('form');

/**
 * Fungsi helper kecil untuk mencari data fitur dari array $analisis
 * (VERSI AMAN: dengan fallback untuk mencegah error)
 */
if (!function_exists('find_feature_data')) {
    function find_feature_data($analisis_array, $feature_name) {
        // Pengecekan penting jika $analisis_array bukan array
        if (!is_array($analisis_array)) {
             return ['rata_rata_ya_turun' => 0, 'rata_rata_tidak_turun' => 0];
        }
        foreach ($analisis_array as $item) {
            if (isset($item['fitur']) && $item['fitur'] == $feature_name) {
                return $item;
            }
        }
        // Fallback jika tidak ketemu
        return ['rata_rata_ya_turun' => 0, 'rata_rata_tidak_turun' => 0];
    }
}

// --- PERBAIKAN PENTING ---
// Seluruh logika pemrosesan data HARUS berada di dalam cek ini
// untuk mencegah error jika $hasil = null
if (isset($hasil) && $hasil['status'] == 'success') {
    // Ambil data analisis (pengetahuan model)
    $analisis = $hasil['analisis']; 
    // Ambil data evaluasi (akurasi, dll)
    $evaluasi = $hasil['evaluasi']; 

    // Ekstrak data spesifik untuk analisis yang mudah dibaca
    $data_harga = find_feature_data($analisis, 'harga_produk_rp');
    $data_jumlah = find_feature_data($analisis, 'jumlah_terjual_unit');
    $data_bulan = find_feature_data($analisis, 'bulan');

    // Tentukan interpretasi
    $interpretasi_harga = ($data_harga['rata_rata_ya_turun'] > $data_harga['rata_rata_tidak_turun']) 
        ? "Harga Cenderung LEBIH MAHAL" 
        : "Harga Cenderung LEBIH MURAH";
    // Gunakan warna palet #B77466 (Terracotta) untuk "negatif"
    $warna_harga = ($interpretasi_harga == "Harga Cenderung LEBIH MAHAL") ? "text-[#B77466]" : "text-green-600";

    $interpretasi_jumlah = ($data_jumlah['rata_rata_ya_turun'] < $data_jumlah['rata_rata_tidak_turun'])
        ? "Penjualan Cenderung LEBIH SEDIKIT"
        : "Penjualan Cenderung LEBIH BANYAK";
    // Gunakan warna palet #B77466 (Terracotta) untuk "negatif"
    $warna_jumlah = ($interpretasi_jumlah == "Penjualan Cenderung LEBIH SEDIKIT") ? "text-[#B77466]" : "text-green-600";

    $nama_bulan_ya = date('F', mktime(0, 0, 0, (int)$data_bulan['rata_rata_ya_turun'], 10));
    $interpretasi_bulan = "Cenderung terjadi di sekitar bulan " . $nama_bulan_ya;
}
?>

<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<!-- Latar belakang: #FFE1AF (Krem) -->
<div class="w-full min-h-screen bg-[#FFE1AF] p-4 lg:p-8 text-[#957C62]">
    <div class="container mx-auto">

        <!-- Tombol Aksi Atas -->
        <div class="flex justify-between items-center mb-6">
            <!-- Tombol Kembali -->
            <a href="<?= base_url('analisis') ?>" class="text-[#957C62] font-semibold hover:text-[#B77466] transition duration-300 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Analisis
            </a>

            <!-- Tombol Simpan: #957C62 (Coklat Muted) -->
            <?php if (session()->has('hasil_analisis_terakhir')) : ?>
                <?= form_open('analisis/simpan') ?>
                    <button type="submit" class="bg-[#957C62] hover:bg-opacity-80 text-white font-bold py-2 px-5 rounded-lg transition duration-300 shadow-lg transform hover:scale-105 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Hasil Ini
                    </button>
                <?= form_close() ?>
            <?php endif; ?>
        </div>

        <!-- Cek jika $hasil ada dan sukses -->
        <?php if (isset($hasil) && $hasil['status'] == 'success') : ?>

            <!-- Layout Dashboard 2 Kolom -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- ============================================= -->
                <!-- KOLOM KIRI (STICKY): RINGKASAN                -->
                <!-- ============================================= -->
                <div class="lg:col-span-1">
                    <div class="lg:sticky lg:top-8 space-y-6">
                        
                        <!-- Kartu Akurasi (Hero) -->
                        <div class="bg-white p-6 rounded-xl shadow-xl border border-gray-200 text-center">
                            <h3 class="text-lg font-medium text-[#957C62]">Akurasi Prediksi Model</h3>
                            <!-- Akurasi: #B77466 (Terracotta) -->
                            <p class="text-7xl font-bold text-[#B77466] my-3">
                                <?= number_format($evaluasi['accuracy'], 2) ?><span class="text-5xl">%</span>
                            </p>
                            <p class="text-sm text-gray-600">
                                Model berhasil memprediksi <?= number_format($evaluasi['accuracy'], 0) ?> dari 100 data uji dengan benar.
                            </p>
                        </div>

                        <!-- Kartu Faktor Kunci -->
                        <div class="bg-white p-6 rounded-xl shadow-xl border border-gray-200">
                            <h3 class="text-2xl font-semibold text-[#957C62] mb-4 border-b border-[#E2B59A] pb-2">
                                Faktor Kunci Penurunan
                            </h3>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <span class="text-xl mr-3 pt-1">💰</span>
                                    <div>
                                        <span class="font-bold text-gray-800">Harga Produk</span>
                                        <p class="text-sm <?= $warna_harga ?>"><?= $interpretasi_harga ?></p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-xl mr-3 pt-1">📉</span>
                                    <div>
                                        <span class="font-bold text-gray-800">Popularitas</span>
                                        <p class="text-sm <?= $warna_jumlah ?>"><?= $interpretasi_jumlah ?></p>
                                    </div>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-xl mr-3 pt-1">📅</span>
                                    <div>
                                        <span class="font-bold text-gray-800">Waktu</span>
                                        <p class="text-sm text-gray-700"><?= $interpretasi_bulan ?></p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- ============================================= -->
                <!-- KOLOM KANAN (SCROLL): DETAIL TABS           -->
                <!-- ============================================= -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Tampilan Tab Sederhana (Warna Baru) -->
                    <div class="bg-white rounded-xl shadow-xl border border-gray-200 p-2">
                        <nav class="flex space-x-2" id="tabs">
                            <!-- Tab Aktif: #B77466 (Terracotta) -->
                            <button data-tab-target="analisis" class="tab-button active flex-1 text-center font-semibold py-3 px-4 rounded-lg bg-[#B77466] text-white shadow">
                                Hasil Analisis (Interpretasi)
                            </button>
                            <button data-tab-target="evaluasi" class="tab-button flex-1 text-center font-semibold py-3 px-4 rounded-lg text-gray-500 hover:bg-[#FFE1AF]/40 hover:text-[#957C62]">
                                Detail Evaluasi (Teknis)
                            </button>
                        </nav>
                    </div>

                    <!-- KONTEN TAB 1: HASIL ANALISIS -->
                    <div id="analisis" class="tab-content">
                        <div class="bg-white p-6 rounded-xl shadow-xl border border-gray-200 mb-8">
                            <h2 class="text-3xl font-semibold mb-6 text-[#957C62]">
                                Analisis Mendalam Faktor Penentu
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Kartu 1: Analisis Harga -->
                                <div class="bg-[#FFE1AF]/40 p-6 rounded-lg border border-[#E2B59A] shadow-inner">
                                    <div class="flex items-center mb-3">
                                        <span class="text-2xl mr-3">💰</span>
                                        <h3 class="text-xl font-semibold text-[#957C62]">Faktor Harga Produk</h3>
                                    </div>
                                    <p class="text-2xl font-bold <?= $warna_harga ?> mb-2">
                                        <?= $interpretasi_harga ?>
                                    </p>
                                    <p class="text-gray-700 text-sm">
                                        Produk 'Ya Turun' harganya rata-rata <strong>Rp <?= number_format($data_harga['rata_rata_ya_turun'], 0, ',', '.') ?></strong>.
                                        <br>
                                        Produk 'Tidak Turun' harganya rata-rata <strong>Rp <?= number_format($data_harga['rata_rata_tidak_turun'], 0, ',', '.') ?></strong>.
                                    </p>
                                </div>

                                <!-- Kartu 2: Analisis Jumlah Terjual -->
                                <div class="bg-[#FFE1AF]/40 p-6 rounded-lg border border-[#E2B59A] shadow-inner">
                                     <div class="flex items-center mb-3">
                                        <span class="text-2xl mr-3">📉</span>
                                        <h3 class="text-xl font-semibold text-[#957C62]">Faktor Popularitas</h3>
                                    </div>
                                    <p class="text-2xl font-bold <?= $warna_jumlah ?> mb-2">
                                        <?= $interpretasi_jumlah ?>
                                    </p>
                                    <p class="text-gray-700 text-sm">
                                        Produk 'Ya Turun' rata-rata terjual <strong><?= number_format($data_jumlah['rata_rata_ya_turun'], 0, ',', '.') ?> unit/bulan</strong>.
                                        <br>
                                        Produk 'Tidak Turun' rata-rata terjual <strong><?= number_format($data_jumlah['rata_rata_tidak_turun'], 0, ',', '.') ?> unit/bulan</strong>.
                                    </p>
                                </div>
                                
                                <!-- Kartu 3: Analisis Waktu (Bulan) -->
                                <div class="md:col-span-2 bg-[#FFE1AF]/40 p-6 rounded-lg border border-[#E2B59A] shadow-inner">
                                     <div class="flex items-center mb-3">
                                        <span class="text-2xl mr-3">📅</span>
                                        <h3 class="text-xl font-semibold text-[#957C62]">Faktor Waktu (Musiman)</h3>
                                    </div>
                                    <p class="text-2xl font-bold text-gray-800 mb-2">
                                        <?= $interpretasi_bulan ?>
                                    </p>
                                    <p class="text-gray-700 text-sm">
                                        Penurunan penjualan paling sering terjadi pada rata-rata bulan ke-<strong><?= number_format($data_bulan['rata_rata_ya_turun'], 1, ',', '.') ?></strong>.
                                        <br>
                                        Penjualan stabil paling sering terjadi pada rata-rata bulan ke-<strong><?= number_format($data_bulan['rata_rata_tidak_turun'], 1, ',', '.') ?></strong>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KONTEN TAB 2: DETAIL EVALUASI -->
                    <div id="evaluasi" class="tab-content hidden">
                        <div class="bg-white p-6 rounded-xl shadow-xl border border-gray-200 space-y-8">
                            
                            <!-- Bagian: Ringkasan Data -->
                            <div>
                                <h3 class="text-2xl font-semibold text-[#957C62] mb-4">Ringkasan Data</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg text-center">
                                        <span class="text-sm text-gray-500">Total Data</span>
                                        <p class="text-3xl font-bold text-[#957C62]"><?= $evaluasi['total_data'] ?></p>
                                    </div>
                                    <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg text-center">
                                        <span class="text-sm text-gray-500">Data Training (80%)</span>
                                        <p class="text-3xl font-bold text-[#957C62]"><?= $evaluasi['total_training'] ?></p>
                                    </div>
                                    <div class="bg-gray-50 border border-gray-200 p-4 rounded-lg text-center">
                                        <span class="text-sm text-gray-500">Data Testing (20%)</span>
                                        <p class="text-3xl font-bold text-[#957C62]"><?= $evaluasi['total_testing'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bagian: Confusion Matrix -->
                            <div>
                                <h3 class="text-2xl font-semibold text-[#957C62] mb-4">Confusion Matrix</h3>
                                <?php $cm = $evaluasi['confusion_matrix']; ?>
                                <div class="overflow-x-auto">
                                    <table class="w-full border-collapse border border-[#E2B59A]">
                                        <thead>
                                            <tr>
                                                <th class="p-3 border border-[#E2B59A]"></th>
                                                <th class="p-3 border border-[#E2B59A] bg-gray-100" colspan="2">Prediksi Model</th>
                                            </tr>
                                            <tr>
                                                <th class="p-3 border border-[#E2B59A] bg-gray-100">Data Aktual</th>
                                                <th class="p-3 border border-[#E2B59A] bg-[#FFE1AF]/40">Prediksi: TIDAK</th>
                                                <th class="p-3 border border-[#E2B59A] bg-[#B77466]/20">Prediksi: YA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-center">
                                                <th class="p-4 border border-[#E2B59A] bg-[#FFE1AF]/40">Aktual: TIDAK</th>
                                                <td class="p-4 border border-[#E2B59A] bg-green-100 text-green-900 font-bold text-xl">
                                                    <?= $cm['true_negative'] ?> <span class="block text-xs font-normal">(True Negative)</span>
                                                </td>
                                                <td class="p-4 border border-[#E2B59A] bg-red-100 text-red-900 font-bold text-xl">
                                                    <?= $cm['false_positive'] ?> <span class="block text-xs font-normal">(False Positive)</span>
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th class="p-4 border border-[#E2B59A] bg-[#B77466]/20">Aktual: YA</th>
                                                <td class="p-4 border border-[#E2B59A] bg-red-100 text-red-900 font-bold text-xl">
                                                    <?= $cm['false_negative'] ?> <span class="block text-xs font-normal">(False Negative)</span>
                                                </td>
                                                <td class="p-4 border border-[#E2B59A] bg-green-100 text-green-900 font-bold text-xl">
                                                    <?= $cm['true_positive'] ?> <span class="block text-xs font-normal">(True Positive)</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Bagian: Classification Report -->
                            <div>
                                <h3 class="text-2xl font-semibold text-[#957C62] mb-4">Detail Performa (Per Kelas)</h3>
                                <?php $report = $evaluasi['classification_report']; ?>
                                <table class="w-full border-collapse border border-[#E2B59A]">
                                     <thead class="bg-gray-100">
                                        <tr>
                                            <th class="p-3 border border-[#E2B59A] text-left">Kelas</th>
                                            <th class="p-3 border border-[#E2B59A] text-center">Precision</th>
                                            <th class="p-3 border border-[#E2B59A] text-center">Recall</th>
                                            <th class="p-3 border border-[#E2B59A] text-center">F1-Score</th>
                                            <th class="p-3 border border-[#E2B59A] text-center">Support</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <th class="p-3 border border-[#E2B59A] text-left bg-[#FFE1AF]/40">Tidak (Penurunan)</th>
                                            <td class="p-3 border border-[#E2B59A]"><?= number_format($report['Tidak']['precision'], 2) ?></td>
                                            <td class="p-3 border border-[#E2B59A]"><?= number_format($report['Tidak']['recall'], 2) ?></td>
                                            <td class="p-3 border border-[#E2B59A]"><?= number_format($report['Tidak']['f1-score'], 2) ?></td>
                                            <td class="p-3 border border-[#E2B59A]"><?= $report['Tidak']['support'] ?></td>
                                        </tr>
                                        <tr class="text-center">
                                            <th class="p-3 border border-[#E2B59A] text-left bg-[#B77466]/20">Ya (Penurunan)</th>
                                            <td class="p-3 border border-[#E2B59A]"><?= number_format($report['Ya']['precision'], 2) ?></td>
                                            <td class="p-3 border border-[#E2B59A]"><?= number_format($report['Ya']['recall'],.2) ?></td>
                                            <td class="p-3 border border-[#E2B59A]"><?= number_format($report['Ya']['f1-score'], 2) ?></td>
                                            <td class="p-3 border border-[#E2B59A]"><?= $report['Ya']['support'] ?></td>
                                        </tr>
                                        <tr class="text-center bg-gray-50 font-bold">
                                            <th class="p-3 border border-[#E2B59A] text-left">Rata-rata (Weighted)</th>
                                            <td class="p-3 border border-[#E2B59A]"><?= number_format($report['weighted avg']['precision'], 2) ?></td>
                                            <td class="p-3 border border-[#E2B59A]"><?= number_format($report['weighted avg']['recall'], 2) ?></td>
                                            <td class="p-3 border border-[#E2B59A]"><?= number_format($report['weighted avg']['f1-score'], 2) ?></td>
                                            <td class="p-3 border border-[#E2B59A]"><?= $report['weighted avg']['support'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php else : ?>
             <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-md" role="alert">
                <p class="font-bold">Analisis Gagal</p>
                <p>Skrip Python berhasil dijalankan tetapi mengembalikan error.</p>
                <?php if(isset($hasil['message'])): ?>
                    <p class="mt-2 text-sm"><strong>Detail Error:</strong> <?= esc($hasil['message']) ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- JavaScript Sederhana untuk Tab (Warna Baru) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-button');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.tabTarget;

                // Nonaktifkan semua tab
                tabs.forEach(t => {
                    t.classList.remove('active', 'bg-[#B77466]', 'text-white', 'shadow');
                    t.classList.add('text-gray-500', 'hover:bg-[#FFE1AF]/40', 'hover:text-[#957C62]');
                });

                // Aktifkan tab yang diklik
                tab.classList.add('active', 'bg-[#B77466]', 'text-white', 'shadow');
                tab.classList.remove('text-gray-500', 'hover:bg-[#FFE1AF]/40', 'hover:text-[#957C62]');

                // Sembunyikan semua konten
                contents.forEach(c => {
                    c.classList.add('hidden');
                });

                // Tampilkan konten yang targetnya sesuai
                document.getElementById(target).classList.remove('hidden');
            });
        });
    });
</script>

<?= $this->endSection(); ?>