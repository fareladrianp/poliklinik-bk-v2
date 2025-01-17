<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css') <!-- Gunakan Vite untuk mengompilasi Tailwind CSS -->
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col fixed h-full">
            <div class="p-4">
                <h1 class="text-xl font-bold">Admin Dashboard</h1>
            </div>
            <nav class="flex-1 px-2 space-y-2">
                <a href="{{ route('dashboard.admin') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('kelola.dokter') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Dokter</a>
                <a href="{{ route('kelola.pasien') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Pasien</a>
                <a href="{{ route('kelola.poli') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Poli</a>
                <a href="{{ route('kelola.obat') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Obat</a>
            </nav>
            <div class="p-4">
                <form method="get" action="{{ route('logout.dokter') }}">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 bg-red-500 rounded hover:bg-red-600">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col ml-64">
            <!-- Header -->
            <header class="bg-white shadow-md">
                <div class="container mx-auto px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Welcome, {{ session('nama') }}</h2>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 container mx-auto px-6 py-6">
                <div class="bg-white rounded shadow p-6">
                    <h3 class="text-2xl font-bold mb-4">Dashboard</h3>
                    <div class="flex">
                    <div class="w-52 rounded overflow-hidden shadow-lg bg-lime-500 mr-6">
                        <div class="px-6 py-4 flex items-center">
                            <div>
                                <svg class="h-8 w-8 text-black"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                  </svg>                                  
                            </div>
                            <div class="ml-6">
                                <div class="font-bold text-xl mb-2">Pasien</div>
                                    <p class="font-bold text-lg mb-2">
                                        {{$jumlahPasien}}
                                    </p>
                            </div>
                        </div>
                    </div>
                    <div class="w-52 rounded overflow-hidden shadow-lg bg-blue-500 mr-6">
                        <div class="px-6 py-4 flex items-center">
                            <div>
                                <svg class="h-8 w-8 text-black"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                  </svg>
                                  
                            </div>
                            <div class="ml-6">
                                <div class="font-bold text-xl mb-2">Dokter</div>
                                    <p class="font-bold text-lg mb-2">
                                        {{$jumlahDokter}}
                                    </p>
                            </div>
                        </div>
                    </div>
                    <div class="w-52 rounded overflow-hidden shadow-lg bg-yellow-500 mr-6">
                        <div class="px-6 py-4 flex items-center">
                            <div>
                                <svg class="h-8 w-8 text-black"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="3" y1="21" x2="21" y2="21" />  <path d="M4 21v-15a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v15" />  <path d="M9 21v-8a3 3 0 0 1 6 0v8" /></svg>
                            </div>
                            <div class="ml-6">
                                <div class="font-bold text-xl mb-2">Poli</div>
                                    <p class="font-bold text-lg mb-2">
                                        {{$jumlahPoli}}
                                    </p>
                            </div>
                        </div>
                    </div>
                    <div class="w-52 rounded overflow-hidden shadow-lg bg-red-500 mr-6">
                        <div class="px-6 py-4 flex items-center">
                            <div>
                                <svg class="h-8 w-8 text-black"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="14" y1="12" x2="14" y2="12.01" />  <line x1="10" y1="12" x2="10" y2="12.01" />  <line x1="12" y1="10" x2="12" y2="10.01" />  <line x1="12" y1="14" x2="12" y2="14.01" />  <path d="M4.5 12.5l8 -8a4.94 4.94 0 0 1 7 7l-8 8a4.94 4.94 0 0 1 -7 -7" /></svg>
                                  
                            </div>
                            <div class="ml-6">
                                <div class="font-bold text-xl mb-2">Obat</div>
                                    <p class="font-bold text-lg mb-2">
                                        {{$jumlahObat}}
                                    </p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>