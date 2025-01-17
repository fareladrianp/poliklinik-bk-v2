@extends('layout.script')
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
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-4">
                <h1 class="text-xl font-bold">Dokter Dashboard</h1>
            </div>
            <nav class="flex-1 px-2 space-y-2">
                <a href="{{ route('dashboard.dokter') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Dashboard</a>
                <a href="{{ route('profil.dokter') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Profile</a>
                <a href="{{ route('jadwal.dokter') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Jadwal</a>
                <a href="{{ route('periksa.dokter') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Periksa</a>
                <a href="{{ route('riwayat.dokter') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Riwayat Pasien</a>
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
                    <h3 class="text-2xl font-bold mb-4">Profile</h3>
                    <div>
                        <table class="ml-3 mt-3">
                                <tr>
                                    <td class="p-2">Nama</td>
                                    <td class="pl-10">: {{$dokter->nama}}</td>
                                </tr>
                                <tr>
                                    <td class="p-2">Alamat</td>
                                    <td class="pl-10">: {{$dokter->alamat}}</td>
                                </tr>
                                <tr>
                                    <td class="p-2">No. HP</td>
                                    <td class="pl-10">: {{$dokter->no_hp}}</td>
                                </tr>
                                <tr>
                                    <td class="p-2">Poli</td>
                                    <td class="pl-10">: {{$dokter->poli->nama_poli}}</td>
                                </tr>
                        </table>
                        <button data-modal-target="edit-modal-{{ $dokter->id }}" data-modal-toggle="edit-modal-{{ $dokter->id }}" 
                            class="focus:outline-none ml-5 mt-3 text-black bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-4 py-2  dark:focus:ring-yellow-900 mr-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>

                        <!-- Modal for Editing -->
                        <div id="edit-modal-{{ $dokter->id }}" tabindex="-1" aria-hidden="true" 
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="bg-white rounded-lg shadow dark:bg-gray-400">
                                    <!-- Modal Header -->
                                    <div class="flex items-center justify-between p-4 border-b dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Data Dokter</h3>
                                        <button type="button" class="text-gray-700 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8" data-modal-hide="edit-modal-{{ $dokter->id }}">
                                            &times;
                                        </button>
                                    </div>
                                    <!-- Modal Body -->
                                    <form action="{{ route('profil.update.dokter', $dokter->id) }}" method="post" class="p-4" >
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Nama</label>
                                            <input type="text" name="nama" value="{{ $dokter->nama }}" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                            <input type="text" name="alamat" value="{{ $dokter->alamat }}" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">No. HP</label>
                                            <input type="text" name="nohp" value="{{ $dokter->no_hp }}" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                        </div>
                                        <div>
                                            <label for="id_poli" class="form-label block mb-2 text-sm font-medium text-black">Poli</label>
                                                <select class="form-control bg-slate-300 rounded-md block w-full p-2.5 mb-3" name="id_poli">
                                                    <option value="" disabled selected>Pilih Poli</option>
                                                    @foreach ($poli as $dpoli)
                                                    <option value="{{ $dpoli->id }}">
                                                        {{ $dpoli->nama_poli }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <!-- Modal Footer -->
                                        <div class="flex justify-end">
                                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-4 py-2">Simpan</button>
                                            <button type="button" data-modal-hide="edit-modal-{{ $dokter->id }}" class="ml-2 text-gray-500 hover:text-gray-800">Batal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>