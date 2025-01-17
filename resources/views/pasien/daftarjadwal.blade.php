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
        <div class="flex-1 flex flex-col ml-64">
            <!-- Header -->
            <header class="bg-white shadow-md">
                <div class="container mx-auto px-6 py-4">
                    <h2 class="text-xl font-semibold text-gray-800">Welcome, {{ session('nama') }}</h2>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 container mx-auto px-6 py-6">
                <div class="flex gap-4 p-6">
                    <!-- Form Daftar Poli -->
                    <div class="w-full bg-white rounded shadow p-6">
                        <p class="text-2xl mb-4"><b>Daftar Jadwal</b></p>
                        <p class="text-xl mb-4">Poli Anak</p>
                        <table class="border border-slate-500 mb-6">
                            <thead>
                              <tr>
                                <th class="border border-slate-600 py-2 px-2">No.</th>
                                <th class="border border-slate-600 py-2 px-20">Nama</th>
                                <th class="border border-slate-600 py-2 px-24">Hari</th>
                                <th class="border border-slate-600 py-2 px-24">Jam Mulai</th>
                                <th class="border border-slate-600 py-2 px-24">Jam Selesai</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach ($poliAnak as $no=>$data)
                            <tr>
                                <td class="border border-slate-600 py-1 text-center">{{ $no+1 }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->dokter->nama }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->hari }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->jam_mulai }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->jam_selesai }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                          </table>
                          <p class="text-xl mb-4">Poli Gigi</p>
                        <table class="border border-slate-500 mb-6">
                            <thead>
                              <tr>
                                <th class="border border-slate-600 py-2 px-2">No.</th>
                                <th class="border border-slate-600 py-2 px-20">Nama</th>
                                <th class="border border-slate-600 py-2 px-24">Hari</th>
                                <th class="border border-slate-600 py-2 px-24">Jam Mulai</th>
                                <th class="border border-slate-600 py-2 px-24">Jam Selesai</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach ($poliGigi as $no=>$data)
                            <tr>
                                <td class="border border-slate-600 py-1 text-center">{{ $no+1 }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->dokter->nama }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->hari }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->jam_mulai }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->jam_selesai }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                          </table>
                          <p class="text-xl mb-4">Poli Umum</p>
                        <table class="border border-slate-500">
                            <thead>
                              <tr>
                                <th class="border border-slate-600 py-2 px-2">No.</th>
                                <th class="border border-slate-600 py-2 px-20">Nama</th>
                                <th class="border border-slate-600 py-2 px-24">Hari</th>
                                <th class="border border-slate-600 py-2 px-24">Jam Mulai</th>
                                <th class="border border-slate-600 py-2 px-24">Jam Selesai</th>
                              </tr>
                            </thead>
                            <tbody>
                            @foreach ($poliUmum as $no=>$data)
                            <tr>
                                <td class="border border-slate-600 py-1 text-center">{{ $no+1 }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->dokter->nama }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->hari }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->jam_mulai }}</td>
                                <td class="border border-slate-600 py-1 text-center">{{ $data->jam_selesai }}</td>
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
        document.getElementById('poli').addEventListener('change', function () {
          const poliId = this.value;
      
          // Bersihkan opsi jadwal
          const jadwalSelect = document.getElementById('jadwal');
          jadwalSelect.innerHTML = '<option value="" disabled selected>Memuat jadwal...</option>';
      
          // Lakukan request ke server untuk mendapatkan jadwal dokter
          fetch(`/get-jadwal-by-poli/${poliId}`)
            .then(response => response.json())
            .then(data => {
              jadwalSelect.innerHTML = '<option value="" disabled selected>Pilih Jadwal</option>';
              data.forEach(jadwal => {
                const option = document.createElement('option');
                option.value = jadwal.id;
                option.textContent = `${jadwal.hari} ${jadwal.jam_mulai} - ${jadwal.jam_selesai} (Dokter: ${jadwal.dokter.nama})`;
                jadwalSelect.appendChild(option);
              });
            })
            .catch(error => {
              console.error('Terjadi kesalahan:', error);
              jadwalSelect.innerHTML = '<option value="" disabled>Gagal memuat jadwal</option>';
            });
        });
      </script>
</body>
</html>
