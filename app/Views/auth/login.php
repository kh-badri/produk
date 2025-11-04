<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Analisis Naive Bayes</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<!-- Latar belakang: #FFE1AF (Krem) -->
<body class="bg-[#FFE1AF] min-h-screen flex items-center justify-center p-4">

    <!-- Kartu Login (Solid Putih, Terpusat) -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-white/50">
        
        <div class="p-8 lg:p-12 flex flex-col justify-center">
            
            <!-- Header/Logo (Warna Baru) -->
            <div class="flex justify-center mb-2">
                <div class="p-2">
                    <!-- Ganti dengan path ke ikon Anda, misal: public/images/icon_analisis_hero.png -->
                    <img src="<?= base_url('public/belanja.png') ?>" 
                         alt="Analisis" 
                         class="w-28 h-28"
                         onerror="this.src='https://placehold.co/64x64/FFFFFF/B77466?text=NB'; this.onerror=null;">
                </div>
            </div>

            <div class="text-center mb-2">
                <!-- Teks: #957C62 (Coklat Muted) -->
                <h1 class="text-3xl font-bold text-[#957C62] mb-2">Selamat Datang</h1>
                <p class="text-[#957C62]/70 text-sm">Masuk untuk memulai analisis penjualan produk.</p>
            </div>

            <!-- Form (Warna Baru) -->
            <form action="<?= base_url('/login') ?>" method="post" class="space-y-5">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" name="username" required
                           class="w-full px-4 py-3 bg-gray-50 border border-[#E2B59A] text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-transparent transition"
                           placeholder="Masukkan username Anda">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 bg-gray-50 border border-[#E2B59A] text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-transparent transition"
                           placeholder="Masukkan password Anda">
                </div>

                <!-- Tombol: #B77466 (Terracotta), Hover: #957C62 (Coklat Muted) -->
                <button type="submit"
                        class="w-full bg-[#B77466] text-white py-3 rounded-lg hover:bg-[#957C62] transition-colors duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Masuk
                </button>

                <div class="text-center pt-3">
                    <p class="text-gray-600 text-sm">
                        Belum punya akun?
                        <!-- Link: #B77466 (Terracotta) -->
                        <a href="<?= site_url('register') ?>" class="text-[#B77466] hover:text-[#957C62] font-medium">
                            Daftar di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <?php
    // --- PERBAIKAN SCRIPT SWEETALERT (TEMA TERANG) ---
    $successMessage = session()->getFlashdata('success');
    if ($successMessage):
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= esc($successMessage, 'js') ?>',
                timer: 2000,
                showConfirmButton: false,
                background: '#fff', // Latar belakang putih
                color: '#957C62'  // Teks Coklat Muted
            }).then(() => {
                // Hapus 'window.location.href' jika Anda ingin user login manual setelah daftar
                // Biarkan jika Anda ingin auto-redirect ke home (jika auto-login)
                // window.location.href = "<?= base_url('/home') ?>"; 
            });
        </script>
    <?php endif; ?>

    <?php
    $errorMessage = session()->getFlashdata('error');
    if ($errorMessage) :
    ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '<?= esc($errorMessage, 'js') ?>',
                background: '#fff', // Latar belakang putih
                color: '#957C62'  // Teks Coklat Muted
            });
        </script>
    <?php endif; ?>

</body>
</html>