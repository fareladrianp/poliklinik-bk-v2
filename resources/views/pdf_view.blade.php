<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        <h1>Nota Periksa</h1>

        @foreach ($riwayat as $item)
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
        <br>
        @else
            <p class="text-red-500 mt-4">Belum ada data pemeriksaan.</p>
        @endif
                
        @endforeach
</body>
</html>