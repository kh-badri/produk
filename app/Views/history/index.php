<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<div class="container mx-auto p-4 lg:p-8 text-gray-100">

    <h1 class="text-3xl font-bold mb-6 text-teal-700">Riwayat Hasil Klasifikasi</h1>

    <!-- Tabel Data Riwayat -->
    <div class="bg-slate-800 rounded-lg shadow-xl overflow-hidden">
        <div class="p-4 sm:p-6">
            <h2 class="text-xl font-semibold">Daftar Riwayat</h2>
        </div>

        <!-- Wrapper untuk membuat tabel bisa di-scroll horizontal di layar kecil -->
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-200">
                <thead class="text-xs text-white uppercase bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">No.</th>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">D. Layar</th>
                        <th scope="col" class="px-6 py-3">D. Sosmed</th>
                        <th scope="col" class="px-6 py-3">D. Tidur</th>
                        <th scope="col" class="px-6 py-3">K</th>
                        <th scope="col" class="px-6 py-3">Hasil Klasifikasi</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($history)) : ?>
                        <tr class="bg-slate-800 border-b border-gray-700">
                            <td colspan="8" class="px-6 py-4 text-center">Belum ada riwayat klasifikasi.</td>
                        </tr>
                    <?php else : ?>
                        <?php $i = 1; ?>
                        <?php foreach ($history as $row) : ?>
                            <tr class="bg-slate-800 border-b border-gray-700 hover:bg-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap"><?= $i++ ?></th>
                                <td class="px-6 py-4 whitespace-nowrap"><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_layar'] ?> jam</td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_sosmed'] ?> jam</td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['durasi_tidur'] ?> jam</td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= $row['k'] ?></td>
                                <td class="px-6 py-4 font-semibold whitespace-nowrap 
                                    <?php
                                    if ($row['hasil_klasifikasi'] == 'Tinggi') echo 'text-red-400';
                                    elseif ($row['hasil_klasifikasi'] == 'Sedang') echo 'text-yellow-400';
                                    else echo 'text-green-400';
                                    ?>">
                                    <?= $row['hasil_klasifikasi'] ?>
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <a href="<?= base_url('history/delete/' . $row['id']) ?>"
                                        class="font-medium text-red-500 hover:text-red-700 transition duration-300"
                                        onclick="return confirm('Anda yakin ingin menghapus data riwayat ini?');">
                                        Hapus
                                    </a>
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