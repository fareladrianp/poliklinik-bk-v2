{{-- @extends('layout.template')

<div>
    <h3>Pasien Dashboard</h3>

    <a href="{{ route('logout.pasien') }}">Logout</a>
</div> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasien Dashboard</title>
    @vite('resources/css/app.css') <!-- Gunakan Vite untuk mengompilasi Tailwind CSS -->
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-4">
                <h1 class="text-xl font-bold">Pasien Dashboard</h1>
            </div>
            <nav class="flex-1 px-2 space-y-2">
                <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('daftar.poli.pasien') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Daftar Poli</a>
                <a href="{{ route('daftar.jadwal.pasien') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Jadwal Poli</a>
            </nav>
            <div class="p-4">
                <form method="get" action="{{ route('logout.pasien') }}">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 bg-red-500 rounded hover:bg-red-600">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-md">
                <div class="container mx-auto px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Welcome, {{ session('nama') }}</h2>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 container mx-auto px-6 py-6">
                <div class="bg-white rounded shadow p-6">
                    <h3 class="text-2xl font-bold mb-4">Selamat Datang di Poliklinik BK</h3>
                    <p class="text-gray-700">..................</p>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
