<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto p-4 lg:p-8 text-gray-100">

    <h1 class="text-3xl font-bold mb-6 text-teal-700">Klasifikasi Resiko Depresi (KNN)</h1>

    <!-- Notifikasi -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="bg-red-500 border-l-4 border-red-700 text-white p-4 mb-6 rounded-md shadow-lg" role="alert">
            <p class="font-bold">Error</p>
            <p><?= session()->getFlashdata('error') ?></p>
        </div>
    <?php endif; ?>

    <!-- Form Input Data Uji -->
    <div class="bg-slate-800 p-6 rounded-lg shadow-xl">
        <h2 class="text-xl font-semibold mb-4 border-b border-gray-600 pb-2">Masukkan Data Baru Untuk Diklasifikasi</h2>

        <form action="<?= base_url('klasifikasi/proses') ?>" method="post">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

                <!-- Kolom Input Data -->
                <div class="flex flex-col space-y-4">
                    <div>
                        <label for="durasi_layar" class="block mb-2 text-sm font-medium text-gray-300">Durasi Layar per Hari (jam)</label>
                        <input type="number" step="0.1" name="durasi_layar" id="durasi_layar" value="<?= old('durasi_layar') ?>" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required placeholder="Contoh: 8.5">
                    </div>
                    <div>
                        <label for="durasi_sosmed" class="block mb-2 text-sm font-medium text-gray-300">Durasi Media Sosial per Hari (jam)</label>
                        <input type="number" step="0.1" name="durasi_sosmed" id="durasi_sosmed" value="<?= old('durasi_sosmed') ?>" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required placeholder="Contoh: 4.0">
                    </div>
                    <div>
                        <label for="durasi_tidur" class="block mb-2 text-sm font-medium text-gray-300">Durasi Tidur per Hari (jam)</label>
                        <input type="number" step="0.1" name="durasi_tidur" id="durasi_tidur" value="<?= old('durasi_tidur') ?>" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required placeholder="Contoh: 6.5">
                    </div>
                </div>

                <!-- Kolom Input K dan Tombol Submit -->
                <div class="flex flex-col space-y-4 md:justify-between">
                    <div>
                        <label for="k" class="block mb-2 text-sm font-medium text-gray-300">Nilai K (Jumlah Tetangga)</label>
                        <input type="number" name="k" id="k" value="<?= old('k', 3) // Default K=3 
                                                                    ?>" class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-teal-500 focus:border-teal-500 block w-full p-2.5" required min="1">
                        <p class="text-xs text-gray-400 mt-2">Nilai K disarankan ganjil untuk menghindari hasil seri.</p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 shadow-lg text-lg">
                            Mulai Klasifikasi
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>