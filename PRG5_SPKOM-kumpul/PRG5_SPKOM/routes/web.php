<?php

    use App\Http\Controllers\exportController;


    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\authController;
    use App\Http\Controllers\homeController;
    use App\Http\Controllers\admin\adminController;
    use App\Http\Controllers\admin\divisiController;
    use App\Http\Controllers\admin\jabatanController;
    use App\Http\Controllers\pengurus\pengurusController;
    use App\Http\Controllers\admin\organisasiController;
    use App\Http\Controllers\admin\pertanyaanController;
    use App\Http\Controllers\pengurus\quisionerController;
    use App\Http\Controllers\admin\dashboardController;

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

    Route::group(['middleware' => 'guest'], function () {
        Route::get('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
        
    });

    //Admin Routes List
    Route::middleware(['auth', 'user-access:Admin'])->group(function () {
      Route::get('/admin/home', [dashboardController::class, 'adminDashboard'])->name('admin.home');
      Route::get('/admin/profile', [adminController::class, 'profile'])->name('admin.profile');
      //organisasi
      Route::get('/admin/organisasi-table', [organisasiController::class, 'index'])->name('organisasi.index');
      Route::post('/admin/organisasi/store', [organisasiController::class, 'store'])->name('organisasi.store');
      Route::post('/admin/organisasi/edit', [organisasiController::class, 'edit'])->name('organisasi.edit');
      Route::post('/admin/organisasi/delete', [organisasiController::class, 'destroy'])->name('organisasi.destroy');
      //divisi
      Route::get('/admin/divisi-table', [divisiController::class, 'index'])->name('divisi.index');
      Route::post('/admin/divisi/store', [divisiController::class, 'store'])->name('divisi.store');
      Route::post('/admin/divisi/edit', [divisiController::class, 'edit'])->name('divisi.edit');
      Route::post('/admin/divisi/delete', [divisiController::class, 'destroy'])->name('divisi.destroy');
      //divisi
      Route::get('/admin/jabatan-table', [jabatanController::class, 'index'])->name('jabatan.index');
      Route::post('/admin/jabatan/store', [jabatanController::class, 'store'])->name('jabatan.store');
      Route::post('/admin/jabatan/edit', [jabatanController::class, 'edit'])->name('jabatan.edit');
      Route::post('/admin/jabatan/delete', [jabatanController::class, 'destroy'])->name('jabatan.destroy');
      //admin
      Route::get('/admin/admin-table', [adminController::class, 'index'])->name('admin.index');
      Route::post('/admin/admin/store', [adminController::class, 'store'])->name('admin.store');
      Route::post('/admin/admin/edit', [adminController::class, 'edit'])->name('admin.edit');
      Route::post('/admin/admin/delete', [adminController::class, 'destroy'])->name('admin.destroy');
      Route::get('/admin/verifPengurus-table', [adminController::class, 'verifPengurus'])->name('admin.verifPengurus');
      Route::get('verifikasi-pengurus/{nomor_induk}', [AdminController::class, 'acc'])->name('verifikasi.pengurus');
      
      //pertanyaan
      Route::get('/admin/pertanyaan-table', [pertanyaanController::class, 'index'])->name('pertanyaan.index');
      Route::post('/admin/pertanyaan/store', [pertanyaanController::class, 'store'])->name('pertanyaan.store');
      Route::post('/admin/pertanyaan/edit', [pertanyaanController::class, 'edit'])->name('pertanyaan.edit');
      Route::post('/admin/pertanyaan/delete', [pertanyaanController::class, 'destroy'])->name('admin.destroy'); 

      Route::get('/admin/dataPengurus-table', [adminController::class, 'dataPengurus'])->name('dataPengurus');
      Route::get('/admin/performancePengurus/{nomor_induk}', [adminController::class, 'performancePengurus'])->name('performancePengurus');
      Route::get('/admin/nonperformancePengurus/{nomor_induk}', [adminController::class, 'nonperformancePengurus'])->name('nonperformancePengurus');

      Route::get('/export/nomor_induk/{nomor_induk}', [exportController::class, 'exportByNomorInduk'])->name('exportByNomorInduk');
      Route::get('/export/organisasi/{organisasi}', [exportController::class, 'exportByOrganisasi'])->name('exportByOrganisasi');
      Route::get('/export/divisi/{divisi}', [exportController::class, 'exportByDivisi'])->name('exportByDivisi');


    });
    
      //Admin Routes List
    Route::middleware(['auth', 'user-access:Pengurus'])->group(function () {
      Route::get('/pengurus/home', [homeController::class, 'pengurusDashboard'])->name('pengurus.home');
      Route::get('/pengurus/quizPerformance', [quisionerController::class, 'indexPerformance'])->name('quizPerformance');
      Route::post('/proses_penilaian', [QuisionerController::class, 'prosesPenilaian'])->name('proses_penilaian');
      Route::post('/proses_penilaian_nonperformance', [QuisionerController::class, 'prosesPenilaianNonperformance'])->name('proses_penilaian_nonperformance');
      Route::get('/pengurus/quizNonPerformance', [quisionerController::class, 'indexNonPerformance'])->name('quizNonPerformance');
      Route::get('/pengurus/quizPerformance/index/{nomor_induk}', [quisionerController::class, 'pertanyaanQuisioner'])->name('pengurus.quizPerformance.index');
    });
      
      Route::get('/get-divisi/{organisasiId}', [AuthController::class, 'getDivisi']);
      Route::get('/get-jabatan/{divisiId}', [AuthController::class, 'getJabatan']);
      Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

      Route::get('/', function () {
        // Cek apakah pengguna sudah diotentikasi
        if (Auth::check()) {
            // Pengguna sudah diotentikasi, arahkan ke halaman beranda yang sesuai dengan perannya
            if (Auth::user()->role == 'Admin') {
                return redirect()->route('admin.home');
            } elseif (Auth::user()->role == 'Pengurus') {
                return redirect()->route('pengurus.home');
            }
            // Tambahkan kondisi peran lain jika diperlukan
        }
    
        // Jika pengguna belum diotentikasi, arahkan ke halaman login
        return redirect()->route('login');
    });
    