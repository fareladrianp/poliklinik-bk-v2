
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
                <div class="flex gap-4 p-6">
                    <!-- Form Daftar Poli -->
                    <div class="w-1/3 bg-white rounded shadow p-6">
                      <h2 class="text-lg font-bold text-blue-600 mb-4">Daftar Poli</h2>
                      <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-2" for="rekam-medis">Nomor Rekam Medis</label>
                        <input type="text" id="rekam-medis" class="w-full border-gray-300 bg-slate-400 rounded focus:outline-none focus:ring focus:ring-blue-500 p-2" value="202411-016" readonly>
                      </div>
                      <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-2" for="poli">Pilih Poli</label>
                        <select name="id_poli" id="poli" class="w-full border border-slate-600 rounded focus:outline-none focus:ring focus:ring-blue-500 p-2">
                          <option value="" disabled selected>Pilih Poli</option>
                          @foreach ($poli as $dpoli)
                          <option value="{{ $dpoli->id }}">{{ $dpoli->nama_poli }}</option>
                          @endforeach
                        </select>
                      </div>
                      <form action="{{route('tambah.poli.pasien')}}" method="post">
                      <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-2" for="jadwal">Pilih Jadwal</label>
                        <select id="jadwal" name="id_jadwal" class="w-full border border-slate-600 rounded focus:outline-none focus:ring focus:ring-blue-500 p-2">
                            <option value="" disabled selected>Open this select menu</option>
                        </select>
                    </div>
                      <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-2" for="keluhan">Keluhan</label>
                        <textarea id="keluhan" name="keluhan" class="w-full border border-slate-600 rounded focus:outline-none focus:ring focus:ring-blue-500 p-2"></textarea>
                      </div>
                      
                        @csrf
                        <button class="w-full bg-blue-500 text-white rounded p-2 hover:bg-blue-600">Daftar</button>
                      </form>
                      
                    </div>
                  
                    <!-- Riwayat Daftar Poli -->
                    <div class="w-2/3 bg-white rounded shadow p-6">
                      <h2 class="text-lg font-bold text-blue-600 mb-4">Riwayat daftar poli</h2>
                      <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border">
                          <thead>
                            <tr class="bg-blue-100">
                              <th class="border p-2">No.</th>
                              <th class="border p-2">Poli</th>
                              <th class="border p-2">Dokter</th>
                              <th class="border p-2">Hari</th>
                              <th class="border p-2">Mulai</th>
                              <th class="border p-2">Selesai</th>
                              <th class="border p-2">Antrian</th>
                              <th class="border p-2">Status</th>
                              <th class="border p-2">Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($riwayat as $item)
                            <tr>
                                <td class="border p-2">{{ $loop->iteration }}</td>
                                <td class="border p-2">{{ $item->jadwalPeriksa->dokter->poli->nama_poli }}</td>
                                <td class="border p-2">{{ $item->jadwalPeriksa->dokter->nama }}</td>
                                <td class="border p-2">{{ $item->jadwalPeriksa->hari }}</td>
                                <td class="border p-2">{{ $item->jadwalPeriksa->jam_mulai }}</td>
                                <td class="border p-2">{{ $item->jadwalPeriksa->jam_selesai }}</td>
                                <td class="border p-2">{{ $item->no_antrian }}</td>
                              <td class="border p-2">
                                <span class="text-white text-xs px-2 py-1 rounded {{ $item->status === 0 ? 'bg-red-500' : 'bg-green-500' }}">{{$item->status === 0 ? 'Belum diperiksa' : 'Sudah diperiksa'}}</span>
                              </td>
                              <td class="border p-2">
                                <div class="flex justify-center">
                                  <button data-modal-target="{{ $item->status === 0 ? 'detail-modal-' . $item->id : 'riwayat-modal-' . $item->id }}" 
                                    class="{{ $item->status === 0 ? 'bg-blue-500' : 'bg-green-500' }} text-white rounded px-2 py-1 text-xs">
                                    {{$item->status === 0 ? 'Detail' : 'Riwayat'}}
                                  </button>

                                  <!-- Modal Detail -->
                                  <div id="detail-modal-{{ $item->id }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                                    <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                                        <div class="flex items-center justify-between border-b pb-2 mb-4">
                                            <h3 class="text-lg font-semibold text-gray-900">Detail Pasien</h3>
                                            <button type="button" data-modal-hide="detail-modal-{{ $item->id }}" class="text-gray-500 hover:text-gray-800">&times;</button>
                                        </div>
                                        <table class="border-2 flex justify-center bg-slate-200 rounded-xl py-4">
                                          <tr>
                                            <td class="border-2 p-2">Nama Poli</td>
                                            <td class="border-2 p-2">: {{ $item->jadwalPeriksa->dokter->poli->nama_poli }}</td>
                                          </tr>
                                          <tr>
                                            <td class="border-2 p-2">Nama Dokter</td>
                                            <td class="border-2 p-2">: {{ $item->jadwalPeriksa->dokter->nama }}</td>
                                          </tr>
                                          <tr>
                                            <td class="border-2 p-2">Hari</td>
                                            <td class="border-2 p-2">: {{ $item->jadwalPeriksa->hari }}</td>
                                          </tr>
                                          <tr>
                                            <td class="border-2 p-2">Mulai</td>
                                            <td class="border-2 p-2">: {{ date('H:i', strtotime($item->jadwalPeriksa->jam_mulai)) }}</td>
                                          </tr>
                                          <tr>
                                            <td class="border-2 p-2">Selesai</td>
                                            <td class="border-2 p-2">: {{ date('H:i', strtotime($item->jadwalPeriksa->jam_selesai)) }}</td>
                                          </tr>
                                          <tr>
                                            <td class="border-2 p-2">Antrian</td>
                                            <td class="border-2 pt-3 pl-3 flex"><span class="w-9 h-9 border-4 border-solid border-green-600 bg-green-100 text-center">{{ $item->no_antrian }}</span></td>
                                          </tr>
                                        </table>
                                        <button data-modal-hide="detail-modal-{{ $item->id }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Tutup</button>
                                    </div>
                                  </div>

                                  <!-- Modal Riwayat -->
                                  <div id="riwayat-modal-{{ $item->id }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                                    <div class="bg-white rounded-lg shadow-lg w-1/2 p-6">
                                        <div class="flex items-center justify-between border-b pb-2 mb-4">
                                            <h3 class="text-lg font-semibold text-gray-900">Riwayat Pemeriksaan</h3>
                                            <button type="button" data-modal-hide="riwayat-modal-{{ $item->id }}" class="text-gray-500 hover:text-gray-800">&times;</button>
                                        </div>
                                        <table class="border-2 flex justify-center bg-slate-200 rounded-xl py-4">
                                          <tr>
                                            <td class="border-2 p-2">Nama Poli</td>
                                            <td class="border-2 p-2">: {{ $item->jadwalPeriksa->dokter->poli->nama_poli }}</td>
                                          </tr>
                                          <tr>
                                            <td class="border-2 p-2">Nama Dokter</td>
                                            <td class="border-2 p-2">: {{ $item->jadwalPeriksa->dokter->nama }}</td>
                                          </tr>
                                          <tr>
                                            <td class="border-2 p-2">Hari</td>
                                            <td class="border-2 p-2">: {{ $item->jadwalPeriksa->hari }}</td>
                                          </tr>
                                          <tr>
                                            <td class="border-2 p-2">Mulai</td>
                                            <td class="border-2 p-2">: {{ date('H:i', strtotime($item->jadwalPeriksa->jam_mulai)) }}</td>
                                          </tr>
                                          <tr>
                                            <td class="border-2 p-2">Selesai</td>
                                            <td class="border-2 p-2">: {{ date('H:i', strtotime($item->jadwalPeriksa->jam_selesai)) }}</td>
                                          </tr>
                                          <tr>
                                            <td class="border-2 p-2">Antrian</td>
                                            <td class="border-2 pt-3 pl-3 flex"><span class="w-9 h-9 border-4 border-solid border-green-600 bg-green-100 text-center">{{ $item->no_antrian }}</span></td>
                                          </tr>
                                        </table>

                                        @if ($item->periksa)
                                        <table class="border-2 mt-4">
                                            <tr>
                                                <td class="border-2 p-2">Tanggal Periksa</td>
                                                <td class="border-2 p-2">: {{ $item->periksa->tgl_periksa }}</td>
                                            </tr>
                                            <tr>
                                                <td class="border-2 p-2">Catatan</td>
                                                <td class="border-2 p-2">: {{ $item->periksa->catatan }}</td>
                                            </tr>
                                            <tr>
                                                <td class="border-2 p-2">Daftar Obat</td>
                                                <td class="border-2 p-2">
                                                    @if ($item->periksa->detailPeriksa->isNotEmpty())
                                                        @foreach ($item->periksa->detailPeriksa as $detail)
                                                            <span>{{ $detail->obat->nama_obat ?? '-' }}</span><br>
                                                        @endforeach
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-2 p-2">Biaya Periksa</td>
                                                <td class="border-2 p-2">: {{ number_format($item->periksa->biaya_periksa, 0, ',', '.') }}</td>
                                            </tr>
                                        </table>
                                        @else
                                            <p class="text-red-500 mt-4">Belum ada data pemeriksaan.</p>
                                        @endif
                                        <div class="flex">
                                        <button data-modal-hide="riwayat-modal-{{ $item->id }}" class="bg-green-500 text-white px-4 py-2 rounded mt-4 mr-5">Tutup</button>
                                        <form action="{{ route('generatePDF')}}" method="get">
                                          <button class="bg-blue-900 text-white px-4 py-2 rounded mt-4">Cetak Nota</button>
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

        document.addEventListener('DOMContentLoaded', () => {
            // Menangani pembukaan modal
            document.querySelectorAll('[data-modal-target]').forEach(button => {
                button.addEventListener('click', () => {
                    const modalId = button.getAttribute('data-modal-target');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                });
            });

            // Menangani penutupan modal
            document.querySelectorAll('[data-modal-hide]').forEach(button => {
                button.addEventListener('click', () => {
                    const modalId = button.getAttribute('data-modal-hide');
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                });
            });
        });
      </script>
</body>
</html>
