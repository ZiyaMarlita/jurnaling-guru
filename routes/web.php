<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GuruProfileController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\KepsekController;

/*
|--------------------------------------------------------------------------
| CATATAN PENTING
| Pastikan RoleMiddleware sudah didaftarkan di bootstrap/app.php:
|
| ->withMiddleware(function (Middleware $middleware) {
|     $middleware->alias([
|         'role' => \App\Http\Middleware\RoleMiddleware::class,
|     ]);
| })
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| ROOT — redirect sesuai role
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (!Auth::check()) {
        return redirect()->route('login');
    }

    return match (Auth::user()->role) {
        'guru'   => redirect()->route('guru.dashboard'),
        'kepsek' => redirect()->route('kepsek.dashboard'),
        default  => abort(403),
    };

});


/*
|--------------------------------------------------------------------------
| AUTH — hanya bisa diakses jika belum login (guest)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::controller(AuthController::class)->group(function () {

        Route::get('/login',    'showLogin')->name('login');
        Route::post('/login',   'loginProcess')->name('login.process');

        Route::get('/register', 'showRegister')->name('register');
        Route::post('/register','register')->name('register.process');

    });

});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| AREA SETELAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |----------------------------------------------------------------------
    | AREA GURU
    |----------------------------------------------------------------------
    */

    Route::middleware('role:guru')
        ->prefix('guru')
        ->name('guru.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [GuruController::class, 'dashboard'])
                ->name('dashboard');

            // Profil
            Route::controller(GuruProfileController::class)
                ->prefix('profil')
                ->name('profil.')
                ->group(function () {
                    Route::get('/',  'index')->name('index');
                    Route::put('/',  'updateProfil')->name('update');
                });

            // Jurnal — resource route (index, create, store, show, edit, update, destroy)
            Route::resource('jurnal', JurnalController::class)
                ->whereNumber('jurnal');

        });


    /*
    |----------------------------------------------------------------------
    | AREA KEPALA SEKOLAH
    |----------------------------------------------------------------------
    */

    Route::middleware('role:kepsek')
        ->prefix('kepsek')
        ->name('kepsek.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [KepsekController::class, 'dashboard'])
                ->name('dashboard');

            // Jurnal Guru
            Route::prefix('jurnal')->name('jurnal.')->group(function () {
                Route::get('/',                [KepsekController::class, 'index'])   ->name('index');
                Route::get('/{id}',            [KepsekController::class, 'show'])    ->whereNumber('id')->name('show');
                Route::post('/{id}/evaluasi',  [KepsekController::class, 'evaluasi'])->whereNumber('id')->name('evaluasi');
            });

            // Data Guru
            Route::prefix('guru')->name('guru.')->group(function () {
                Route::get('/',      [KepsekController::class, 'guru'])    ->name('index');
                Route::get('/{id}',  [KepsekController::class, 'guruShow'])->whereNumber('id')->name('show');
            });

            // Evaluasi
            Route::get('/evaluasi', [KepsekController::class, 'evaluasiIndex'])
                ->name('evaluasi.index');

            // Laporan
            Route::get('/laporan', [KepsekController::class, 'laporan'])
                ->name('laporan.index');

            // Pengaturan Akun
            Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
                Route::get('/',  [KepsekController::class, 'pengaturan'])      ->name('index');
                Route::put('/',  [KepsekController::class, 'updatePengaturan'])->name('update');
            });

        });

});


/*
|--------------------------------------------------------------------------
| FALLBACK — halaman tidak ditemukan
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    abort(404);
});