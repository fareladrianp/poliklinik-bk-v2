<?php

namespace App\Http\Controllers;

use App\Models\Daftar_poli;
use App\Models\Jadwal_periksa;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Periksa;
use App\Models\Poli;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasienController extends Controller
{
    public function showLoginForm()
    {
        return view('pasien.login');
    }

    public function showRegisterForm()
    {
        return view('pasien.register');
    }

    public function dashboard()
    {
        return view('pasien.dashboard');

    }

    public function submitRegister(Request $request)
    {

        $currentYearMonth = now()->format('Ym');
        $userCount = Pasien::count() + 1;
        $no_rm = $currentYearMonth . "-" . str_pad($userCount, 4, '0', STR_PAD_LEFT);

        $request->validate([
            'nama' => 'required|unique:pasien,nama|string',
        ]);

        $pasien = new Pasien();
        $pasien->nama=$request->nama;
        $pasien->alamat=$request->alamat;
        $pasien->no_ktp=$request->ktp;
        $pasien->no_hp=$request->nohp;
        $pasien->no_rm=$no_rm;
        $pasien->save();
        return redirect()->route('login.pasien');

    }

    public function submitLogin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $pasien = Pasien::where('nama', $request->nama)
            ->where('alamat', $request->alamat) // cocokkan password
            ->first();

        if ($pasien) {
            // Simpan data login di session
            session(['logged_in' => true]);
            session(['pasien_id' => $pasien->id]);
            session(['nama' => $pasien->nama]);

            return redirect()->route('dashboard.pasien');
        }

        return redirect()->back()->with('error', 'nama atau password salah');
    }

    public function logout()
    {
        Session()->flush();
        return redirect()->route('login.pasien');
    }

    public function daftarPoli()
    {
        $idPasien = session('pasien_id');

        $riwayat = Daftar_poli::with([
            'pasien',
            'jadwalPeriksa.dokter.poli',
            'periksa'
        ])->where('id_pasien', $idPasien)->get();

        $poli = Poli::where('nama_poli', '!=', 'admin')->get();

        return view('pasien.daftar', compact('poli','riwayat'));

    }

    public function tambahDaftarPoli(Request $request)
    {
        $idPasien = session('pasien_id');

        // Hitung jumlah antrian yang sudah ada untuk jadwal tertentu
        $jumlahAntrian = Daftar_poli::where('id_jadwal', $request->id_jadwal)->count();

        // Nomor antrian adalah jumlah antrian + 1
        $no_antrian = $jumlahAntrian + 1;

        $daftar = new Daftar_poli();
        $daftar->id_pasien=$idPasien;
        $daftar->id_jadwal=$request->id_jadwal;
        $daftar->keluhan=$request->keluhan;
        $daftar->no_antrian=$no_antrian;
        $daftar->save();
        return redirect()->back()->with('success','Berhasil mendaftar');

    }

    public function getJadwalByPoli($poliId)
    {
        // Ambil jadwal berdasarkan dokter yang memiliki poli terkait
        $jadwal = Jadwal_periksa::with('dokter')
            ->whereHas('dokter', function ($query) use ($poliId) {
                $query->where('id_poli', $poliId);
            })->where('status', 1)
            ->get();

        return response()->json($jadwal);
    }

    public function daftarJadwal()
    {
        $poliName = ['Poli Anak','Poli Umum','Poli Gigi'];

        $poliAnak = Jadwal_periksa::with('dokter.poli')
        ->whereHas('dokter.poli', function ($query){
            $query->where('nama_poli', 'Poli Anak');
        })
        ->get();

        $poliGigi = Jadwal_periksa::with('dokter.poli')
        ->whereHas('dokter.poli', function ($query){
            $query->where('nama_poli', 'Poli Gigi');
        })
        ->get();

        $poliUmum = Jadwal_periksa::with('dokter.poli')
        ->whereHas('dokter.poli', function ($query){
            $query->where('nama_poli', 'Poli Umum');
        })
        ->get();

        return view("pasien.daftarjadwal", compact('poliAnak','poliUmum','poliGigi'));
    }

        
}
