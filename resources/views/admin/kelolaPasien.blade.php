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
                    <h3 class="text-2xl font-bold mb-4">Kelola Data Pasien</h3>
                    <p class="text-xl mb-4">Tambah Data Pasien</p>
                    <form action="{{ route('tambah.pasien') }}" method="post" class="mb-4">
                        @csrf
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-black">Nama</label>
                                <input type="text" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-black">Alamat</label>
                                <input type="text" name="alamat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-black">No.KTP</label>
                                <input type="text" name="no_ktp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                            </div> 
                            <div>
                                <label class="block mb-2 text-sm font-medium text-black">No.HP</label>
                                <input type="text" name="nohp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                            </div> 
                        </div>      
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </form>
                    <p class="text-xl mb-4">Daftar Pasien</p>
                    <table class="border border-slate-500">
                        <thead>
                          <tr>
                            <th class="border border-slate-600 py-2 px-2">No.</th>
                            <th class="border border-slate-600 py-2 px-20">Nama</th>
                            <th class="border border-slate-600 py-2 px-24">Alamat</th>
                            <th class="border border-slate-600 py-2 px-24">No.KTP</th>
                            <th class="border border-slate-600 py-2 px-24">No.HP</th>
                            <th class="border border-slate-600 py-2 px-20">A</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($pasien as $no=>$data)
                        <tr>
                            <td class="border border-slate-600 py-1 text-center">{{ $no+1 }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->nama }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->alamat }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->no_ktp }}</td>
                            <td class="border border-slate-600 py-1 text-center">{{ $data->no_hp }}</td>
                            <td class="border border-slate-600 py-1 text-center">
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
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Data Pasien</h3>
                                                <button type="button" class="text-gray-700 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8" data-modal-hide="edit-modal-{{ $data->id }}">
                                                    &times;
                                                </button>
                                            </div>
                                            <!-- Modal Body -->
                                            <form action="{{ route('update.pasien', $data->id) }}" method="post" class="p-4" >
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                                    <input type="text" name="nama" value="{{ $data->nama }}" 
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                                    <input type="text" name="alamat" value="{{ $data->alamat }}" 
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700">No.KTP</label>
                                                    <input type="text" name="no_ktp" value="{{ $data->no_ktp }}" 
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 pl-2">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-700">No.HP</label>
                                                    <input type="text" name="nohp" value="{{ $data->no_hp }}" 
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
                                    <form action="{{ route('delete.pasien', $data->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="focus:outline-none text-yellow-300 bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 px-4 py-2  ml-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                      </table>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>