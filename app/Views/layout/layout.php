<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Analisis Naive Bayes') ?></title>

    <!-- Scripts (Tailwind & Alpine.js) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js" defer></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Style untuk Page Loader (Disesuaikan untuk TEMA TERANG) -->
    <style>
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #FFE1AF; /* Latar belakang Krem */
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
            border: 8px solid #E2B59A; /* Border Peach */
            border-top: 8px solid #B77466; /* Spinner Terracotta */
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

        /* Style kursor dari contoh home Anda (opsional) */
        .Typewriter__cursor {
            color: #B77466;
            font-weight: bold;
            animation: blink 0.7s infinite;
        }

        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>

<!-- Body dengan background TEMA TERANG (#FFE1AF) dan Teks Coklat (#957C62) -->
<body class="bg-[#FFE1AF] text-[#957C62] antialiased">

    <!-- Page Loader -->
    <div id="page-loader">
        <div class="spinner"></div>
    </div>

    <div class="min-h-screen flex flex-col">

        <!-- =================================================================== -->
        <!-- START: NAVBAR TEMA TERANG (KANAN) -->
        <!-- =================================================================== -->
        <!-- Navbar: Solid Putih, Shadow, Border Peach -->
        <nav x-data="{ mobileMenuOpen: false, profileMenuOpen: false }" class="bg-white shadow-md sticky top-0 z-50 border-b-2 border-[#E2B59A]/50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    <!-- Logo & Brand (Kiri) -->
                    <div class="flex items-center">
                        <a href="<?= base_url('/') ?>" class="flex-shrink-0 flex items-center gap-3">
                            <!-- SVG Ikon Analisis (Warna Terracotta) -->
                            <svg class="h-8 w-8 text-[#B77466]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span class="text-[#957C62] text-xl font-bold tracking-wider hidden sm:block">Analisis Naive Bayes</span>
                        </a>
                    </div>

                    <!-- ============================================= -->
                    <!-- PERUBAHAN: Grup Kanan (Navigasi + Profil + Hamburger) -->
                    <!-- ============================================= -->
                    <div class="flex items-center">
                        
                        <!-- Navigasi Desktop (Disebelah Kanan) -->
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <!-- Link Aktif: BG Terracotta, Link Inaktif: Teks Coklat -->
                                <a href="<?= base_url('/') ?>" class="transition duration-300 px-3 py-2 rounded-md text-sm font-medium <?= ($active_menu ?? '') === 'home' ? 'bg-[#B77466] text-white' : 'text-[#957C62] hover:bg-[#FFE1AF]/60 hover:text-[#B77466]' ?>">Home</a>
                                <a href="<?= base_url('/dataset') ?>" class="transition duration-300 px-3 py-2 rounded-md text-sm font-medium <?= ($active_menu ?? '') === 'dataset' ? 'bg-[#B77466] text-white' : 'text-[#957C62] hover:bg-[#FFE1AF]/60 hover:text-[#B77466]' ?>">Dataset</a>
                                <a href="<?= base_url('/analisis') ?>" class="transition duration-300 px-3 py-2 rounded-md text-sm font-medium <?= ($active_menu ?? '') === 'analisis' ? 'bg-[#B77466] text-white' : 'text-[#957C62] hover:bg-[#FFE1AF]/60 hover:text-[#B77466]' ?>">Analisis</a>
                                <a href="<?= base_url('/history') ?>" class="transition duration-300 px-3 py-2 rounded-md text-sm font-medium <?= ($active_menu ?? '') === 'history' ? 'bg-[#B77466] text-white' : 'text-[#957C62] hover:bg-[#FFE1AF]/60 hover:text-[#B77466]' ?>">History</a>
                            </div>
                        </div>

                        <!-- Dropdown Profil Desktop (Disebelah Kanan) -->
                        <div class="hidden md:block ml-4">
                            <div class="relative">
                                <button @click="profileMenuOpen = !profileMenuOpen" type="button" class="max-w-xs bg-[#FFE1AF]/60 rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-[#B77466]">
                                    <span class="sr-only">Buka menu pengguna</span>
                                    <img class="h-8 w-8 rounded-full object-cover" 
                                         src="<?= base_url('uploads/foto_profil/' . esc(session()->get('foto'))) ?>" 
                                         alt="Foto Profil"
                                         onerror="this.src='https://placehold.co/32x32/957C62/FFE1AF?text=User'; this.onerror=null;">
                                </button>
                                <!-- Dropdown: Teks Logout diubah ke #B77466 (Terracotta) -->
                                <div x-show="profileMenuOpen" @click.away="profileMenuOpen = false" x-transition class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" x-cloak>
                                    <div class="px-4 py-2 border-b border-[#E2B59A]/50">
                                        <p class="text-sm font-semibold text-gray-800"><?= esc(session()->get('username')) ?></p>
                                        <p class="text-xs text-gray-500">User</p>
                                    </div>
                                    <a href="<?= base_url('/akun') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pengaturan Akun</a>
                                    <a href="<?= site_url('logout') ?>" class="block px-4 py-2 text-sm text-[#B77466] hover:bg-gray-100">Logout</a>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Hamburger (Disebelah Kanan) -->
                        <div class="ml-4 -mr-2 flex md:hidden">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="bg-[#FFE1AF]/60 inline-flex items-center justify-center p-2 rounded-md text-[#957C62] hover:text-[#B77466] hover:bg-[#E2B59A]/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-[#B77466]">
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
                    <!-- ============================================= -->
                    <!-- AKHIR: Grup Kanan -->
                    <!-- ============================================= -->

                </div>
            </div>

            <!-- Menu Mobile (TEMA TERANG) -->
            <div x-show="mobileMenuOpen" class="md:hidden bg-white shadow-lg" x-cloak>
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <a href="<?= base_url('/') ?>" class="transition duration-300 block px-3 py-2 rounded-md text-base font-medium <?= ($active_menu ?? '') === 'home' ? 'bg-[#B77466] text-white' : 'text-[#957C62] hover:bg-[#FFE1AF]/60 hover:text-[#B77466]' ?>">Home</a>
                    <a href="<?= base_url('/dataset') ?>" class="transition duration-300 block px-3 py-2 rounded-md text-base font-medium <?= ($active_menu ?? '') === 'dataset' ? 'bg-[#B77466] text-white' : 'text-[#957C62] hover:bg-[#FFE1AF]/60 hover:text-[#B77466]' ?>">Dataset</a>
                    <a href="<?= base_url('/analisis') ?>" class="transition duration-300 block px-3 py-2 rounded-md text-base font-medium <?= ($active_menu ?? '') === 'analisis' ? 'bg-[#B77466] text-white' : 'text-[#957C62] hover:bg-[#FFE1AF]/60 hover:text-[#B77466]' ?>">Analisis</a>
                    <a href="<?= base_url('/history') ?>" class="transition duration-300 block px-3 py-2 rounded-md text-base font-medium <?= ($active_menu ?? '') === 'history' ? 'bg-[#B77466] text-white' : 'text-[#957C62] hover:bg-[#FFE1AF]/60 hover:text-[#B77466]' ?>">History</a>
                </div>
                <div class="pt-4 pb-3 border-t border-[#E2B59A]/50">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full object-cover" 
                                 src="<?= base_url('uploads/foto_profil/' . esc(session()->get('foto'))) ?>" 
                                 alt="Foto Profil"
                                 onerror="this.src='https://placehold.co/40x40/957C62/FFE1AF?text=User'; this.onerror=null;">
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-[#957C62]"><?= esc(session()->get('username')) ?></div>
                            <div class="text-sm font-medium leading-none text-gray-500">User</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="<?= base_url('/akun') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-[#B77466] hover:bg-[#FFE1AF]/60">Pengaturan Akun</a>
                        <a href="<?= site_url('logout') ?>" class="block px-3 py-2 rounded-md text-base font-medium text-[#B77466] hover:text-[#B77466] hover:bg-[#FFE1AF]/60">Logout</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- =================================================================== -->
        <!-- END: NAVBAR TEMA TERANG -->
        <!-- =================================================================== -->

        <!-- Konten Utama Aplikasi -->
        <main class="flex-1 w-full">
            <?= $this->renderSection('content') ?>
        </main>

    </div>

    <!-- Script untuk Page Loader dan Notifikasi (TEMA TERANG) -->
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
                background: '#fff', // Latar belakang putih
                color: '#957C62'  // Teks Coklat
            });
        <?php endif; ?>
    </script>

</body>

</html>