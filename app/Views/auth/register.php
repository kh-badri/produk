<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Analisis Naive Bayes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert tidak diperlukan di sini karena error validasi ditampilkan di halaman -->
</head>

<!-- Latar belakang: #FFE1AF (Krem) -->
<body class="bg-[#FFE1AF] min-h-screen flex items-center justify-center p-4">

    <!-- Kartu Register (Solid Putih, Terpusat) -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-white/50">
        
        <div class="p-8 lg:p-12 flex flex-col justify-center">
            
            <!-- Header/Logo (Warna Baru) -->
            <div class="flex justify-center mb-2">
                <div class="p-2">
                    <!-- Ganti dengan path ke ikon Anda, misal: public/images/icon_analisis_hero.png -->
                    <img src="<?= base_url('public/market.png') ?>" 
                         alt="Register" 
                         class="w-28 h-28"
                         onerror="this.src='https://placehold.co/64x64/FFFFFF/B77466?text=NB'; this.onerror=null;">
                </div>
            </div>

            <div class="text-center mb-2">
                <!-- Teks: #957C62 (Coklat Muted) -->
                <h1 class="text-3xl font-bold text-[#957C62] mb-2">Buat Akun Baru</h1>
                <p class="text-[#957C62]/70 text-sm">Isi data di bawah untuk mendaftar.</p>
            </div>

            <!-- Notifikasi Error Validasi (Style Tema Terang) -->
            <?php $validation = \Config\Services::validation(); ?>
            <?php if (session()->getFlashdata('error') || $validation->getErrors()) : ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg relative mb-4 text-sm" role="alert">
                    <strong class="font-bold">Terjadi Kesalahan:</strong>
                    <ul class="list-disc list-inside mt-1">
                        <?php if (session()->getFlashdata('error')) : ?>
                            <li><?= session()->getFlashdata('error') ?></li>
                        <?php else : ?>
                            <?php foreach ($validation->getErrors() as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Form (Warna Baru) -->
            <form action="<?= site_url('register') ?>" method="post" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" id="username" required value="<?= old('username') ?>" 
                           class="w-full px-4 py-3 bg-gray-50 border border-[#E2B59A] text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-transparent transition">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" required 
                           class="w-full px-4 py-3 bg-gray-50 border border-[#E2B59A] text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-transparent transition">
                </div>

                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" required 
                           class="w-full px-4 py-3 bg-gray-50 border border-[#E2B59A] text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-transparent transition">
                </div>

                <!-- Tombol: #B77466 (Terracotta), Hover: #957C62 (Coklat Muted) -->
                <button type="submit" 
                        class="w-full bg-[#B77466] text-white py-3 mt-2 rounded-lg hover:bg-[#957C62] transition-colors duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Daftar
                </button>

                <div class="text-center pt-3">
                    <p class="text-gray-600 text-sm">
                        Sudah punya akun?
                        <!-- Link: #B77466 (Terracotta) -->
                        <a href="<?= site_url('login') ?>" class="text-[#B77466] hover:text-[#957C62] font-medium">
                            Login di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

</body>
</html>