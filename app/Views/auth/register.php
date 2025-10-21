<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Klasifikasi KNN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="bg-slate-800 rounded-xl shadow-2xl w-full max-w-sm lg:max-w-4xl overflow-hidden">
        <div class="flex flex-col lg:flex-row min-h-[550px]">

            <!-- Kolom Form (Kiri) -->
            <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center order-2 lg:order-1">
                <div class="max-w-sm mx-auto w-full">
                    <div class="text-left mb-6">
                        <h1 class="text-2xl lg:text-3xl font-bold text-white mb-2">Buat Akun Baru</h1>
                        <p class="text-gray-400 text-sm">Isi data di bawah untuk mendaftar.</p>
                    </div>

                    <!-- Notifikasi Error Validasi -->
                    <?php $validation = \Config\Services::validation(); ?>
                    <?php if (session()->getFlashdata('error') || $validation->getErrors()) : ?>
                        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg relative mb-4 text-sm" role="alert">
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

                    <form action="<?= site_url('register') ?>" method="post" class="space-y-4">
                        <?= csrf_field() ?>
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-300 mb-2">Username</label>
                            <input type="text" name="username" id="username" required value="<?= old('username') ?>" class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                            <input type="password" name="password" id="password" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                        </div>

                        <div>
                            <label for="password_confirm" class="block text-sm font-medium text-gray-300 mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirm" id="password_confirm" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                        </div>

                        <button type="submit" class="w-full bg-teal-600 text-white py-3 mt-2 rounded-lg hover:bg-teal-700 transition-colors duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Daftar
                        </button>

                        <div class="text-center pt-3">
                            <p class="text-gray-400 text-sm">
                                Sudah punya akun?
                                <a href="<?= site_url('login') ?>" class="text-teal-400 hover:text-teal-300 font-medium">
                                    Login di sini
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
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
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

</body>

</html>