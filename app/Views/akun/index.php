<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto p-4 lg:p-8 text-gray-100">

    <h1 class="text-3xl font-bold mb-6 text-teal-400 border-b border-gray-700 pb-4">Akun Saya</h1>

    <!-- Notifikasi (jika ada error validasi) -->
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-red-500 border-l-4 border-red-700 text-white p-4 mb-6 rounded-md shadow-lg" role="alert">
            <p class="font-bold">Gagal Memperbarui</p>
            <ul class="mt-2 list-disc list-inside text-sm">
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Kolom Informasi Profil -->
        <div class="lg:col-span-2">
            <div class="bg-slate-800 p-6 rounded-lg shadow-xl">
                <h2 class="text-xl font-semibold mb-6 text-white">Informasi Profil</h2>
                <form action="<?= site_url('akun/update_profil') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 mb-6">
                        <img class="h-24 w-24 rounded-full object-cover border-4 border-teal-500" src="<?= base_url('uploads/foto_profil/' . esc($user['foto'])) ?>" alt="Foto Profil">
                        <div>
                            <label for="foto" class="block text-sm font-medium text-gray-300">Ganti Foto</label>
                            <input type="file" name="foto" id="foto" class="mt-1 block w-full text-sm text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0 file:text-sm file:font-semibold
                                file:bg-teal-500/10 file:text-teal-300
                                hover:file:bg-teal-500/20 transition">
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG (MAX. 1MB)</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-300">Username</label>
                            <input type="text" id="username" value="<?= esc($user['username']) ?>" class="w-full px-4 py-3 mt-1 border border-gray-600 rounded-lg bg-gray-700/50 cursor-not-allowed" disabled>
                        </div>
                        <div>
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-300">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= esc($user['nama_lengkap']) ?>" class="w-full px-4 py-3 mt-1 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                            <input type="email" name="email" id="email" value="<?= esc($user['email']) ?>" class="w-full px-4 py-3 mt-1 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition">
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Simpan Perubahan Profil</button>
                </form>
            </div>
        </div>

        <!-- Kolom Ganti Password -->
        <div>
            <div class="bg-slate-800 p-6 rounded-lg shadow-xl">
                <h2 class="text-xl font-semibold mb-6 text-white">Ganti Password</h2>
                <form action="<?= site_url('akun/update_sandi') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="space-y-4">
                        <div>
                            <label for="password_lama" class="block text-sm font-medium text-gray-300">Password Lama</label>
                            <input type="password" name="password_lama" id="password_lama" class="w-full px-4 py-3 mt-1 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition" required>
                        </div>
                        <div>
                            <label for="password_baru" class="block text-sm font-medium text-gray-300">Password Baru</label>
                            <input type="password" name="password_baru" id="password_baru" class="w-full px-4 py-3 mt-1 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition" required>
                        </div>
                        <div>
                            <label for="konfirmasi_password" class="block text-sm font-medium text-gray-300">Konfirmasi Password Baru</label>
                            <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="w-full px-4 py-3 mt-1 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition" required>
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-6 py-3 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">Ubah Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 
    Catatan: Blok <script> untuk SweetAlert2 telah dihapus dari sini.
    Alasannya adalah fungsionalitas notifikasi ini sudah ditangani secara global 
    di file layout/layout.php Anda, sehingga tidak perlu ditulis ulang di setiap halaman.
-->

<?= $this->endSection(); ?>