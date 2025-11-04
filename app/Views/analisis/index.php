<?php helper('form'); ?>
<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<!-- Latar belakang: #FFE1AF (Krem) - WARNA SOLID -->
<div class="w-full min-h-screen bg-[#FFE1AF] p-4 lg:p-8 text-[#957C62]">
    <div class="container mx-auto">

        <!-- Notifikasi (Alerts) - Style Solid -->
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-6 rounded-2xl mb-8 shadow-xl animate-slide-down" role="alert">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-lg">Error!</p>
                        <p class="mt-1"><?= session()->getFlashdata('error') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Layout 2 Kolom: Kiri (Aksi) | Kanan (Penjelasan Proses) -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            <!-- Kolom Kiri (Aksi) -->
            <div class="lg:col-span-2">
                <!-- Kartu Solid Putih (Menghilangkan Glassmorphism/blur) -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200 sticky top-8">
                    
                    <!-- Ikon Header (Warna Baru) -->
                    <div class="flex justify-center mb-6">
                        <!-- BG: Terracotta (#B77466) -->
                        <div class="p-5 bg-[#B77466] rounded-3xl shadow-lg">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Judul (Warna Baru) -->
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-bold mb-3 text-[#957C62]">
                            Mulai Analisis
                        </h1>
                        <p class="text-[#957C62]/70 text-lg">
                            Jalankan algoritma Naive Bayes untuk menganalisis pola penjualan produk.
                        </p>
                    </div>

                    <!-- Form Aksi dengan Tombol Solid (TANPA GRADIENT) -->
                    <?= form_open('analisis/proses') ?>
                        <!-- Tombol: Solid #B77466, Hover: Solid #957C62 -->
                        <button type="submit" class="w-full bg-[#B77466] hover:bg-[#957C62] text-white font-bold py-5 px-6 rounded-xl transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 flex items-center justify-center text-lg">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <span>Jalankan Analisis Sekarang</span>
                            </div>
                        </button>
                    <?= form_close() ?>
                    
                    <!-- Info Badge (Warna Baru, Solid) -->
                    <div class="mt-6 p-4 bg-[#FFE1AF]/60 rounded-xl border border-[#E2B59A]">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#B77466] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-[#957C62]">
                                Proses ini akan mengambil data terbaru dari tabel <span class="font-bold">dataset_produk</span> dan menganalisisnya.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan (Penjelasan) -->
            <div class="lg:col-span-3">
                <!-- Kartu Solid Putih -->
                <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200">
                    
                    <!-- Header (Warna Baru) -->
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b-2 border-[#E2B59A]/50">
                        <div class="p-3 bg-[#957C62] rounded-xl shadow-lg"> <!-- Coklat Muted -->
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-[#957C62]">
                                Bagaimana Proses Ini Bekerja?
                            </h2>
                            <p class="text-[#957C62]/70 mt-1">Alur kerja algoritma Naive Bayes step-by-step</p>
                        </div>
                    </div>

                    <!-- Bento-style Info Steps (Warna Baru, Solid) -->
                    <div class="space-y-6">
                        
                        <!-- Langkah 1: Ambil Data -->
                        <div class="bg-[#FFE1AF]/40 p-6 rounded-2xl border-2 border-[#E2B59A]/30 shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-14 h-14 bg-[#B77466] text-white rounded-2xl flex items-center justify-center text-2xl font-bold shadow-lg">
                                    1
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-[#957C62] mb-2">Pengambilan Data</h3>
                                    <p class="text-[#957C62]/80 leading-relaxed">
                                        Skrip Python akan terhubung ke <span class="font-bold text-[#B77466]">produk_db</span> dan mengambil semua data dari <span class="font-bold text-[#B77466]">dataset_produk</span>.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Langkah 2: Preprocessing -->
                        <div class="bg-[#FFE1AF]/40 p-6 rounded-2xl border-2 border-[#E2B59A]/30 shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-14 h-14 bg-[#957C62] text-white rounded-2xl flex items-center justify-center text-2xl font-bold shadow-lg">
                                    2
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-[#957C62] mb-2">Preprocessing Data</h3>
                                    <p class="text-[#957C62]/80 leading-relaxed">
                                        Data teks diubah jadi angka (<span class="font-bold">Encoding</span>) dan data numerik disesuaikan skalanya (<span class="font-bold">Scaling</span>) agar dapat diproses model.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Langkah 3: Pelatihan Model -->
                        <div class="bg-[#FFE1AF]/40 p-6 rounded-2xl border-2 border-[#E2B59A]/30 shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-14 h-14 bg-[#E2B59A] text-[#957C62] rounded-2xl flex items-center justify-center text-2xl font-bold shadow-lg">
                                    3
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-[#957C62] mb-2">Pelatihan & Pengujian (80/20)</h3>
                                    <p class="text-[#957C62]/80 leading-relaxed">
                                        Data dibagi untuk melatih model <span class="font-bold">Gaussian Naive Bayes</span> dan menguji akurasi tebakannya terhadap pola penurunan.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Langkah 4: Hasil -->
                        <div class="bg-[#FFE1AF]/40 p-6 rounded-2xl border-2 border-[#E2B59A]/30 shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-14 h-14 bg-white text-[#B77466] rounded-2xl flex items-center justify-center shadow-lg border-2 border-[#B77466]">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-[#B77466]">Tinjau Hasil Analisis</h3>
                                    <p class="text-[#957C62]/80 leading-relaxed">
                                        Anda akan dialihkan ke dashboard hasil yang menampilkan <span class="font-bold">Faktor Penentu</span> dan <span class="font-bold">Detail Akurasi</span>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End space-y-6 -->
                </div> <!-- End right card -->
            </div> <!-- End right col -->
        </div> <!-- End grid -->
    </div> <!-- End container -->
</div> <!-- End wrapper -->

<!-- Custom CSS untuk Animation -->
<style>
    @keyframes slide-down {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slide-down {
        animation: slide-down 0.3s ease-out;
    }
</style>

<?= $this->endSection(); ?>