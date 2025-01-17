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
                        <h2 class="text-xl font-bold text-black mb-4"><b>Periksa Pasien</b></h2>
                        @php
                            use Carbon\Carbon;
                        @endphp
                    <table class="border border-slate-500">
                        <thead>
                          <tr>
                            <th class="border border-slate-600 py-2 px-2">No.Urut</th>
                            <th class="border border-slate-600 py-2 px-24">Nama Pasien</th>
                            <th class="border border-slate-600 py-2 px-24">Keluhan</th>
                            <th class="border border-slate-600 py-2 px-24">Jadwal</th>
                            <th class="border border-slate-600 py-2 px-24">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($daftar as $data)
                        <tr>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->no_antrian }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->pasien->nama }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->keluhan }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->jadwalPeriksa->hari }}, {{ Carbon::parse($data->jadwalPeriksa->jam_mulai)->format('H.i') }} - 
                                {{ Carbon::parse($data->jadwalPeriksa->jam_selesai)->format('H.i') }}</td>
                            <td class="border border-slate-600 py-1 text-center">
                                <div class="flex justify-center">
                                    <!-- Edit Button -->
                                    <button data-modal-target="edit-modal-{{ $data->id }}" data-modal-toggle="edit-modal-{{ $data->id }}" 
                                        class="focus:outline-none text-gray-900 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-4 py-2 dark:focus:ring-yellow-900 mr-1 {{ $data->status === 0 ? 'bg-red-500' : 'bg-green-500' }}">
                                        {{$data->status === 0 ? 'Belum diperiksa' : 'Sudah diperiksa'}}
                                    </button>
                            
                                    <!-- Modal for Editing -->
                                    <div id="edit-modal-{{ $data->id }}" tabindex="-1" aria-hidden="true" 
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="bg-white rounded-lg shadow dark:bg-gray-400">
                                                <!-- Modal Header -->
                                                <div class="flex items-center justify-between p-4 border-b dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Periksa</h3>
                                                    <button type="button" class="text-gray-700 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8" data-modal-hide="edit-modal-{{ $data->id }}">
                                                        &times;
                                                    </button>
                                                </div>
                                                <!-- Modal Body -->
                                                <form action="{{ route('tambah.periksa.dokter', $data->id) }}" method="post" class="p-4">
                                                    @csrf
                                                    <div class="mb-4">
                                                        <label for="nama_obat" class="block text-sm font-medium text-gray-700">Nama Pasien</label>
                                                        <input type="text" name="nama" value="{{ $data->pasien->nama }}" readonly
                                                            class="mt-1 block w-full rounded-sm bg-slate-300 border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="kemasan" class="block text-sm font-medium text-gray-700">Tanggal Periksa</label>
                                                        <input type="datetime-local" name="tgl_periksa"
                                                            class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                                                        <input type="text" name="catatan"
                                                            class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="block text-sm font-medium text-gray-700">Obat</label>
                                                        <div id="obat-wrapper-{{ $data->id }}">
                                                            <div class="flex items-center gap-2 mb-2">
                                                                <select name="obat[]" class="w-full p-2 border rounded bg-gray-100 text-slate-950" onchange="calculateTotal({{ $data->id }})">
                                                                    <option value="" disabled selected>Pilih Obat</option>
                                                                    @foreach ($obat as $item)
                                                                        <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">{{ $item->nama_obat }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button type="button" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600" onclick="addObat({{ $data->id }})">Tambah</button>
                                                            </div>
                                                        </div>
                                                    </div>
                            
                                                    <div class="mb-4">
                                                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga Total</label>
                                                        <input type="text" name="harga_total" id="harga_total_{{ $data->id }}" value="150000" readonly class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                                    </div>
                                                    <!-- Modal Footer -->
                                                    <div class="flex justify-end">
                                                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-4 py-2">Simpan</button>
                                                        <button type="button" data-modal-hide="edit-modal-{{ $data->id }}" class="ml-2 text-gray-500 hover:text-gray-800">Batal</button>
                                                    </div>
                                                </form>
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
        // Function to add a new obat row
        function addObat(id) {
            const wrapper = document.getElementById('obat-wrapper-' + id);
            const newRow = document.createElement('div');
            newRow.className = 'flex items-center gap-2 mb-2';
            newRow.innerHTML = `
                <select name="obat[]" class="w-full p-2 border rounded bg-gray-100 text-slate-950" onchange="calculateTotal(${id})">
                    <option value="" disabled selected>Pilih Obat</option>
                    @foreach ($obat as $item)
                        <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">{{ $item->nama_obat }}</option>
                    @endforeach
                </select>
                <button type="button" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600" onclick="removeObat(this, ${id})">Hapus</button>
            `;
            wrapper.appendChild(newRow);
            calculateTotal(id);  // Recalculate total when a new row is added
        }
        
        // Function to remove an obat row
        function removeObat(button, id) {
            const row = button.parentElement;
            row.remove();
            calculateTotal(id); // Recalculate total after removing a row
        }
        
        // Function to calculate the total price
        function calculateTotal(id) {
            const selects = document.querySelectorAll(`#obat-wrapper-${id} select[name="obat[]"]`);
            let total = 150000; // Base price
        
            selects.forEach(select => {
                const selectedOption = select.options[select.selectedIndex];
                const harga = parseInt(selectedOption.getAttribute('data-harga')) || 0;
                total += harga;
            });
        
            document.getElementById('harga_total_' + id).value = total; // Update total price
        }
        </script>
</body>
</html>