<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - Ayam Kabogor</title>
    @vite('resources/css/app.css')
    
    <!-- CSS KUSTOM UNTUK WARNA, GRADIENT, DAN LAYOUT -->
    <style>
        /* 1. Gradien Kustom untuk Background: bg-kabogor-gradient (Horizontal) */
        .bg-kabogor-gradient {
            background-image: linear-gradient(to right, #CC4901, #FFA40F);
        }

        /* 2. Text Gradien */
        .text-gradient {
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
            background-image: linear-gradient(to right, #CC4901, #FFA40F);
        }

        /* 3. Warna Kustom #CC4901 untuk Hover/Active */
        .hover-kabogor:hover {
            background-color: #CC4901;
        }
        .active-kabogor {
            background-color: #CC4901; /* Warna aktif menu utama */
        }

        /* 4. Warna Kustom #CC4901 untuk Tombol */
        .bg-kabogor-dark {
            background-color: #CC4901;
        }
        .hover-bg-kabogor-light:hover {
            background-color: #FFA40F;
        }

        /* 5. Sub-Sidebar Styling */
        #sub-sidebar {
            background-color: #CC4901; 
            z-index: 20;
            /* Transisi untuk width agar smooth saat muncul/sembunyi */
            transition: width 300ms ease-in-out, transform 300ms ease-in-out; 
        }

        /* KELAS BARU: Menyembunyikan Sub-Sidebar dengan lebar 0 */
        .sub-sidebar-hidden {
            width: 0 !important;
            overflow: hidden;
            /* Efek dorongan saat menyembunyi (opsional) */
            transform: translateX(-100%); 
        }
        
        /* Default styling untuk mematikan aria-selected saat tidak aktif */
        li[aria-selected="false"] {
            background-color: transparent !important; 
        }

        /* Memastikan active-kabogor bekerja */
        li.active-kabogor[aria-selected="true"] {
            background-color: #CC4901;
        }
    </style>
</head>
<body>

<div class="flex h-screen bg-gray-100">

    <!-- =================================== 1. SIDEBAR UTAMA (Narrow, Icon-Only) =================================== -->
    <aside id="main-sidebar" class="flex flex-col h-screen w-24 p-4 text-white bg-kabogor-gradient z-30">

        <ul class="list-none p-0 space-y-2 grow">
            <!-- Logo kabogor -->
            <li class="p-2 rounded-lg">
                <div class="flex flex-col items-center">
                    <img src="{{asset('images/AyamKabogorLogo1.png')}}" alt="Logo Ayam Kabogor" class="w-20 mb-1">
                </div>
            </li>
            
            <!-- Icon Dashboard -->
            <li id="dashboard-menu" class="p-2 rounded-lg hover:bg-[#CC4901] transition duration-150 li-active-bg" aria-selected="false">
                <div class="flex flex-col items-center">
                    <img src="{{asset('images/dashboardicon.png')}}" alt="Dashboard Icon" class="w-8 h-8 mb-1">
                    <a class="text-xs font-medium" href="{{ url('dashboard') }}">Dashboard</a>
                </div>
            </li>
            
            <!-- Icon Manajemen Produk (ACTIVE ITEM DI HALAMAN INI) -->
            <li id="manajemen-menu-item" class="p-2 rounded-lg hover:bg-[#CC4901] transition duration-150 li-active-bg" aria-selected="true">
                <div class="flex flex-col items-center">
                    <img src="{{asset('images/manajemenmenuicon.png')}}" alt="Manajemen Produk Icon" class="w-8 h-8 mb-1">
                    <a class="text-xs font-medium text-center" href="{{ url('manajemenproduk') }}">Manajemen Produk</a>
                </div>
            </li>
            
            <!-- Icon Manajemen User -->
            <li class="p-2 rounded-lg hover:bg-[#CC4901] transition duration-150 li-active-bg" aria-selected="false">
                <div class="flex flex-col items-center">
                    <img src="{{asset('images/manajemenpelangganicon.png')}}" alt="Manajemen User Icon" class="w-8 h-8 mb-1">
                    <a class="text-xs font-medium text-center" href="#">Manajemen User</a>
                </div>
            </li>
            <!-- Icon Manajemen Order -->
            <li class="p-2 rounded-lg hover:bg-[#CC4901] transition duration-150 li-active-bg" aria-selected="false">
                <div class="flex flex-col items-center">
                    <img src="{{asset('images/manajemenpesananicon.png')}}" alt="Manajemen Order Icon" class="w-8 h-8 mb-1">
                    <a class="text-xs font-medium text-center" href="#">Manajemen Order</a>
                </div>
            </li>
        </ul>
        
        <!-- Logout dan Profile button -->
        <div class="flex flex-col items-center mt-4">
            <img src="{{asset('images/profileiconbaru.png')}}" alt="Profile Icon" class="w-10 h-10 mb-1 rounded-full border-2 border-white">
            <a class="text-xs font-medium" href="#">Logout</a>
        </div>
    </aside>

    <!-- =================================== 2. SUB-SIDEBAR (Adjacent) =================================== -->
    <div id="sub-sidebar" 
         class="h-screen w-40 shadow-xl z-20 bg-[#CC4901] transition-all duration-300 sub-sidebar-hidden">
         
        <ul class="list-none p-4 space-y-1 h-full">
            <!-- Item Sub-Menu. bg-orange-800 = warna aktif sub-menu. -->
            <li class="py-2 px-3 rounded-md bg-orange-800 text-white font-semibold cursor-pointer" data-target="tambah">Tambah Menu</li>
            <li class="py-2 px-3 rounded-md hover:bg-orange-800 text-white cursor-pointer" data-target="lihat">Lihat Menu</li>
            <li class="py-2 px-3 rounded-md hover:bg-orange-800 text-white cursor-pointer" data-target="edit">Edit Menu</li>
            <li class="py-2 px-3 rounded-md hover:bg-orange-800 text-white cursor-pointer" data-target="hapus">Hapus Menu</li>
        </ul>
    </div>

    <!-- =================================== 3. KONTEN UTAMA =================================== -->
    <div class="flex-1 flex flex-col">
        
        <header class="h-16 border-b border-gray-200 bg-white p-4 flex items-center shadow-md z-10">
            <!-- Gradien Teks: Menggunakan kelas text-gradient dan gradien standar Tailwind -->
            <h1 id="main-header-title" class="text-xl font-bold text-gradient bg-gradient-to-r from-orange-800 to-amber-400">Tambah Menu</h1>

             <!-- Action Buttons di kanan Header (Default untuk Tambah Menu) -->
            <div class="flex-1 flex justify-end space-x-3">
                <button id="draft-button" class="px-4 py-2 text-sm font-semibold rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Simpan Sebagai Draft</button>
                <button id="action-button" class="px-4 py-2 text-sm font-semibold rounded-lg text-white bg-kabogor-dark hover-bg-kabogor-light transition duration-150">Tambah</button>
            </div>
        </header>

         <!-- AREA KONTEN UTAMA (KOSONG DAN SIAP DIISI) -->
        <main class="flex-1 p-6 bg-white overflow-y-auto">
             
             <h2 class="text-2xl font-semibold mb-6 text-gray-800" id="content-title">Form Tambah Menu</h2>
             
             <div id="manajemen-produk-content">
                <!-- Konten Form Tambah Menu akan diletakkan di sini oleh JS -->
             </div>
        </main>
    </div>
</div>

<script>
    // =====================================
    // LOGIKA JAVASCRIPT UNTUK SUB-MENU
    // =====================================

    document.addEventListener('DOMContentLoaded', () => {
        const manajemenMenuItem = document.getElementById('manajemen-menu-item');
        const subSidebar = document.getElementById('sub-sidebar');
        const mainHeaderTitle = document.getElementById('main-header-title');
        const contentArea = document.getElementById('manajemen-produk-content');
        const contentTitle = document.getElementById('content-title');
        const menuItems = subSidebar.querySelectorAll('li');
        const draftButton = document.getElementById('draft-button');
        const actionButton = document.getElementById('action-button');
        const allMainMenuItems = document.querySelectorAll('#main-sidebar > ul > li');

        // Fungsi untuk mengaktifkan item menu utama
        function setActiveMainMenuItem(targetItem) {
            allMainMenuItems.forEach(item => {
                item.classList.remove('active-kabogor');
                item.setAttribute('aria-selected', 'false');
            });
            if (targetItem) {
                targetItem.classList.add('active-kabogor');
                targetItem.setAttribute('aria-selected', 'true');
            }
        }

        // Fungsi untuk mengaktifkan sub-menu (styling)
        function setActiveSubMenu(element) {
            menuItems.forEach(item => {
                item.classList.remove('bg-orange-800');
                item.classList.remove('font-semibold');
            });
            element.classList.add('bg-orange-800'); 
            element.classList.add('font-semibold'); 
        }
        
        // Fungsi untuk mengupdate tombol di header
        function updateHeaderButtons(mode) {
            draftButton.style.display = 'none';
            actionButton.style.display = 'none';
            actionButton.className = 'px-4 py-2 text-sm font-semibold rounded-lg text-white transition duration-150'; // Reset kelas
            draftButton.className = 'px-4 py-2 text-sm font-semibold rounded-lg border transition duration-150'; // Reset kelas
            
            if (mode === 'form') { // Tambah Menu
                draftButton.style.display = 'inline-block';
                draftButton.textContent = 'Simpan Sebagai Draft';
                draftButton.classList.add('border-gray-300', 'text-gray-700', 'hover:bg-gray-100');

                actionButton.style.display = 'inline-block';
                actionButton.textContent = 'Tambah';
                actionButton.classList.add('bg-kabogor-dark', 'hover-bg-kabogor-light');

            } else if (mode === 'edit-form') { // Form Edit
                draftButton.style.display = 'inline-block';
                draftButton.textContent = 'Batalkan';
                draftButton.classList.add('border-red-600', 'text-red-600', 'hover:bg-red-50');

                actionButton.style.display = 'inline-block';
                actionButton.textContent = 'Simpan';
                actionButton.classList.add('bg-green-600', 'hover:bg-green-700');
            }
            // Mode 'list' (Lihat/Hapus) tidak menampilkan tombol aksi
        }

        // Fungsi untuk menampilkan Sub-Sidebar (menggunakan lebar penuh 40)
        function showSubSidebar() {
            subSidebar.classList.remove('sub-sidebar-hidden');
            subSidebar.classList.add('w-40');
        }

        // Fungsi untuk menyembunyikan Sub-Sidebar (menggunakan lebar 0)
        function hideSubSidebar() {
            subSidebar.classList.add('sub-sidebar-hidden');
            subSidebar.classList.remove('w-40');
        }


        // Logika Klik pada Menu Utama
        manajemenMenuItem.addEventListener('click', (e) => {
            // Pastikan Manajemen Produk aktif
            setActiveMainMenuItem(e.currentTarget); 
            // Tampilkan Sub-Sidebar
            showSubSidebar(); 
            // Klik default Sub-Menu (Tambah Menu)
            const defaultItem = subSidebar.querySelector('[data-target="tambah"]');
            if (defaultItem) {
                defaultItem.click();
            }
        });

        // Logika Klik pada Menu Dashboard (untuk menyembunyikan Sub-Sidebar)
        document.getElementById('dashboard-menu').addEventListener('click', (e) => {
            // Non-aktifkan Manajemen Produk
            setActiveMainMenuItem(e.currentTarget);
            // Sembunyikan Sub-Sidebar
            hideSubSidebar();
            // Reset header/content ke Dashboard placeholder
            mainHeaderTitle.textContent = 'Dashboard';
            contentTitle.textContent = 'Area Dashboard';
            contentArea.innerHTML = '<p class="text-gray-500">Konten Dashboard berada di sini.</p>';
            updateHeaderButtons('list');
        });


        // Logika untuk Sub-menu (Tambah, Lihat, Edit, Hapus)
        menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                const target = e.target.getAttribute('data-target');
                const title = e.target.textContent;
                
                setActiveSubMenu(e.target);
                mainHeaderTitle.textContent = title;
                contentTitle.textContent = title.includes('Tambah') ? 'Form Tambah Menu' : title.replace('Menu', 'Menu');

                // LOGIKA PENGGANTIAN KONTEN
                switch (target) {
                    case 'tambah':
                        updateHeaderButtons('form');
                        contentArea.innerHTML = getTambahMenuContent();
                        break;
                    case 'lihat':
                        updateHeaderButtons('list');
                        contentArea.innerHTML = getLihatMenuContent();
                        // attachViewButtonListeners(); // Placeholder
                        break;
                    case 'edit':
                        updateHeaderButtons('list');
                        contentArea.innerHTML = getEditMenuContent(); 
                        // attachEditButtonListeners(); // Placeholder
                        break;
                    case 'hapus':
                        updateHeaderButtons('list');
                        contentArea.innerHTML = getHapusMenuContent();
                        break;
                    default:
                        updateHeaderButtons('list');
                        contentArea.innerHTML = '';
                }
            });
        });
        
        // --- KONTEN FORM DAN LIST (DIPERLUKAN UNTUK JS) ---
        // Catatan: Fungsi konten disederhanakan/placeholder untuk demo layout

        function getEditFormContent(productId, readOnly = false) {
            // Konten Form Edit/View (Disederhanakan)
            const mockProduct = { id: productId, name: 'Paket 2 (Mock)', tag: 'Ayam', price: 'Rp40.000', stock: 5, description: '...' };
            const disabledAttr = readOnly ? 'disabled' : '';
            const readOnlyClass = readOnly ? 'bg-gray-100' : 'bg-white';

            return `
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Nama Menu *</label>
                            <input type="text" value="${mockProduct.name}" ${disabledAttr} class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-orange-500 focus:border-orange-500 ${readOnlyClass}">
                        </div>
                         <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Tag Menu *</label>
                            <input type="text" value="${mockProduct.tag}" ${disabledAttr} class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-orange-500 focus:border-orange-500 ${readOnlyClass}">
                        </div>
                         <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Harga Menu *</label>
                            <input type="text" value="${mockProduct.price}" ${disabledAttr} class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-orange-500 focus:border-orange-500 ${readOnlyClass}">
                        </div>
                         <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Jumlah Stok *</label>
                            <input type="text" value="${mockProduct.stock}" ${disabledAttr} class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-orange-500 focus:border-orange-500 ${readOnlyClass}">
                        </div>

                        <div class="space-y-1">
                             <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                             <div class="bg-gray-50 border border-gray-300 rounded-lg p-2 ${readOnlyClass}">
                                <div class="flex space-x-2 text-gray-600 mb-2 border-b pb-2 ${readOnlyClass}">
                                    <span class="font-bold">B</span>
                                    <span class="italic">I</span>
                                    <span class="underline">U</span>
                                    <span>Teks</span>
                                    <span>List</span>
                                </div>
                                <textarea class="w-full h-48 border-none bg-transparent focus:ring-0 resize-none text-gray-800" ${disabledAttr}>${mockProduct.description}</textarea>
                             </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 flex flex-col items-center">
                        <img src="{{asset('images/product-placeholder.png')}}" alt="Gambar Produk" class="w-full h-auto object-cover rounded-lg shadow-md mb-4 border border-gray-200">
                        ${readOnly ? '' : `<p class="text-xs text-gray-500 mt-1">Ganti gambar produk</p>`}
                    </div>
                </div>
            `;
        }
        
        function getTambahMenuContent() {
             return `
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Nama Produk *</label>
                            <input type="text" class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                         <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Tag Menu *</label>
                            <input type="text" class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                         <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Harga Menu *</label>
                            <input type="text" class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Jumlah Stok *</label>
                            <input type="text" class="w-full border-gray-300 rounded-lg shadow-sm p-2.5 focus:ring-orange-500 focus:border-orange-500">
                        </div>
                        <div class="space-y-1">
                             <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                             <div class="bg-gray-50 border border-gray-300 rounded-lg p-2">
                                <div class="flex space-x-2 text-gray-600 mb-2 border-b pb-2">
                                    <span class="font-bold">B</span>
                                    <span class="italic">I</span>
                                    <span class="underline">U</span>
                                    <span>Teks</span>
                                    <span>List</span>
                                </div>
                                <textarea class="w-full h-48 border-none bg-transparent focus:ring-0 resize-none text-gray-800" placeholder="Tulis deskripsi di sini..."></textarea>
                             </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center h-full text-center bg-gray-50">
                        <svg class="w-16 h-16 text-orange-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-1-5v3m0 0v3m-3-3h3m-3 0h3m-3 3h3m-3 0h3"></path></svg>
                        <p class="font-semibold text-gray-800">Drag dan Drop Gambar Atau Cari Gambar</p>
                        <p class="text-xs text-gray-500 mt-1">Maksimal Gambar Yang Dapat Diupload adalah 10 Mb</p>
                    </div>

                </div>
            `;
        }

        function getLihatMenuContent() {
             return `
             <div class="overflow-x-auto bg-white rounded-lg shadow-lg border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tag Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL Gambar</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 cursor-pointer"></td></tr>
                    </tbody>
                </table>
            </div>`;
        }

        function getEditMenuContent() {
             return `
             <div class="overflow-x-auto bg-white rounded-lg shadow-lg border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tag Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Stok</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <tr><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-center"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs edit-btn" data-id="0">Edit</button></td></tr>
                    </tbody>
                </table>
            </div>`;
        }

        function getHapusMenuContent() {
            return `
            <div class="overflow-x-auto bg-white rounded-lg shadow-lg border border-gray-100">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tag Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Stok</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <tr><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td><td class="px-6 py-4 whitespace-nowrap text-sm text-center"><button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs delete-btn">Hapus</button></td></tr>
                    </tbody>
                </table>
            </div>`;
        }

        // --- INISIALISASI ---

        // 1. Sembunyikan Sub-Sidebar di awal
        hideSubSidebar(); 
        
        // 2. Klik item Manajemen Produk secara default saat load
        manajemenMenuItem.click();
    });
</script>

</body>
</html>