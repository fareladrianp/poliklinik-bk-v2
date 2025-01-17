<?php

namespace App\Http\Controllers;

use App\Models\Daftar_poli;
use App\Models\Detail_periksa;
use App\Models\Dokter;
use App\Models\Jadwal_periksa;
use App\Models\Obat;
use App\Models\Periksa;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DokterController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function submitLogin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
        ]);
    
        // Cek apakah nama adalah 'admin' dan alamat cocok
        if ($request->nama === 'admin') {
            $admin = Dokter::where('nama', 'admin')
                ->where('alamat', $request->alamat)
                ->first();
    
            if ($admin) {
                // Login sebagai admin
                session(['logged_in' => true]);
                session(['role' => 'admin']);
                session(['nama' => 'admin']);
    
                return redirect()->route('dashboard.admin');
            }
        } else {
            // Login sebagai dokter (selain admin)
            $dokter = Dokter::where('nama', $request->nama)
                ->where('alamat', $request->alamat)
                ->first();
    
            if ($dokter) {
                // Simpan data login di session
                session(['logged_in' => true]);
                session(['role' => 'dokter']);
                session(['dokter_id' => $dokter->id]);
                session(['nama' => $dokter->nama]);
    
                return redirect()->route('dashboard.dokter');
            }
        }
    
        // Jika login gagal
        return redirect()->back()->with('error', 'Nama atau alamat salah');
        
    }

    public function logout()
    {
        Session()->flush();
        return redirect()->route('login');
    }

    public function dashboardDokter()
    {
        return view('dokter.dashboard');
    }

    public function profilDokter()
    {
        // Ambil ID dokter dari session
        $dokterId = session('dokter_id');

        // Ambil data dokter dari database
        $dokter = Dokter::with('poli')->find($dokterId);
        $poli = Poli::get();

        if (!$dokter) {
            return redirect()->route('login')->withErrors(['error' => 'Harap login terlebih dahulu.']);
        }

        return view('dokter.profile', compact('dokter','poli'));
    }

    public function updateDokter(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'nohp' => 'required',
            'id_poli' => 'required'
        ]);

        try {

            $dokter = Dokter::find($id);
            $dokter->nama=$request->nama;
            $dokter->alamat=$request->alamat;
            $dokter->no_hp=$request->nohp;
            $dokter->id_poli = $request->id_poli;
            $dokter->update();

            return redirect()->back()->with('success', 'Data Dokter berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data Dokter gagal diperbarui.');
        }
    }

    public function tambahJadwal(Request $request)
    {
        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ]);

        $dokterId = session('dokter_id');

        try {

            $ifExists = Jadwal_periksa::where('id_dokter',$dokterId)->where('hari',$request->hari)->exists();

        if($ifExists){
            return redirect()->back()->with('error', 'Sudah memiliki Jadwal pada hari '. $request->hari);
        }

            $jadwal = new Jadwal_periksa();
            $jadwal->id_dokter=$dokterId;
            $jadwal->hari=$request->hari;
            $jadwal->jam_mulai=$request->jam_mulai;
            $jadwal->jam_selesai=$request->jam_selesai;
            $jadwal->save();

            return redirect()->back()->with('success', 'Data Jadwal berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data Jadwal gagal ditambahkan.');
        }
    }

    public function jadwalDokter()
    {
        $dokterId = session('dokter_id');
        $jadwal = Jadwal_periksa::where('id_dokter', $dokterId)->get();

        return view('dokter.jadwal', compact('jadwal'));
    }

    public function updateJadwal(Request $request, $id)
    {

        $request->validate([
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required'
        ]);
        try {
            $dokterId = session('dokter_id');
            $jadwal = Jadwal_periksa::find($id);
            $jadwal->id_dokter=$dokterId;
            $jadwal->hari=$request->hari;
            $jadwal->jam_mulai=$request->jam_mulai;
            $jadwal->jam_selesai=$request->jam_selesai;
            $jadwal->update();

            return redirect()->back()->with('success','Data Jadwal berhasil diperbarui');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error','Data Jadwal gagal diperbarui');
        }

        
    }

    public function updateStatus(Request $request, $id)
    {
        $jadwal = Jadwal_periksa::findOrFail($id);
        $jadwal->status = $request->status;
        $jadwal->save();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui']);
    }

    public function updateStatusJ(Request $request, $id)
    {
        $daftarPoli = Daftar_poli::findOrFail($id);
        $daftarPoli->status = 1; // Ubah status menjadi 1
        $daftarPoli->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function periksa()
    {
        $idDokter = session('dokter_id');

        $daftar = Daftar_poli::with(['pasien', 'jadwalPeriksa'])
        ->whereHas('jadwalPeriksa', function ($query) use ($idDokter) {
            $query->where('id_dokter', $idDokter);
        })
        ->get();

        $obat = Obat::get();

        return view('dokter.periksa', compact('daftar','obat'));
    }

    public function riwayat()
    {
        $idDokter = session('dokter_id');

        $daftar = Daftar_poli::with(['pasien', 'jadwalPeriksa.dokter'])
        ->whereHas('jadwalPeriksa', function ($query) use ($idDokter) {
            $query->where('id_dokter', $idDokter);
        })->where('status', 1)
        ->get();

        $obat = Obat::get();

        return view('dokter.riwayat', compact('daftar','obat'));
    }

    public function tambahPeriksa(Request $request,$id)
    {
        // Menemukan data pendaftaran poli
        $daftarPoli = Daftar_poli::findOrFail($id);

        // Membuat entri baru di tabel Periksa
        $periksa = new Periksa();
        $periksa->id_daftar_poli = $daftarPoli->id;
        $periksa->tgl_periksa = $request->tgl_periksa;
        $periksa->catatan = $request->catatan;
        $periksa->biaya_periksa = $request->harga_total;  // Total biaya
        $periksa->save();

        // Menyimpan data obat yang dipilih
        if ($request->has('obat')) {
            foreach ($request->obat as $obat_id) {
                $obat = Obat::findOrFail($obat_id);

                // Membuat entri baru di tabel PeriksaObat
                $periksaObat = new Detail_periksa();
                $periksaObat->id_periksa = $periksa->id;
                $periksaObat->id_obat = $obat->id;
                $periksaObat->save();
            }
        }

        // Mengupdate status pada tabel Daftar_poli menjadi 1
        $daftarPoli->status = 1;  // Pastikan kolom 'status' adalah integer
        $daftarPoli->save();

        // Mengalihkan kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Pemeriksaan berhasil ditambahkan.');
        }
}
