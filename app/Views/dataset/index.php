<?php helper('form'); ?>
<?= $this->extend('layout/layout'); ?>
<?= $this->section('content'); ?>

<!-- Latar belakang: #FFE1AF (Krem) - WARNA SOLID -->
<div class="min-h-screen bg-[#FFE1AF] py-8 px-4">
    <div class="container mx-auto max-w-7xl relative z-10">

        <!-- Header (Solid Putih) -->
        <div class="bg-white rounded-2xl p-6 mb-6 shadow-xl border border-gray-200">
            <div class="flex items-center gap-4">
                <!-- Ikon Header (Solid Terracotta) -->
                <div class="p-3 bg-[#B77466] rounded-xl shadow-md">
                    <img src="<?= base_url('public/data.png') ?>" alt="Dataset" class="w-12 h-12"
                         onerror="this.src='https://placehold.co/32x32/FFFFFF/B77466?text=DB'; this.onerror=null;">
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-[#957C62]">Manajemen Dataset</h1>
                    <p class="text-[#957C62]/70">Kelola data penjualan produk untuk analisis</p>
                </div>
            </div>
        </div>

        <!-- Action Cards (Solid Putih) -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            
            <!-- Upload CSV -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-lg">
                <div class="flex items-center gap-3 mb-4">
                    <img src="<?= base_url('public/images/icon_upload.png') ?>" alt="Upload" class="w-6 h-6"
                         onerror="this.style.display='none'">
                    <h3 class="font-bold text-lg text-[#957C62]">Impor CSV</h3>
                </div>
                <form action="<?= base_url('dataset/upload') ?>" method="post" enctype="multipart/form-data" class="space-y-3">
                    <?= csrf_field() ?>
                    <input type="file" name="dataset_csv" required
                           class="block w-full text-sm text-[#957C62] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:font-semibold file:bg-[#B77466] file:text-white hover:file:bg-[#957C62] transition cursor-pointer">
                    <!-- Tombol Solid (TANPA GRADIENT) -->
                    <button type="submit"
                            class="w-full bg-[#B77466] hover:bg-[#957C62] text-white font-semibold py-2.5 rounded-lg transition-all transform hover:scale-105 shadow-md">
                        Upload & Ganti Data
                    </button>
                </form>
            </div>

            <!-- Delete All -->
            <div class="bg-white p-6 rounded-xl border border-red-200 shadow-lg">
                <div class="flex items-center gap-3 mb-2">
                    <img src="<?= base_url('public/images/icon_delete.png') ?>" alt="Hapus" class="w-6 h-6"
                         onerror="this.style.display='none'">
                    <h3 class="font-bold text-lg text-red-700">Hapus Semua Data</h3>
                </div>
                <p class="text-sm text-gray-600 mb-4">Menghapus seluruh dataset secara permanen.</p>
                <form action="<?= base_url('dataset/hapusSemua') ?>" method="post" onsubmit="return confirm('PERINGATAN! Semua data akan dihapus permanen. Yakin?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-lg transition-all transform hover:scale-105 shadow-md">
                        Hapus Semua
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid lg:grid-cols-3 gap-6">

            <!-- Table (Solid Putih) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
                    <!-- Header Tabel (Solid Coklat Muted) -->
                    <div class="p-5 bg-[#957C62] flex justify-between items-center">
                        <h2 class="text-lg font-bold text-white flex items-center gap-3">
                            <img src="<?= base_url('public/images/icon_table.png') ?>" alt="Tabel" class="w-5 h-5"
                                 onerror="this.style.display='none'">
                            Data Penjualan
                        </h2>
                        <span class="px-3 py-1 bg-[#FFE1AF]/30 rounded-full text-sm text-white font-semibold">
                            Total: <?= (!empty($dataset) && is_array($dataset)) ? count($dataset) : 0 ?>
                        </span>
                    </div>

                    <!-- Wrapper Tabel (Teks Jelas) -->
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
                        <table class="w-full text-sm">
                            <!-- Header Tabel (Teks Jelas) -->
                            <thead class="sticky top-0 bg-gray-100 text-[#957C62] text-xs uppercase z-10">
                                <tr>
                                    <th class="px-3 py-3 text-left">ID</th>
                                    <th class="px-3 py-3 text-left">Waktu</th>
                                    <th class="px-3 py-3 text-left">Produk</th>
                                    <th class="px-3 py-3 text-left">Kategori</th>
                                    <th class="px-3 py-3 text-left">Harga</th>
                                    <th class="px-3 py-3 text-left">Terjual</th>
                                    <th class="px-3 py-3 text-left">Promosi</th>
                                    <th class="px-3 py-3 text-left">Penurunan</th>
                                    <th class="px-3 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <!-- Body Tabel (Teks Jelas) -->
                            <tbody class="text-gray-800">
                                <?php if (empty($dataset)) : ?>
                                    <tr>
                                        <td colspan="9" class="px-6 py-8 text-center text-gray-500">
                                            <img src="<?= base_url('public/images/icon_empty.png') ?>" alt="Kosong" class="w-16 h-16 mx-auto mb-3 text-gray-300"
                                                 onerror="this.src='https://placehold.co/64x64/F3F4F6/9CA3AF?text=Empty'; this.onerror=null;">
                                            Belum ada data. Tambah manual atau upload CSV.
                                        </td>
                                    </tr>
                                <?php else : ?>
                                    <?php foreach ($dataset as $i => $row) : ?>
                                        <tr class="<?= ($i % 2 == 0) ? 'bg-white' : 'bg-gray-50' ?> border-b border-gray-200 hover:bg-[#FFE1AF]/40 transition">
                                            <td class="px-3 py-2 font-medium text-[#B77466]"><?= $row['id'] ?></td>
                                            <td class="px-3 py-2 text-gray-700 whitespace-nowrap"><?= date('d/m/y', strtotime($row['waktu_penjualan'])) ?></td>
                                            <td class="px-3 py-2 text-gray-900 font-medium whitespace-nowrap"><?= esc($row['nama_produk']) ?></td>
                                            <td class="px-3 py-2 text-gray-600 whitespace-nowrap"><?= esc($row['kategori_produk']) ?></td>
                                            <td class="px-3 py-2 text-gray-700 whitespace-nowrap"><?= number_format($row['harga_produk_rp'], 0, ',', '.') ?></td>
                                            <td class="px-3 py-2 text-gray-700"><?= number_format($row['jumlah_terjual_unit'], 0, ',', '.') ?></td>
                                            <td class="px-3 py-2">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $row['status_promosi'] == 'Ya' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' ?>">
                                                    <?= $row['status_promosi'] ?>
                                                </span>
                                            </td>
                                            <td class="px-3 py-2">
                                                <span class="px-2 py-1 text-xs font-bold rounded-full <?= $row['terjadi_penurunan'] == 'Ya' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' ?>">
                                                    <?= $row['terjadi_penurunan'] ?>
                                                </span>
                                            </td>
                                            <td class="px-3 py-2 text-center">
                                                <form action="<?= base_url('dataset/delete/' . $row['id']) ?>" method="post" onsubmit="return confirm('Yakin hapus data ini?');" class="inline">
                                                    <?= csrf_field() ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <!-- Tombol Hapus: Solid Terracotta -->
                                                    <button type="submit" class="bg-[#B77466] hover:bg-[#957C62] text-white text-xs font-medium py-1 px-3 rounded-full transition">
                                                        Hapus
                                                    </button>
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

            <!-- Form (Solid Putih) -->
            <div class="bg-white p-6 rounded-xl shadow-xl border border-gray-200">
                <div class="flex items-center gap-3 mb-5 pb-4 border-b border-[#E2B59A]/50">
                    <img src="<?= base_url('public/images/icon_add.png') ?>" alt="Tambah" class="w-6 h-6"
                         onerror="this.style.display='none'">
                    <h2 class="text-lg font-bold text-[#957C62]">Tambah Data</h2>
                </div>

                <form action="<?= base_url('dataset/save') ?>" method="post" class="space-y-4">
                    <?= csrf_field() ?>

                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700">Waktu Penjualan</label>
                        <input type="date" name="waktu_penjualan" required class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-transparent text-sm text-gray-900">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="nama_produk" placeholder="Indomie Goreng" required class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-transparent text-sm text-gray-900">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-sm font-medium text-gray-700">Kategori</label>
                        <input type="text" name="kategori_produk" placeholder="Makanan Instan" required class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-transparent text-sm text-gray-900">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block mb-1.5 text-sm font-medium text-gray-700">Harga (Rp)</label>
                            <input type="number" name="harga_produk_rp" placeholder="3000" required class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-transparent text-sm text-gray-900">
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-medium text-gray-700">Terjual</label>
                            <input type="number" name="jumlah_terjual_unit" placeholder="150" required class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-transparent text-sm text-gray-900">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block mb-1.5 text-sm font-medium text-gray-700">Promosi</label>
                            <select name="status_promosi" required class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-transparent text-sm text-gray-900">
                                <option value="Tidak">Tidak</option>
                                <option value="Ya">Ya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1.5 text-sm font-semibold text-[#B77466]">Penurunan</label>
                            <select name="terjadi_penurunan" required class="w-full px-3 py-2 bg-gray-50 border-2 border-[#B77466] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#B77466] focus:border-[#B77466] text-sm text-gray-900">
                                <option value="Tidak">Tidak</option>
                                <option value="Ya">Ya</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Solid (TANPA GRADIENT) -->
                    <button type="submit" class="w-full bg-[#B77466] hover:bg-[#957C62] text-white font-semibold py-2.5 rounded-lg transition-all transform hover:scale-105 shadow-md mt-6">
                        Simpan Data
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 
    Tidak ada CSS kustom <style> di sini.
    Semua animasi (hover:scale-105, hover:-translate-y-1) 
    menggunakan murni Tailwind.
-->

<?= $this->endSection(); ?>