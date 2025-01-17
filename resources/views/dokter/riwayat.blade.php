@extends('layout.script')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <div class="w-full p-6">
                        <h2 class="text-xl font-bold text-black mb-4"><b>Riwayat Pasien</b></h2>
                        @php
                            use Carbon\Carbon;
                        @endphp
                    <table class="border border-slate-500">
                        <thead>
                          <tr>
                            <th class="border border-slate-600 py-2 px-2">No.Urut</th>
                            <th class="border border-slate-600 py-2 px-8">Nama Pasien</th>
                            <th class="border border-slate-600 py-2 px-16">Alamat</th>
                            <th class="border border-slate-600 py-2 px-16">No. KTP</th>
                            <th class="border border-slate-600 py-2 px-16">No. HP</th>
                            <th class="border border-slate-600 py-2 px-7">No. RM</th>
                            <th class="border border-slate-600 py-2 px-16">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($daftar as $data)
                        <tr>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->no_antrian }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->pasien->nama }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->pasien->alamat }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->pasien->no_ktp }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->pasien->no_hp }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->pasien->no_rm }}</td>
                            <td class="border border-slate-600 py-1 text-center">
                                <div class="flex justify-center">
                                    <!-- Edit Button -->
                                    <button data-modal-target="edit-modal-{{ $data->id }}" data-modal-toggle="edit-modal-{{ $data->id }}" 
                                        class="focus:outline-none text-gray-900  font-medium rounded-lg text-sm px-4 py-2 mr-1 bg-blue-400">
                                        Detail
                                    </button>
                            
                                    <!-- Modal for Editing -->
                                    <div id="edit-modal-{{ $data->id }}" tabindex="-1" aria-hidden="true" 
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
                                        <div class="relative p-4 w-2/3 max-h-full">
                                            <div class="bg-white rounded-lg shadow dark:bg-gray-300 pb-11 px-8">
                                                <!-- Modal Header -->
                                                <div class="flex items-center justify-between p-4 border-b dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold  text-black">Detail Periksa</h3>
                                                    <button type="button" class="text-gray-700 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8" data-modal-hide="edit-modal-{{ $data->id }}">
                                                        &times;
                                                    </button>
                                                </div>
                                                <!-- Modal Body -->
                                                <div class="m-2">
                                                    <table class="border-2">
                                                        <thead>
                                                            <tr>
                                                                <th class="border-2 p-3 border-slate-800">No.</th>
                                                                <th class="border-2 border-slate-800 px-4">TanggalPeriksa</th>
                                                                <th class="border-2 border-slate-800 px-4">NamaPasien</th>
                                                                <th class="border-2 border-slate-800 px-4">NamaDokter</th>
                                                                <th class="border-2 border-slate-800 px-4">Keluhan</th>
                                                                <th class="border-2 border-slate-800 px-4">Catatan</th>
                                                                <th class="border-2 border-slate-800 px-4">Obat</th>
                                                                <th class="border-2 border-slate-800 px-4">BiayaPeriksa</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="border-2 p-3 border-slate-800">{{$loop->iteration}}</td>
                                                                <td class="border-2 border-slate-800">{{ $data->periksa->tgl_periksa }}</td>
                                                                <td class="border-2 border-slate-800">{{ $data->pasien->nama }}</td>
                                                                <td class="border-2 border-slate-800">{{ $data->jadwalPeriksa->dokter->nama }}</td>
                                                                <td class="border-2 border-slate-800">{{ $data->keluhan }}</td>
                                                                <td class="border-2 border-slate-800">{{ $data->periksa->catatan }}</td>
                                                                <td class="border-2 border-slate-800">
                                                                    @if ($data->periksa)
                                                                        @foreach ($data->periksa->detailPeriksa as $detail)
                                                                                {{ $detail->obat->nama_obat ?? '-' }},
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                                <td class="border-2 border-slate-800">{{ $data->periksa->biaya_periksa }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                </div>
            
                
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        </script>
</body>
</html>