<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto p-4 lg:p-8 text-gray-400">

    <h1 class="text-3xl font-bold mb-6 text-teal-700">Manajemen Dataset</h1>

    <!-- Notifikasi (Digabung menjadi satu blok) -->
    <?php if (session()->getFlashdata('success') || session()->getFlashdata('error')) : ?>
        <?php $isError = session()->getFlashdata('error'); ?>
        <div class="<?= $isError ? 'bg-red-500 border-red-700' : 'bg-teal-500 border-teal-700' ?> border-l-4 text-white p-4 mb-6 rounded-md shadow-lg" role="alert">
            <p class="font-bold"><?= $isError ? 'Error' : 'Sukses' ?></p>
            <p><?= $isError ?: session()->getFlashdata('success') ?></p>
        </div>
    <?php endif; ?>

    <!-- Bagian Aksi Cepat -->
    <div class="bg-slate-800 p-6 rounded-lg shadow-xl mb-8">
        <h2 class="text-xl font-semibold mb-4 border-b border-gray-600 pb-2">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Form Impor CSV -->
            <form action="<?= base_url('dataset/upload') ?>" method="post" enctype="multipart/form-data" class="flex flex-col space-y-3">
                <?= csrf_field() ?>
                <label for="dataset_csv" class="font-medium">Impor dari CSV:</label>
                <input type="file" name="dataset_csv" id="dataset_csv" required class="block w-full text-sm text-gray-400
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-teal-100 file:text-teal-700
                    hover:file:bg-teal-200 transition">
                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 shadow-md">
                    Upload & Simpan
                </button>
            </form>

            <!-- Tombol Ekspor -->
            <div class="flex flex-col space-y-3 justify-end">
                <label class="font-medium">Ekspor ke CSV:</label>
                <a href="<?= base_url('dataset/export') ?>" class="w-full text-center bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-lg transition duration-300 shadow-md">
                    Download Dataset
                </a>
            </div>

            <!-- Form Hapus Semua Data -->
            <div class="flex flex-col space-y-3 justify-end">
                <label class="font-medium">Hapus Semua Data:</label>
                <form action="<?= base_url('dataset/hapusSemua') ?>" method="post" onsubmit="return confirm('PERINGATAN! Anda yakin ingin menghapus semua data secara permanen? Aksi ini tidak dapat dibatalkan.');">
                    <?= csrf_field() ?>
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300 shadow-md">
                        Hapus Semua
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Form Tambah Data Manual -->
    <div class="bg-slate-800 p-6 rounded-lg shadow-xl mb-8">
        <h2 class="text-xl font-semibold mb-4 border-b border-gray-600 pb-2">Tambah Data Manual</h2>
        <form action="<?= base_url('dataset/save') ?>" method="post">
            <?= csrf_field() ?>
            <!-- Layout responsif untuk form input -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="sm:col-span-1">
                    <label for="durasi_layar" class="block mb-2 text-sm font-medium text-gray-300">Durasi Layar (jam)</label>
                    <input type="number" step="0.1" name="durasi_layar" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required>
                </div>
                <div class="sm:col-span-1">
                    <label for="durasi_sosmed" class="block mb-2 text-sm font-medium text-gray-300">Durasi Sosmed (jam)</label>
                    <input type="number" step="0.1" name="durasi_sosmed" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required>
                </div>
                <div class="sm:col-span-1">
                    <label for="durasi_tidur" class="block mb-2 text-sm font-medium text-gray-300">Durasi Tidur (jam)</label>
                    <input type="number" step="0.1" name="durasi_tidur" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required>
                </div>
                <div class="sm:col-span-1">
                    <label for="resiko_depresi" class="block mb-2 text-sm font-medium text-gray-300">Resiko Depresi</label>
                    <select name="resiko_depresi" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required>
                        <option value="">-- Pilih --</option>
                        <option value="Rendah">Rendah</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Tinggi">Tinggi</option>
                    </select>
                </div>
                <!-- Tombol diatur agar selalu di paling bawah dan full width di mobile -->
                <div class="sm:col-span-2 lg:col-span-1 flex items-end">
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-4 rounded-lg transition duration-300 shadow-md">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="bg-slate-800 rounded-lg shadow-xl overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold">Isi Tabel Dataset</h2>
        </div>
        <!-- Wrapper untuk scroll horizontal di layar kecil -->
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-300">
                <thead class="text-xs text-white uppercase bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Durasi Layar</th>
                        <th scope="col" class="px-6 py-3">Durasi Sosmed</th>
                        <th scope="col" class="px-6 py-3">Durasi Tidur</th>
                        <th scope="col" class="px-6 py-3">Resiko Depresi</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dataset)) : ?>
                        <tr class="bg-slate-800 border-b border-gray-700">
                            <td colspan="6" class="px-6 py-4 text-center">Data masih kosong.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($dataset as $row) : ?>
                            <tr class="bg-slate-800 border-b border-gray-700 hover:bg-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap"><?= $row['id'] ?></th>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_layar'] ?> jam</td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_sosmed'] ?> jam</td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_tidur'] ?> jam</td>
                                <td class="px-6 py-4 font-semibold whitespace-nowrap 
                                    <?php
                                    if ($row['resiko_depresi'] == 'Tinggi') echo 'text-red-400';
                                    elseif ($row['resiko_depresi'] == 'Sedang') echo 'text-yellow-400';
                                    else echo 'text-green-400';
                                    ?>">
                                    <?= $row['resiko_depresi'] ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="<?= base_url('dataset/delete/' . $row['id']) ?>" method="post" onsubmit="return confirm('Anda yakin ingin menghapus data ini?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="font-medium text-red-500 hover:text-red-700 transition duration-300">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>