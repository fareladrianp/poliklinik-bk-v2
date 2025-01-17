<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboardAdmin()
    {
        $jumlahPasien = Pasien::count();
        $jumlahDokter = Dokter::count();
        $jumlahPoli = Poli::count();
        $jumlahObat = Obat::count();

        return view('admin.dashboard', compact('jumlahPasien','jumlahDokter','jumlahPoli','jumlahObat'));
    }

    public function kelolaDokter()
    {
        $dokter = Dokter::with('poli')->where('nama', '!=', 'admin')->get();
        $poli = Poli::where('nama_poli', '!=', 'admin')->get();

        return view('admin.kelolaDokter', compact('dokter','poli'));
    }

    public function tambahDokter(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'nohp' => 'required',
            'id_poli' => 'required'
        ]);

        try {

            $dokter = new Dokter();
            $dokter->nama=$request->nama;
            $dokter->alamat=$request->alamat;
            $dokter->no_hp=$request->nohp;
            $dokter->id_poli = $request->id_poli;
            $dokter->save();

            return redirect()->back()->with('success', 'Data Dokter berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data Dokter gagal ditambahkan.');
        }
        
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

    public function hapusDokter( $id)
    {

        try {
            $dokter = Dokter::find($id);
            $dokter->delete();

            return redirect()->back()->with('success', 'Data Dokter berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data Dokter.');
        }
        
    }

    public function kelolaPasien()
    {
        $pasien = Pasien::get();

        return view('admin.kelolaPasien', compact('pasien'));
    }

    public function tambahPasien(Request $request)
    {
        $request->validate([
            'nama'=>'required|string',
            'alamat'=>'required|string',
            'no_ktp'=>'required',
            'nohp'=>'required',
        ]);

        $currentYearMonth = now()->format('Ym');
        $userCount = Pasien::count() + 1;
        $no_rm = $currentYearMonth . "-" . str_pad($userCount, 4, '0', STR_PAD_LEFT);


        try {

            $pasien = new Pasien();
            $pasien->nama=$request->nama;
            $pasien->alamat=$request->alamat;
            $pasien->no_ktp=$request->no_ktp;
            $pasien->no_hp=$request->nohp;
            $pasien->no_rm=$no_rm;
            $pasien->save();

            return redirect()->back()->with('success', 'Data Pasien berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data Pasien gagal ditambahkan.');
        }
        
    }

    public function updatePasien(Request $request, $id)
    {
        $request->validate([
            'nama'=>'required|string',
            'alamat'=>'required|string',
            'no_ktp'=>'required',
            'nohp'=>'required',
        ]);

        try {

            $pasien = Pasien::find($id);
            $pasien->nama=$request->nama;
            $pasien->alamat=$request->alamat;
            $pasien->no_ktp=$request->no_ktp;
            $pasien->no_hp=$request->nohp;
            $pasien->update();

            return redirect()->back()->with('success', 'Data Pasien berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data Pasien gagal diperbarui.');
        }
        
    }

    public function hapusPasien($id)
    {

        try {

            $pasien = Pasien::find($id);
            $pasien->delete();

            return redirect()->back()->with('success', 'Data Pasien berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data Pasien.');
        }
        
    }

    public function kelolaPoli()
    {
        $poli = Poli::where('nama_poli', '!=', 'admin')->get();

        return view('admin.kelolaPoli', compact('poli'));
    }

    public function tambahPoli(Request $request)
    {
        $request->validate([
            'nama_poli' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try {

            $poli = new Poli();
            $poli->nama_poli=$request->nama_poli;
            $poli->keterangan=$request->keterangan;
            $poli->save();

            return redirect()->back()->with('success', 'Data Poli berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data Poli gagal Ditambahkan.');
        }
        
    }

    public function updatePoli(Request $request, $id)
    {
        $request->validate([
            'nama_poli' => 'required|string',
            'keterangan' => 'required|string',
        ]);

        try {
            $poli = Poli::find($id);
            $poli->nama_poli=$request->nama_poli;
            $poli->keterangan=$request->keterangan;
            $poli->update();

            return redirect()->back()->with('success', 'Data Poli berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data Poli gagal diperbarui.');
        }
    }

    public function hapusPoli($id)
    {
        try {
            $poli = Poli::find($id);
            $poli->delete();

            return redirect()->back()->with('success', 'Data Poli berhasil dihapus.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data Poli.');
        }

    }

    public function tambahObat(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string',
            'kemasan' => 'required|string',
            'harga' => 'required|string',
        ]);

        $harga = str_replace('.', '', $request->harga);

        try {
            $obat = new Obat();
            $obat->nama_obat=$request->nama_obat;
            $obat->kemasan=$request->kemasan;
            $obat->harga=$harga;
            $obat->save();

            return redirect()->back()->with('success', 'Data Obat berhasil ditambahkan.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data Obat gagal ditambahkan.');
        }
        

    }

    public function kelolaObat()
    {
        // Mengambil semua data obat
        $obat = Obat::get();

        // Mengirim data ke view
        return view('admin.kelolaObat', compact('obat'));
    }

    public function updateObat(Request $request, $id)
    {
        try {

            $obat = Obat::find($id);
            $obat->nama_obat=$request->nama_obat;
            $obat->kemasan=$request->kemasan;
            $obat->harga=$request->harga;
            $obat->update();

            return redirect()->back()->with('success', 'Data Obat berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Data Obat gagal diperbarui.');
        }
    }

    public function hapusObat($id)
    {
        try {

            $obat = Obat::find($id);
            $obat->delete();

            return redirect()->back()->with('success', 'Data Obat berhasil dihapus.');

        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data Obat.');
        }
    }

}
