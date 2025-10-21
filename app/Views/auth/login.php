<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Klasifikasi KNN</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="bg-slate-800 rounded-xl shadow-2xl w-full max-w-sm lg:max-w-4xl overflow-hidden">
        <div class="flex flex-col lg:flex-row min-h-[550px]">

            <!-- Kolom Form (Kiri) -->
            <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center order-2 lg:order-1">
                <div class="max-w-sm mx-auto w-full">
                    <div class="text-left mb-8">
                        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">Login Akun</h1>
                        <p class="text-gray-400 text-sm">Masuk untuk memulai klasifikasi.</p>
                    </div>

                    <form action="<?= base_url('/login') ?>" method="post" class="space-y-5">
                        <?= csrf_field() ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Username</label>
                            <input type="text" name="username" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                                placeholder="Masukkan username Anda">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                                placeholder="Masukkan password Anda">
                        </div>

                        <button type="submit"
                            class="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition-colors duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Masuk
                        </button>

                        <div class="text-center pt-3">
                            <p class="text-gray-400 text-sm">
                                Belum punya akun?
                                <a href="<?= site_url('register') ?>" class="text-teal-400 hover:text-teal-300 font-medium">
                                    Daftar di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kolom Ilustrasi (Kanan) -->
            <div class="lg:w-1/2 bg-gradient-to-br from-slate-900 to-slate-800 p-8 flex flex-col items-center justify-center text-center order-1 lg:order-2">

                <div class="text-teal-400 mb-6">
                    <!-- SVG Ilustrasi yang relevan dengan tema -->
                    <svg class="w-24 h-24 lg:w-32 lg:h-32 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>

                <div>
                    <h3 class="text-xl lg:text-2xl font-bold text-white mb-2 leading-tight">Klasifikasi Resiko Depresi (KNN)</h3>
                    <p class="text-gray-400 text-sm leading-relaxed max-w-xs mx-auto">
                        Alat bantu untuk meningkatkan kesadaran diri terhadap kesehatan mental di era digital.
                    </p>
                </div>
            </div>

        </div>
    </div>

    <?php
    // Blok PHP untuk notifikasi tidak perlu diubah
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
                background: '#1e293b', // slate-800
                color: '#e2e8f0' // slate-200
            }).then(() => {
                window.location.href = "<?= base_url('/home') ?>";
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
                background: '#1e293b',
                color: '#e2e8f0'
            });
        </script>
    <?php endif; ?>

</body>

</html>