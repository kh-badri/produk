<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto p-4 lg:p-8 text-gray-100">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-teal-400">Hasil Klasifikasi KNN</h1>
        <a href="<?= base_url('klasifikasi') ?>" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 whitespace-nowrap">
            &laquo; Kembali ke Form
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-slate-800 p-6 rounded-lg shadow-xl">
            <h2 class="text-xl font-semibold mb-4 border-b border-gray-600 pb-2">Data yang Diuji</h2>
            <ul class="space-y-3 text-lg">
                <li><span class="font-semibold text-gray-400">Durasi Layar:</span> <span class="text-white"><?= $data_uji['durasi_layar'] ?> jam</span></li>
                <li><span class="font-semibold text-gray-400">Durasi Sosmed:</span> <span class="text-white"><?= $data_uji['durasi_sosmed'] ?> jam</span></li>
                <li><span class="font-semibold text-gray-400">Durasi Tidur:</span> <span class="text-white"><?= $data_uji['durasi_tidur'] ?> jam</span></li>
                <li><span class="font-semibold text-gray-400">Nilai K:</span> <span class="text-white"><?= $k ?></span></li>
            </ul>
        </div>
        <div class="lg:col-span-2 bg-teal-900/50 border border-teal-500 p-6 rounded-lg shadow-2xl flex flex-col justify-center items-center text-center">
            <h2 class="text-xl font-semibold mb-2 text-teal-300">Hasil Prediksi Resiko Depresi</h2>
            <p class="text-5xl font-extrabold 
                <?php
                if ($hasil_klasifikasi == 'Tinggi') echo 'text-red-400';
                elseif ($hasil_klasifikasi == 'Sedang') echo 'text-yellow-400';
                else echo 'text-green-400';
                ?>">
                <?= $hasil_klasifikasi ?>
            </p>
            <p class="text-gray-400 mt-2">Berdasarkan <?= $k ?> tetangga terdekat.</p>

            <form action="<?= base_url('klasifikasi/simpan') ?>" method="post" class="mt-6 w-full max-w-xs">
                <?= csrf_field() ?>
                <input type="hidden" name="durasi_layar" value="<?= $data_uji['durasi_layar'] ?>">
                <input type="hidden" name="durasi_sosmed" value="<?= $data_uji['durasi_sosmed'] ?>">
                <input type="hidden" name="durasi_tidur" value="<?= $data_uji['durasi_tidur'] ?>">
                <input type="hidden" name="k" value="<?= $k ?>">
                <input type="hidden" name="hasil_klasifikasi" value="<?= $hasil_klasifikasi ?>">

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 shadow-md">
                    Simpan Hasil Klasifikasi
                </button>
            </form>
        </div>
    </div>

    <div class="bg-slate-800 p-6 rounded-lg shadow-xl mb-8">
        <h2 class="text-2xl font-bold mb-4 text-teal-400">Detail Perhitungan</h2>

        <div class="mb-8">
            <h3 class="text-xl font-semibold mb-4 border-b border-gray-600 pb-2">Tabel <?= $k ?> Tetangga Terdekat</h3>
            <div class="relative overflow-x-auto rounded-lg">
                <table class="w-full text-sm text-left text-gray-200">
                    <thead class="text-xs text-white uppercase bg-gray-700">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">D. Layar</th>
                            <th class="px-6 py-3">D. Sosmed</th>
                            <th class="px-6 py-3">D. Tidur</th>
                            <th class="px-6 py-3 bg-teal-900/50">Jarak Euclidean</th>
                            <th class="px-6 py-3">Resiko Depresi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tetangga_terdekat as $row) : ?>
                            <tr class="bg-slate-800 border-b border-gray-700 hover:bg-gray-700">
                                <th class="px-6 py-4 whitespace-nowrap"><?= $row['id'] ?></th>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_layar'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_sosmed'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_tidur'] ?></td>
                                <td class="px-6 py-4 bg-teal-900/50 font-mono whitespace-nowrap"><?= number_format($row['jarak'], 4) ?></td>
                                <td class="px-6 py-4 font-semibold whitespace-nowrap 
                                    <?php
                                    if ($row['resiko_depresi'] == 'Tinggi') echo 'text-red-400';
                                    elseif ($row['resiko_depresi'] == 'Sedang') echo 'text-yellow-400';
                                    else echo 'text-green-400';
                                    ?>">
                                    <?= $row['resiko_depresi'] ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p class="text-xs text-gray-400 mt-2">* Tabel diurutkan berdasarkan Jarak Euclidean terpendek.</p>
        </div>

        <div>
            <h3 class="text-xl font-semibold mb-4 border-b border-gray-600 pb-2">Tabel Perhitungan Jarak (Semua Data Latih)</h3>
            <div class="relative overflow-x-auto rounded-lg max-h-96">
                <table class="w-full text-sm text-left text-gray-200">
                    <thead class="text-xs text-white uppercase bg-gray-700 sticky top-0">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">D. Layar</th>
                            <th class="px-6 py-3">D. Sosmed</th>
                            <th class="px-6 py-3">D. Tidur</th>
                            <th class="px-6 py-3 bg-teal-900/50">Jarak Euclidean</th>
                            <th class="px-6 py-3">Resiko Depresi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        <?php foreach ($perhitungan_jarak as $row) : ?>
                            <tr class="hover:bg-gray-700">
                                <th class="px-6 py-4 whitespace-nowrap"><?= $row['id'] ?></th>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_layar'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_sosmed'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_tidur'] ?></td>
                                <td class="px-6 py-4 bg-teal-900/50 font-mono whitespace-nowrap"><?= number_format($row['jarak'], 4) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['resiko_depresi'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>