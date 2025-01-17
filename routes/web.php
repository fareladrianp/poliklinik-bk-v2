<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PDFController;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('index');

//register pasien
Route::get('/register/pasien', [PasienController::class, 'showRegisterForm'])->name('register.pasien');
Route::post('/register/submit', [PasienController::class, 'submitRegister'])->name('register.pasien.submit');
//login pasien
Route::get('/login/pasien', [PasienController::class, 'showLoginForm'])->name('login.pasien');
Route::post('/login/submit', [PasienController::class, 'submitLogin'])->name('login.pasien.submit');
//logout pasien
Route::get('/logout/pasien', [PasienController::class, 'logout'])->name('logout.pasien');
//route pasien
Route::get('/dashboard/pasien', [PasienController::class, 'dashboard'])->name('dashboard.pasien')->middleware('checklogin.pasien');
Route::get('/dashboard/pasien/daftar', [PasienController::class, 'daftarPoli'])->name('daftar.poli.pasien')->middleware('checklogin.pasien');
Route::get('/get-jadwal-by-poli/{poli}', [PasienController::class, 'getJadwalByPoli']);
Route::post('/dashboard/pasien/daftarpoli', [PasienController::class, 'tambahDaftarPoli'])->name('tambah.poli.pasien')->middleware('checklogin.pasien');
Route::get('/dashboard/pasien/daftarjadwal', [PasienController::class, 'daftarJadwal'])->name('daftar.jadwal.pasien')->middleware('checklogin.pasien');



//login admin.dokter
Route::get('/login', [DokterController::class, 'showLogin'])->name('login');
Route::post('/login', [DokterController::class, 'submitLogin'])->name('login.submit');
//logout admin.dokter
Route::get('/logout', [DokterController::class, 'logout'])->name('logout.dokter');

//route dokter
Route::get('/dashboard/dokter', [DokterController::class, 'dashboardDokter'])->name('dashboard.dokter')->middleware('checklogin.dokter');
Route::get('/dashboard/dokter/profile', [DokterController::class, 'profilDokter'])->name('profil.dokter')->middleware('checklogin.dokter');
Route::post('/dashboard/dokter/profile/{id}', [DokterController::class, 'updateDokter'])->name('profil.update.dokter');
Route::get('/dashboard/dokter/jadwal', [DokterController::class, 'jadwalDokter'])->name('jadwal.dokter')->middleware('checklogin.dokter');
Route::post('/dashboard/dokter/jadwal/tambah', [DokterController::class, 'tambahJadwal'])->name('tambah.jadwal');
Route::post('/jadwal/{id}/update-status', [DokterController::class, 'updateStatus'])->middleware('checklogin.dokter');
Route::put('/update-status/{id}', [DokterController::class, 'updateStatusJ'])->name('update-status');
Route::post('/dashboard/dokter/jadwal/update/{id}', [DokterController::class, 'updateJadwal'])->name('update.jadwal');
Route::get('/dashboard/dokter/periksa', [DokterController::class, 'periksa'])->name('periksa.dokter')->middleware('checklogin.dokter');
Route::post('/dashboard/dokter/periksa/{id}', [DokterController::class, 'tambahPeriksa'])->name('tambah.periksa.dokter')->middleware('checklogin.dokter');
Route::get('/dashboard/dokter/riwayat', [DokterController::class, 'riwayat'])->name('riwayat.dokter')->middleware('checklogin.dokter');

//route admin
Route::get('/dashboard/admin', [AdminController::class, 'dashboardAdmin'])->name('dashboard.admin')->middleware('checklogin.dokter');
Route::get('/dashboard/admin/dokter', [AdminController::class, 'kelolaDokter'])->name('kelola.dokter')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/dokter/tambah', [AdminController::class, 'tambahDokter'])->name('tambah.dokter')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/dokter/update/{id}', [AdminController::class, 'updateDokter'])->name('update.dokter')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/dokter/delete/{id}', [AdminController::class, 'hapusDokter'])->name('delete.dokter')->middleware('checklogin.dokter');
Route::get('/dashboard/admin/pasien', [AdminController::class, 'kelolaPasien'])->name('kelola.pasien')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/pasien/tambah', [AdminController::class,'tambahPasien'])->name('tambah.pasien')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/pasien/update/{id}', [AdminController::class,'updatePasien'])->name('update.pasien')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/pasien/delete/{id}', [AdminController::class,'hapusPasien'])->name('delete.pasien')->middleware('checklogin.dokter');
Route::get('/dashboard/admin/poli', [AdminController::class, 'kelolaPoli'])->name('kelola.poli')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/poli/tambah', [AdminController::class, 'tambahPoli'])->name('tambah.poli')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/poli/update/{id}', [AdminController::class, 'updatePoli'])->name('update.poli')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/poli/delete/{id}', [AdminController::class, 'hapusPoli'])->name('delete.poli')->middleware('checklogin.dokter');
Route::get('/dashboard/admin/obat', [AdminController::class, 'kelolaObat'])->name('kelola.obat')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/obat/tambah', [AdminController::class, 'tambahObat'])->name('tambah.obat')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/obat/update/{id}', [AdminController::class, 'updateObat'])->name('update.obat')->middleware('checklogin.dokter');
Route::post('/dashboard/admin/obat/delete/{id}', [AdminController::class, 'hapusObat'])->name('delete.obat')->middleware('checklogin.dokter');

//route PDF
Route::get('/generatePdf',[PDFController::class, 'generatePDF'])->name('generatePDF');




Route::get('/check-login', function (Request $request) {
    // Cek apakah user sudah login atau belum
    if ($request->session()->has('logged_in')) {
        return response()->json([
            'logged_in' => true,
            'pasien_id' => $request->session()->get('pasien_id'),
            'dokter_id' => $request->session()->get('dokter_id'),
            'nama' => $request->session()->get('nama'),
        ]);
    }

    return response()->json(['logged_in' => false]);
});

// Route::post('register', [AuthController::class, 'register']);

// Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('login', [AuthController::class, 'login']);

// Route::get('logout', [AuthController::class, 'logout'])->name('logout');


