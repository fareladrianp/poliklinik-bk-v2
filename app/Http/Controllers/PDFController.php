<?php

namespace App\Http\Controllers;

use App\Models\Daftar_poli;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $idPasien = session('pasien_id');

        $riwayat = Daftar_poli::with([
            'pasien',
            'jadwalPeriksa.dokter.poli',
            'periksa'
        ])->where('id_pasien', $idPasien)->get();

        // Menggunakan view untuk menghasilkan PDF
        $pdf = Pdf::loadView('pdf_view', compact('riwayat'))->setPaper('a4', 'potrait');;

        // Menyimpan file atau langsung mengunduhnya
        return $pdf->download('contoh.pdf');
    }
}
