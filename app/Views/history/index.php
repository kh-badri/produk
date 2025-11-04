<?php 
helper('form');

// --- Fungsi helper PHP (Sudah Benar) ---
if (!function_exists('find_feature_data')) {
    function find_feature_data($analisis_array, $feature_name) {
        if (!is_array($analisis_array)) {
             return ['rata_rata_ya_turun' => 0, 'rata_rata_tidak_turun' => 0];
        }
        foreach ($analisis_array as $item) {
            if (isset($item['fitur']) && $item['fitur'] == $feature_name) {
                return $item;
            }
        }
        return ['rata_rata_ya_turun' => 0, 'rata_rata_tidak_turun' => 0];
    }
}
// --- Akhir Fungsi Helper ---
?>
<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<!-- Latar belakang: #FFE1AF (Krem) - WARNA SOLID -->
<div class="w-full min-h-screen bg-[#FFE1AF] p-4 lg:p-8 text-[#957C62]">
    <div class="container mx-auto max-w-7xl">

        <!-- Header Modern (Solid) -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-8">
            <!-- Judul -->
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-[#B77466] rounded-2xl flex items-center justify-center shadow-lg">
                    <span class="text-white text-3xl">📜</span>
                </div>
                <div>
                    <h1 class="text-4xl lg:text-5xl font-bold text-[#957C62] tracking-tight">
                        Riwayat Analisis
                    </h1>
                    <p class="text-[#B77466] mt-1">Kelola dan tinjau hasil analisis sebelumnya</p>
                </div>
            </div>
            
            <!-- Statistik (Kartu Solid) -->
            <div class="bg-white rounded-2xl px-6 py-4 border border-[#E2B59A]/50 shadow-lg text-center">
                <p class="text-3xl font-black text-[#B77466]"><?= count($history) ?></p>
                <p class="text-sm text-[#957C62] font-medium">Total Riwayat</p>
            </div>
        </div>

        <!-- Notifikasi (Alerts) - Style Solid Murni -->
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="bg-emerald-50 border-l-4 border-emerald-500 rounded-2xl p-6 mb-6 shadow-xl" role="alert">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl text-white">✓</span>
                    </div>
                    <div>
                        <p class="font-bold text-emerald-900 text-lg mb-1">Berhasil!</p>
                        <p class="text-emerald-700"><?= session()->getFlashdata('success') ?></p>
                    </div>
                </div>
            </div>
        <?php elseif (session()->getFlashdata('error')) : ?>
            <div class="bg-red-50 border-l-4 border-red-500 rounded-2xl p-6 mb-6 shadow-xl" role="alert">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl text-white">⚠️</span>
                    </div>
                    <div>
                        <p class="font-bold text-red-900 text-lg mb-1">Terjadi Kesalahan!</p>
                        <p class="text-red-700"><?= session()->getFlashdata('error') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Grid Layout Cards -->
        <div class="space-y-6">

            <?php if (empty($history)) : ?>
                <!-- Empty State (Solid) -->
                <div class="bg-white rounded-3xl shadow-2xl border border-gray-200 p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-[#FFE1AF] rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <span class="text-5xl">📊</span>
                        </div>
                        <h3 class="text-2xl font-bold text-[#957C62] mb-3">Belum Ada Riwayat</h3>
                        <p class="text-gray-600 mb-6">Belum ada riwayat analisis yang disimpan. Mulai analisis pertama Anda sekarang!</p>
                        <!-- Tombol Solid (TANPA GRADIENT) -->
                        <a href="<?= base_url('analisis') ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-[#B77466] text-white font-semibold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
                            <span>Mulai Analisis</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php else : ?>
                <?php foreach ($history as $index => $row) : ?>
                    <!-- Kartu Solid Putih (TANPA BLUR) -->
                    <div class="group bg-white rounded-3xl shadow-xl border border-gray-200 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                        <div class="flex flex-col lg:flex-row">
                            
                            <!-- Bagian Kiri: Info Utama (Solid) -->
                            <div class="w-full lg:w-1/3 xl:w-1/4 p-8 bg-[#FFE1AF]/40 border-b lg:border-b-0 lg:border-r border-[#E2B59A]/30 flex flex-col justify-center items-center text-center">
                                
                                <!-- ID Badge (Solid) -->
                                <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full mb-4 border border-[#E2B59A]/50">
                                    <span class="w-2 h-2 bg-[#B77466] rounded-full"></span>
                                    <span class="text-sm text-[#957C62] font-semibold">ID: #<?= $row['id'] ?></span>
                                </div>
                                
                                <!-- Akurasi Display (Minimalis, TANPA SVG/GRADIENT) -->
                                <div class="mb-4">
                                    <p class="text-7xl font-black text-[#B77466]">
                                        <?= number_format($row['accuracy'], 1) ?><span class="text-5xl">%</span>
                                    </p>
                                </div>
                                
                                <span class="text-lg font-bold text-[#957C62] block mb-2">Akurasi Model</span>
                                
                                <!-- Tanggal (Solid) -->
                                <div class="flex items-center justify-center gap-2 text-sm text-gray-600 bg-white/70 px-3 py-2 rounded-lg border border-gray-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    <?= esc(date('d M Y', strtotime($row['tanggal_analisis']))) ?>
                                </div>
                            </div>

                            <!-- Bagian Kanan: Detail & Aksi -->
                            <div class="flex-1 p-8">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="text-2xl font-bold text-[#957C62] mb-2 flex items-center gap-2">
                                            <span class="w-2 h-2 bg-[#B77466] rounded-full"></span>
                                            Ringkasan Analisis
                                        </h3>
                                        <p class="text-gray-600 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-[#B77466]" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"/>
                                                <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"/>
                                                <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"/>
                                            </svg>
                                            Analisis pada <strong><?= $row['total_data'] ?></strong> baris data
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Ringkasan Analisis (Kartu Solid) -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <?php 
                                        $analisisJson = json_decode($row['hasil_analisis'], true);
                                        $data_harga = find_feature_data($analisisJson, 'harga_produk_rp');
                                        $data_jumlah = find_feature_data($analisisJson, 'jumlah_terjual_unit');
                                        
                                        $interpretasi_harga = ($data_harga['rata_rata_ya_turun'] > $data_harga['rata_rata_tidak_turun']) ? "Harga Lebih Mahal" : "Harga Lebih Murah";
                                        $interpretasi_jumlah = ($data_jumlah['rata_rata_ya_turun'] < $data_jumlah['rata_rata_tidak_turun']) ? "Penjualan Lebih Sedikit" : "Penjualan Lebih Banyak";
                                        
                                        $warna_harga_bg = ($interpretasi_harga == "Harga Lebih Mahal") ? "bg-red-50 border-red-200" : "bg-emerald-50 border-emerald-200";
                                        $warna_harga_text = ($interpretasi_harga == "Harga Lebih Mahal") ? "text-[#B77466]" : "text-emerald-600";
                                        
                                        $warna_jumlah_bg = ($interpretasi_jumlah == "Penjualan Lebih Sedikit") ? "bg-red-50 border-red-200" : "bg-emerald-50 border-emerald-200";
                                        $warna_jumlah_text = ($interpretasi_jumlah == "Penjualan Lebih Sedikit") ? "text-[#B77466]" : "text-emerald-600";
                                    ?>
                                    
                                    <!-- Card Harga (Solid) -->
                                    <div class="<?= $warna_harga_bg ?> rounded-2xl p-5 border-2 <?= $warna_harga_bg ?> transition-all duration-300 hover:shadow-lg">
                                        <div class="flex items-start gap-3">
                                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                                                <span class="text-2xl">💰</span>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-600 mb-1">Faktor Harga</p>
                                                <p class="text-lg font-bold <?= $warna_harga_text ?>"><?= $interpretasi_harga ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Popularitas (Solid) -->
                                    <div class="<?= $warna_jumlah_bg ?> rounded-2xl p-5 border-2 <?= $warna_jumlah_bg ?> transition-all duration-300 hover:shadow-lg">
                                        <div class="flex items-start gap-3">
                                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                                                <span class="text-2xl">📊</span>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-600 mb-1">Faktor Popularitas</p>
                                                <p class="text-lg font-bold <?= $warna_jumlah_text ?>"><?= $interpretasi_jumlah ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Tombol Aksi (Solid) -->
                                <div class="flex items-center gap-3 flex-wrap">
                                    <!-- Tombol Detail: #957C62 (Coklat Muted) -->
                                    <a href="<?= base_url('history/detail/' . $row['id']) ?>" class="group/btn inline-flex items-center gap-2 bg-[#957C62] text-white text-sm font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
                                        <svg class="w-5 h-5 group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Detail
                                    </a>
                                    
                                    <!-- Tombol Hapus (Outline) -->
                                    <form action="<?= base_url('history/delete/' . $row['id']) ?>" method="get" onsubmit="return confirm('Anda yakin ingin menghapus data riwayat ini?');" class="inline-block">
                                        <button type="submit" class="group/btn inline-flex items-center gap-2 bg-white border-2 border-[#B77466] text-[#B77466] text-sm font-semibold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:bg-[#B77466] hover:text-white hover:shadow-xl hover:-translate-y-1">
                                            <svg class="w-5 h-5 group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- 
    CSS Kustom dan animasi 'animate-fade-in' telah dihapus
    untuk menggunakan murni Tailwind CSS.
-->

<?= $this->endSection(); ?>