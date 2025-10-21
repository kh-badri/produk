<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'KNN Klasifikasi App') ?></title>

    <!-- Scripts (Tailwind & Alpine.js) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js" defer></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Style untuk Page Loader (disesuaikan untuk dark theme) -->
    <style>
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #0f172a;
            /* slate-900 */
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s, visibility 0.5s;
        }

        #page-loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .spinner {
            border: 8px solid #334155;
            /* slate-700 */
            border-top: 8px solid #14b8a6;
            /* teal-500 */
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Mencegah 'flickering' saat Alpine.js memuat */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<!-- Body dengan background dark theme yang konsisten -->

<body class="bg-slate-900 text-gray-100 antialiased">

    <!-- Page Loader -->
    <div id="page-loader">
        <div class="spinner"></div>
    </div>

    <div class="min-h-screen flex flex-col">

        <!-- =================================================================== -->
        <!-- START: NAVBAR MODERN & RINGAN -->
        <!-- =================================================================== -->
        <nav x-data="{ mobileMenuOpen: false, profileMenuOpen: false }" class="bg-slate-800 shadow-lg sticky top-0 z-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    <!-- Logo & Brand (Menggunakan SVG Internal) -->
                    <div class="flex items-center">
                        <a href="<?= base_url('/') ?>" class="flex-shrink-0 flex items-center gap-3">
                            <!-- SVG Pengganti Ikon Font Awesome -->
                            <svg class="h-8 w-8 text-teal-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V8.25a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 8.25v7.5a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <span class="text-white text-xl font-bold tracking-wider hidden sm:block">Klasifikasi KNN</span>
                        </a>
                    </div>

                    <!-- Navigasi Desktop -->
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="<?= base_url('/') ?>" class="transition duration-300 px-3 py-2 rounded-md text-sm font-medium <?= ($active_menu ?? '') === 'home' ? 'bg-slate-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">Home</a>
                            <a href="<?= base_url('/dataset') ?>" class="transition duration-300 px-3 py-2 rounded-md text-sm font-medium <?= ($active_menu ?? '') === 'dataset' ? 'bg-slate-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">Dataset</a>
                            <a href="<?= base_url('/klasifikasi') ?>" class="transition duration-300 px-3 py-2 rounded-md text-sm font-medium <?= ($active_menu ?? '') === 'klasifikasi' ? 'bg-slate-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">Klasifikasi</a>
                            <a href="<?= base_url('/history') ?>" class="transition duration-300 px-3 py-2 rounded-md text-sm font-medium <?= ($active_menu ?? '') === 'history' ? 'bg-slate-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">History</a>
                        </div>
                    </div>

                    <!-- Dropdown Profil Desktop -->
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <div class="relative">
                                <button @click="profileMenuOpen = !profileMenuOpen" type="button" class="max-w-xs bg-gray-800 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                    <span class="sr-only">Buka menu pengguna</span>
                                    <img class="h-8 w-8 rounded-full object-cover" src="<?= base_url('uploads/foto_profil/' . esc(session()->get('foto'))) ?>" alt="Foto Profil">
                                </button>
                                <div x-show="profileMenuOpen" @click.away="profileMenuOpen = false" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" x-cloak>
                                    <div class="px-4 py-2 border-b border-gray-200">
                                        <p class="text-sm font-semibold text-gray-800"><?= esc(session()->get('username')) ?></p>
                                        <p class="text-xs text-gray-500">User</p>
                                    </div>
                                    <a href="<?= base_url('/akun') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan Akun</a>
                                    <a href="<?= site_url('logout') ?>" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Hamburger -->
                    <div class="-mr-2 flex md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                            <span class="sr-only">Buka menu utama</span>
                            <svg class="h-6 w-6" :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="h-6 w-6" :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menu Mobile -->
            <div x-show="mobileMenuOpen" class="md:hidden" x-cloak>
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="<?= base_url('/') ?>" class="transition duration-300 block px-3 py-2 rounded-md text-base font-medium <?= ($active_menu ?? '') === 'home' ? 'bg-slate-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">Home</a>
                    <a href="<?= base_url('/dataset') ?>" class="transition duration-300 block px-3 py-2 rounded-md text-base font-medium <?= ($active_menu ?? '') === 'dataset' ? 'bg-slate-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">Dataset</a>
                    <a href="<?= base_url('/klasifikasi') ?>" class="transition duration-300 block px-3 py-2 rounded-md text-base font-medium <?= ($active_menu ?? '') === 'klasifikasi' ? 'bg-slate-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">Klasifikasi</a>
                    <a href="<?= base_url('/history') ?>" class="transition duration-300 block px-3 py-2 rounded-md text-base font-medium <?= ($active_menu ?? '') === 'history' ? 'bg-slate-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' ?>">History</a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-700">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full object-cover" src="<?= base_url('uploads/foto_profil/' . esc(session()->get('foto'))) ?>" alt="Foto Profil">
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white"><?= esc(session()->get('username')) ?></div>
                            <div class="text-sm font-medium leading-none text-gray-400">User</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="<?= base_url('/akun') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Pengaturan Akun</a>
                        <a href="<?= site_url('logout') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- =================================================================== -->
        <!-- END: NAVBAR MODERN -->
        <!-- =================================================================== -->

        <!-- Konten Utama Aplikasi -->
        <main class="flex-1 w-full">
            <?= $this->renderSection('content') ?>
        </main>

    </div>

    <!-- Script untuk Page Loader dan Notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('load', function() {
            document.getElementById('page-loader').classList.add('hidden');
        });

        <?php if ($success = session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '<?= esc($success, 'js') ?>',
                timer: 2500,
                showConfirmButton: false,
                background: '#1e293b',
                color: '#e2e8f0'
            });
        <?php endif; ?>
    </script>

</body>

</html>