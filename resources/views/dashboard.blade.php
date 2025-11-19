<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ayam Kabogor</title>
    @vite('resources/css/app.css')
</head>
<body>

<div class="flex h-screen bg-gray-100">
    <!-- Side bar -->
    <aside class="flex flex-col h-screen w-64 p-4 text-white bg-gradient-to-r from-orange-800 to-amber-400">

        <ul class="list-none p-0 space-y-2 grow">
            <!-- Logo kabogor -->
            <li class="p-2 rounded-lg">
                <div class="flex flex-col items-center">
                    <img src="{{asset('images/AyamKabogorLogo1.png')}}" alt="Logo Ayam Kabogor" class="w-56 mb-1">
                </div>
            </li>
            <!-- Icon Dashboard -->
            <li class="p-2 rounded-lg hover:bg-[#CC4901] aria-selected:bg-[#CC4901] transition duration-150" aria-selected="true">
                <div class="flex flex-col items-center">
                    <img src="{{asset('images/dashboardicon.png')}}" alt="Dashboard Icon" class="w-8 h-8 mb-1">
                    <a class="text-sm font-medium" href="dashboard.html">Dashboard</a>
                </div>
            </li>
            <!-- Icon Manajemen Produk -->
            <li class="p-2 rounded-lg hover:bg-[#CC4901] aria-selected:bg-[#CC4901] transition duration-150">
                <div class="flex flex-col items-center">
                    <img href="manajemenproduk.html" src="{{asset('images/manajemenmenuicon.png')}}" alt="Manajemen Produk Icon" class="w-8 h-8 mb-1">
                    <a class="text-sm font-medium" href="manajemenproduk.html">Manajemen Produk</a>
                </div>
            </li>
            <!-- Icon Manajemen User -->
            <li class="p-2 rounded-lg hover:bg-[#CC4901] aria-selected:bg-[#CC4901] transition duration-150">
                <div class="flex flex-col items-center">
                    <img src="{{asset('images/manajemenpelangganicon.png')}}" alt="Manajemen User Icon" class="w-8 h-8 mb-1">
                    <a class="text-sm font-medium" href="#">Manajemen User</a>
                </div>
            </li>
            <!-- Icon Manajemen Order -->
            <li class="p-2 rounded-lg hover:bg-[#CC4901] aria-selected:bg-[#CC4901] transition duration-150">
                <div class="flex flex-col items-center">
                    <img src="{{asset('images/manajemenpesananicon.png')}}" alt="Manajemen Order Icon" class="w-8 h-8 mb-1">
                    <a class="text-sm font-medium" href="#">Manajemen Order</a>
                </div>
            </li>
        </ul>
        <!-- Logout dan Profile button -->
        <div class="flex flex-col items-center mt-4">
            <img src="{{asset('images/profileiconbaru.png')}}" alt="Profile Icon" class="w-48 h-16 mb-1">
            <a class="text-sm font-medium" href="#">Logout</a>
        </div>
    </aside>

    <!-- Konten utama -->
    <div class="flex-1 flex flex-col">
        
        <header class="h-16 border-b border-gray-200 bg-white p-4 flex items-center shadow-md z-10">
            <h1 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-orange-800 to-amber-400">Dashboard</h1>
        </header>

        <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">

            <!-- Section Paling Atas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-4 rounded-lg shadow flex items-center">
                    <div class="w-16 h-16 mr-4 rounded-lg bg-[#CC4901] flex items-center justify-center text-white">
                        <img src="{{asset('images/User.png')}}" alt="">
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{$jumlahNonAdmin}}</p>
                        <p class="text-sm text-gray-500">Total Pengguna</p>
                    </div>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow flex items-center">
                    <div class="w-16 h-16 mr-4 rounded-lg bg-[#CC4901] flex items-center justify-center text-white">
                        <img class="w-8" src="{{asset('images/manajemenpesananicon.png')}}" alt="">
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{$jumlahOrderSukses}}</p>
                        <p class="text-sm text-gray-500">Total Pesanan</p>
                    </div>
                </div>
                

                 <div class="bg-white p-4 rounded-lg shadow flex items-center">
                    <div class="w-16 h-16 mr-4 rounded-lg bg-[#CC4901] flex items-center justify-center text-white">
                        <img class="w-8" src="{{asset('images/Dining.png')}}" alt="">
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{$totalProducts}}</p>
                        <p class="text-sm text-gray-500">Total Menu</p>
                    </div>
                </div>
            </div>

            <!-- Section Aktivitas Terkini -->
            <h2 class="text-xl font-semibold mb-4 text-orange-600">Data Hari Ini</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-4 rounded-lg shadow flex items-center">
                    <div class="w-16 h-16 mr-4 rounded-lg bg-[#CC4901] flex items-center justify-center text-white">
                        <img src="{{asset('images/User.png')}}" alt="">
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{$countToday}}</p>
                        <p class="text-sm text-gray-500">Pengguna Baru</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow flex items-center">
                     <div class="w-16 h-16 mr-4 rounded-lg bg-[#CC4901] flex items-center justify-center text-white">
                        <img class="w-8" src="{{asset('images/manajemenpesananicon.png')}}" alt="">
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">{{$ordersTodayUncancelled}}</p>
                        <p class="text-sm text-gray-500">Pesanan Baru</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow flex items-center">
                    <div class="w-16 h-16 mr-4 rounded-lg bg-[#CC4901] flex items-center justify-center text-white">
                        <img class="w-8" src="{{asset('images/click.png')}}" alt="">
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-800">27</p>
                        <p class="text-sm text-gray-500">Klik CTA Hari Ini</p>
                    </div>
                </div>
            </div>
            
            <!-- Section Filter Tanggal (DIBUNGKUS DENGAN FORM) -->
            <form method="GET" action="" class="flex space-x-8 mb-8 items-end">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Awal</label>
                    <div class="flex items-center border border-gray-300 rounded-lg p-2 bg-white">
                        <!-- INPUT type="date" Fungsional -->
                        <input 
                            type="date" 
                            id="start_date" 
                            name="start_date" 
                            value="{{ request('start_date') ?? \Carbon\Carbon::now()->format('Y-m-d') }}" 
                            class="w-full text-sm focus:outline-none bg-white"
                        >
                        <!-- SVG Dihapus -->
                    </div>
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                    <div class="flex items-center border border-gray-300 rounded-lg p-2 bg-white">
                        <!-- INPUT type="date" Fungsional -->
                        <input 
                            type="date" 
                            id="end_date" 
                            name="end_date" 
                            value="{{ request('end_date') ?? \Carbon\Carbon::now()->format('Y-m-d') }}" 
                            class="w-full text-sm focus:outline-none bg-white"
                        >
                        <!-- SVG Dihapus -->
                    </div>
                </div>
                
                <!-- Tombol Submit Form -->
                <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg shadow transition duration-150">
                    Filter Data
                </button>
            </form>
 


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Section Produk Terlaris -->
                <div class="lg:col-span-1">
                    <h2 class="text-xl font-semibold mb-4 text-orange-600">Produk Terlaris</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-3 rounded-lg shadow text-center">
                            <img src="...image-paket-1..." alt="Paket 1" class="w-full h-24 object-cover rounded mb-2">
                            <p class="font-bold">PAKET 1</p>
                            <p class="text-sm text-gray-500">150 Pcs</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg shadow text-center">
                            <img src="...image-paket-2..." alt="Paket 2" class="w-full h-24 object-cover rounded mb-2">
                            <p class="font-bold">PAKET 2</p>
                            <p class="text-sm text-gray-500">50 Pcs</p>
                        </div>
                    </div>
                </div>

                <!-- Section Statistik Tambahan -->
                <div class="lg:col-span-2">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">Statistik Tambahan</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-lg shadow flex items-center">
                            <div class="w-16 h-16 mr-4 rounded-lg bg-[#CC4901] flex items-center justify-center text-white"></div>
                            <div><p class="text-3xl font-bold text-gray-800">{{$usersCreatedInPeriod}}</p><p class="text-sm text-gray-500">Pengguna Baru</p></div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow flex items-center">
                            <div class="w-16 h-16 mr-4 rounded-lg bg-[#CC4901] flex items-center justify-center text-white"></div>
                            <div><p class="text-3xl font-bold text-gray-800">{{$completedOrdersInPeriod}}</p><p class="text-sm text-gray-500">Pesanan</p></div>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow flex items-center">
                            <div class="w-16 h-16 mr-4 rounded-lg bg-[#CC4901] flex items-center justify-center text-white"></div>
                            <div><p class="text-3xl font-bold text-gray-800">10</p><p class="text-sm text-gray-500">Klik CTA</p></div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        </div>
</div>

</body>
</html>