<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<!-- 
    CSS Kustom untuk animasi gambar naik-turun (float)
-->
<style>
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
        /* Menerapkan animasi float dengan durasi 6 detik, pergerakan halus, dan berulang tanpa henti */
        animation: float 6s ease-in-out infinite;
    }
</style>

<div class="container mx-auto px-4 lg:px-8 py-8 text-gray-100 overflow-x-hidden">

    <!-- ======================= -->
    <!-- Hero Section -->
    <!-- ======================= -->
    <section class="py-16 md:py-24">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <!-- Kolom Teks -->
            <div>
                <div>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white leading-tight">
                        Memahami Resiko Depresi di Era Digital
                    </h1>
                    <p class="mt-4 text-lg md:text-xl text-teal-300 max-w-2xl">
                        Sebuah alat bantu berbasis <span class="font-bold">K-Nearest Neighbor (KNN)</span> untuk meningkatkan kesadaran diri terhadap kesehatan mental.
                    </p>
                    <a href="<?= base_url('/klasifikasi') ?>" class="mt-8 inline-block bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 px-8 rounded-full transition duration-300 shadow-lg text-lg transform hover:scale-105">
                        Mulai Klasifikasi
                    </a>
                </div>
            </div>

            <!-- Kolom Gambar dengan Animasi -->
            <div>
                <div class="flex justify-center items-center">
                    <!-- Gambar Anda dengan animasi float -->
                    <img src="<?= base_url('public/depresi.png') ?>" alt="Ilustrasi Kesehatan Mental" class="w-full max-w-sm md:max-w-md animate-float">
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Proyek Section -->
    <section class="py-16">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="flex justify-center items-center">
                <div class="rounded-lg shadow-xl">
                    <img src="<?= base_url('public/kesadaran.png') ?>" alt="Kesadaran Diri" class="rounded-lg object-cover w-[200px] h-[200px]">
                </div>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-teal-400 mb-4">Pentingnya Kesadaran Diri</h2>
                <p class="text-gray-300 mb-4 leading-relaxed">
                    Aplikasi ini bukan alat diagnosis. Tujuannya adalah untuk menjadi cermin, membantu Anda merefleksikan bagaimana pola hidup digital—seperti durasi menatap layar dan waktu tidur—berpotensi memengaruhi kondisi emosional Anda.
                </p>
                <p class="text-gray-300 leading-relaxed">
                    Dengan meningkatkan kesadaran, kita bisa mengambil langkah-langkah kecil untuk membangun kebiasaan digital yang lebih sehat dan seimbang.
                </p>
            </div>
        </div>
    </section>

    <!-- Metode KNN Section -->
    <section class="py-16 text-center">
        <div>
            <h2 class="text-3xl font-bold text-teal-400 mb-4">Bagaimana Cara Kerjanya?</h2>
            <p class="text-gray-300 max-w-3xl mx-auto mb-12">
                Aplikasi ini menggunakan metode K-Nearest Neighbor (KNN), sebuah algoritma klasifikasi yang sederhana namun kuat. Cara kerjanya didasarkan pada asumsi bahwa data yang mirip akan memiliki hasil yang mirip.
            </p>
        </div>
        <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="bg-slate-800 p-8 rounded-lg shadow-xl hover:shadow-teal-500/20 hover:-translate-y-2 transition-all duration-300">
                <div class="text-teal-400 mb-4"><i class="fa-solid fa-ruler-combined text-5xl"></i></div>
                <h3 class="text-xl font-bold mb-2">1. Hitung Jarak</h3>
                <p class="text-gray-400">Data baru Anda akan dihitung jaraknya ke semua data di dataset menggunakan Jarak Euclidean.</p>
            </div>
            <!-- Step 2 -->
            <div class="bg-slate-800 p-8 rounded-lg shadow-xl hover:shadow-teal-500/20 hover:-translate-y-2 transition-all duration-300">
                <div class="text-teal-400 mb-4"><i class="fa-solid fa-users-viewfinder text-5xl"></i></div>
                <h3 class="text-xl font-bold mb-2">2. Cari Tetangga</h3>
                <p class="text-gray-400">Sistem akan menemukan 'K' data terdekat dari data Anda untuk perbandingan.</p>
            </div>
            <!-- Step 3 -->
            <div class="bg-slate-800 p-8 rounded-lg shadow-xl hover:shadow-teal-500/20 hover:-translate-y-2 transition-all duration-300">
                <div class="text-teal-400 mb-4"><i class="fa-solid fa-check-to-slot text-5xl"></i></div>
                <h3 class="text-xl font-bold mb-2">3. Lakukan Voting</h3>
                <p class="text-gray-400">Klasifikasi dengan suara terbanyak dari tetangga akan menjadi hasil prediksi.</p>
            </div>
        </div>
    </section>

    <!-- Disclaimer Section -->
    <section class="py-16">
        <div>
            <div class="bg-slate-800/50 border border-yellow-500/30 rounded-lg shadow-2xl text-center p-8 md:p-12">
                <div class="text-yellow-400 mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-white mb-4">Penting Untuk Diingat</h2>
                <p class="text-gray-300 max-w-3xl mx-auto">
                    Hasil dari aplikasi ini bersifat prediktif dan edukatif, bukan merupakan diagnosis medis. Jika Anda merasa mengalami gejala depresi atau masalah kesehatan mental lainnya, sangat disarankan untuk berkonsultasi dengan profesional seperti psikolog atau psikiater.
                </p>
            </div>
        </div>
    </section>

</div>

<?= $this->endSection(); ?>