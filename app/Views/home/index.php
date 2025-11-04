<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<!-- 
    CSS Kustom untuk animasi (Diambil dari contoh Anda)
-->
<style>
    /* Animasi gambar naik-turun */
    @keyframes float {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-20px);
        }
        100% {
            transform: translateY(0px);
        }
    }

    .animate-float {
        animation: float 6s ease-in-out infinite;
    }

    /* Style untuk kursor TypewriterJS */
    .Typewriter__cursor {
        color: #B77466; /* Disesuaikan dengan palet warna Anda */
        font-weight: bold;
        animation: blink 0.7s infinite;
    }

    @keyframes blink {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }
</style>

<!-- Latar belakang: #FFE1AF (Krem) - WARNA SOLID -->
<div class="w-full min-h-screen bg-[#FFE1AF] p-4 lg:p-8 text-[#957C62]">
    <div class="container mx-auto max-w-5xl">

        <!-- ======================= -->
        <!-- Hero Section (Tengah, Menggunakan Gambar PNG) -->
        <!-- ======================= -->
        <section class="py-24 text-center">
            
            <!-- Ikon PNG (DENGAN ANIMASI FLOAT) -->
            <div class="w-64 h-64 mx-auto mb-8 flex items-center justify-center p-6">
                <img src="<?= base_url('public/belanja.png') ?>" 
                     alt="Ikon Analisis" 
                     class="w-full h-full animate-float"> <!-- class 'animate-float' ditambahkan -->
            </div>

            <!-- Kolom Teks (Tengah, DENGAN TYPEWRITER) -->
            <!-- ID ditambahkan, min-h untuk mencegah layout shift, teks dikosongkan -->
            <h1 id="typewriter-h1" class="text-4xl md:text-5xl font-bold text-[#957C62] leading-tight min-h-[110px] md:min-h-[120px]">
                <!-- Teks akan diisi oleh JavaScript -->
            </h1>
            <p class="mt-4 text-lg md:text-xl text-[#B77466] max-w-2xl mx-auto">
                Sebuah aplikasi untuk mengidentifikasi pola penjualan menggunakan algoritma <span class="font-bold">Naive Bayes</span>.
            </p>
            
            <!-- Tombol Aksi (CTA) -->
            <a href="<?= base_url('/analisis') ?>" class="mt-10 inline-block bg-[#B77466] hover:bg-[#957C62] text-white font-bold py-4 px-10 rounded-lg transition duration-300 shadow-lg text-lg transform hover:scale-105">
                Mulai Analisis
            </a>
        </section>

        <!-- ======================= -->
        <!-- Tentang Proyek Section -->
        <!-- ======================= -->
        <section class="py-16">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                <!-- Kolom Gambar -->
                <div class="flex justify-center items-center">
                    <img src="<?= base_url('public/market.png') ?>" 
                         alt="Ilustrasi Data" 
                         class=" w-full max-w-md"
                         onerror="this.src='https://placehold.co/400x400/E2B59A/957C62?text=Ilustrasi+Data'; this.onerror=null;">
                </div>
                
                <!-- Kolom Teks -->
                <div>
                    <h2 class="text-3xl font-bold text-[#957C62] mb-4">Tentang Proyek Ini</h2>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Aplikasi ini dibangun sebagai bagian dari penelitian skripsi untuk menerapkan algoritma Naive Bayes. Tujuannya adalah untuk menganalisis data penjualan produk minimarket dari periode 2020 hingga 2023.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        Selain memprediksi, fokus utama aplikasi ini adalah untuk menganalisis (sesuai Rumusan Masalah) faktor-faktor apa saja yang ditemukan oleh model sebagai pemicu terjadinya penurunan penjualan.
                    </p>
                </div>

            </div>
        </section>

        <!-- ======================= -->
        <!-- Metode Naive Bayes Section -->
        <!-- ======================= -->
        <section class="py-16 text-center">
            <div>
                <h2 class="text-3xl font-bold text-[#957C62] mb-4">Bagaimana Cara Kerjanya?</h2>
                <p class="text-gray-700 max-w-3xl mx-auto mb-12">
                    Metodologi ini menghitung probabilitas (peluang) dari setiap fitur untuk menemukan faktor penentu.
                </p>
            </div>
            
            <!-- Kartu 3 Langkah (Solid) -->
            <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Step 1 (Gambar PNG) -->
                <div class="bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-t-4 border-[#E2B59A]">
                    <div class="w-16 h-16 p-3 bg-[#FFE1AF] rounded-full mx-auto mb-6 flex items-center justify-center">
                        <img src="<?= base_url('public/images/icon_db.png') ?>" 
                             alt="Database" 
                             class="w-10 h-10"
                             onerror="this.src='https://placehold.co/64x64/FFE1AF/B77466?text=DB'; this.onerror=null;">
                    </div>
                    <h3 class="text-xl font-bold mb-2">1. Ambil & Proses Data</h3>
                    <p class="text-gray-600">Data diambil dari tabel `dataset_produk`, kemudian teks diubah menjadi angka (Encoding) dan nilai numerik disamakan skalanya (Scaling).</p>
                </div>
                
                <!-- Step 2 (Gambar PNG) -->
                <div class="bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-t-4 border-[#B77466]">
                     <div class="w-16 h-16 p-3 bg-[#FFE1AF] rounded-full mx-auto mb-6 flex items-center justify-center">
                        <img src="<?= base_url('public/images/icon_model.png') ?>" 
                             alt="Model" 
                             class="w-10 h-10"
                             onerror="this.src='https://placehold.co/64x64/FFE1AF/B77466?text=AI'; this.onerror=null;">
                    </div>
                    <h3 class="text-xl font-bold mb-2">2. Latih Model (80%)</h3>
                    <p class="text-gray-600">Model `Gaussian Naive Bayes` 'belajar' dari 80% data untuk menghitung rata-rata (theta) dari setiap fitur untuk kelas 'Ya Turun' dan 'Tidak Turun'.</p>
                </div>
                
                <!-- Step 3 (Gambar PNG) -->
                <div class="bg-white p-8 rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-t-4 border-[#E2B59A]">
                     <div class="w-16 h-16 p-3 bg-[#FFE1AF] rounded-full mx-auto mb-6 flex items-center justify-center">
                        <img src="<?= base_url('public/images/icon_hasil.png') ?>" 
                             alt="Hasil" 
                             class="w-10 h-10"
                             onerror="this.src='https://placehold.co/64x64/FFE1AF/B77466?text=Hasil'; this.onerror=null;">
                    </div>
                    <h3 class="text-xl font-bold mb-2">3. Analisis Hasil (20%)</h3>
                    <p class="text-gray-600">Model diuji pada 20% data sisa untuk mengukur akurasi. Faktor-faktor (rata-rata) yang telah dipelajari model kemudian diekstrak dan ditampilkan.</p>
                </div>
            </div>
        </section>

        <!-- ======================= -->
        <!-- Disclaimer Section -->
        <!-- ======================= -->
        <section class="py-16">
            <div>
                <!-- Kartu Solid (TANPA BLUR) -->
                <div class="bg-white border-l-8 border-[#B77466] rounded-2xl shadow-xl text-left p-8 md:p-12">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <!-- Ikon Info (Gambar PNG) -->
                            <img src="<?= base_url('public/images/icon_info.png') ?>" 
                                 alt="Info" 
                                 class="w-10 h-10"
                                 onerror="this.src='https://placehold.co/40x40/B77466/FFFFFF?text=!'; this.onerror=null;">
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-[#957C62] mb-4">Batasan Penelitian</h2>
                            <p class="text-gray-700 max-w-3xl leading-relaxed">
                                Sesuai batasan masalah, hasil dari aplikasi ini bersifat akademis dan terbatas pada:
                                <ul class="list-disc list-inside ml-4 mt-2 space-y-1">
                                    <li>Penerapan algoritma <strong>Naive Bayes</strong> (tidak ada perbandingan algoritma).</li>
                                    <li>Data penjualan produk minimarket dari periode <strong>2020 - 2023</strong>.</li>
                                    <li>Atribut yang digunakan (Harga, Kategori, Promosi, dll.) yang ada di dataset.</li>
                                </ul>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>

<!-- [BARU] Tambahkan script library TypewriterJS -->
<script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>

<!-- [BARU] Script untuk inisialisasi TypewriterJS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typewriterElement = document.getElementById('typewriter-h1');

        if (typewriterElement) {
            const typewriter = new Typewriter(typewriterElement, {
                loop: true, // Agar animasi berulang
                delay: 75, // Kecepatan mengetik (ms)
                deleteSpeed: 50 // Kecepatan menghapus (ms)
            });

            // Teks disesuaikan dengan Proyek Analisis Penjualan
            typewriter
                .typeString('Analisis Prediksi Penjualan Produk') // Teks pertama
                .pauseFor(2500) // Jeda sebelum menghapus
                .deleteAll() // Hapus semua teks
                .typeString('Memahami Pola Penurnan Penjualan Minimarket') // Teks alternatif
                .pauseFor(2500)
                .deleteAll()
                .typeString('Strategi Bisnis dengan Naive Bayes') // Teks alternatif lain
                .pauseFor(2500)
                .start();
        }
    });
</script>

<?= $this->endSection(); ?>