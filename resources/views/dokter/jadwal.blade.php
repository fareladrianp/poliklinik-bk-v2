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
                    <h3 class="text-2xl font-bold mb-4">Jadwal</h3>
                    <p class="text-xl mb-4">Input Jadwal</p>
                    <form action="{{ route('tambah.jadwal') }}" method="post" class="mb-4">
                        @csrf
                        <div class="grid gap-6 mb-6 md:grid-cols-3">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-black">Hari</label>
                                <select name="hari" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-black">Jam Mulai</label>
                                <input type="time" name="jam_mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-black">Jam Selesai</label>
                                <input type="time" name="jam_selesai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                            </div> 
                        </div>      
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </form>
                    <div>
                        <table class="border border-slate-500">
                            <thead>
                              <tr>
                                <th class="border border-slate-600 py-2 px-2">Nama Dokter</th>
                                <th class="border border-slate-600 py-2 px-20">Hari</th>
                                <th class="border border-slate-600 py-2 px-16">Jam Mulai</th>
                                <th class="border border-slate-600 py-2 px-16">Jam Selesai</th>
                                <th class="border border-slate-600 py-2 px-20">Status</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach ($jadwal as $data)
                            <tr>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->dokter->nama}}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->hari}}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->jam_mulai}}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->jam_selesai}}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->status === 0 ? 'Tidak Aktif' : 'Aktif'}}</td>
                                <td class="border border-slate-600 border-r-0 py-1 px-4 text-center">
                                    <label for="switch-{{ $data->id }}" class="inline-flex relative items-center cursor-pointer">
                                        <input type="checkbox" id="switch-{{ $data->id }}" 
                                               class="sr-only peer" 
                                               data-id="{{ $data->id }}" 
                                               {{ $data->status ? 'checked' : '' }} 
                                               onchange="updateStatus(this)">
                                        <div class="w-10 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 
                                                    rounded-full peer dark:bg-gray-700 peer-checked:bg-green-500 
                                                    peer-checked:after:translate-x-4 after:content-[''] after:absolute after:top-[2px] 
                                                    after:left-[2px] after:bg-white after:border-gray-300 after:border 
                                                    after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600">
                                        </div>
                                    </label>
                                </td>
                                <td class="border border-slate-600 border-l-0 py-1 px-3 text-center">
                                   <div class="flex justify-center">
                                    <!-- Edit Button -->
                                    <button data-modal-target="edit-modal-{{ $data->id }}" data-modal-toggle="edit-modal-{{ $data->id }}" 
                                        class="focus:outline-none text-black bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-4 py-2  dark:focus:ring-yellow-900 mr-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
    
                                    <!-- Modal for Editing -->
                                    <div id="edit-modal-{{ $data->id }}" tabindex="-1" aria-hidden="true" 
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full">
                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="bg-white rounded-lg shadow dark:bg-gray-400">
                                                <!-- Modal Header -->
                                                <div class="flex items-center justify-between p-4 border-b dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Data Poli</h3>
                                                    <button type="button" class="text-gray-700 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8" data-modal-hide="edit-modal-{{ $data->id }}">
                                                        &times;
                                                    </button>
                                                </div>
                                                <!-- Modal Body -->
                                                <form action="{{ route('update.jadwal', $data->id) }}" method="post" class="p-4" >
                                                    @csrf
                                                    <div class="mb-4">
                                                        <label class="block text-sm font-medium text-gray-700">Hari</label>
                                                        <input type="text" name="hari" value="{{ $data->hari }}" 
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="block text-sm font-medium text-gray-700">Jam Mulai</label>
                                                        <input type="time" name="jam_mulai" value="{{ $data->jam_mulai }}" 
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="block text-sm font-medium text-gray-700">Jam Selesai</label>
                                                        <input type="time" name="jam_selesai" value="{{ $data->jam_selesai }}" 
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
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
        function updateStatus(checkbox) {
            const id = checkbox.dataset.id;
            const status = checkbox.checked ? 1 : 0;
    
            fetch(`/jadwal/${id}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Refresh halaman jika respons berhasil
                    location.reload();
                } else {
                    throw new Error(data.message || 'Gagal memperbarui status');
                }
            })
            .catch(error => {
                // Kembalikan status checkbox jika gagal
                checkbox.checked = !checkbox.checked;
                alert(error.message || 'Terjadi kesalahan, silakan coba lagi.');
            });
        }
    </script>
</body>
</html>