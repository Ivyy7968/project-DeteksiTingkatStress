<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

// ── Landing ──────────────────────────────────────────────────────
Route::get('/', [AuthController::class, 'landing'])->name('landing');

// ── Default login ─────────────────────
Route::get('/login', [AuthController::class, 'showLoginSiswa'])->name('login');

// ── Siswa Auth ───────────────────────────────────────────────────
Route::get('/login-siswa',  [AuthController::class, 'showLoginSiswa'])->name('login.siswa');
Route::post('/login-siswa', [AuthController::class, 'loginSiswa']);
Route::get('/register',     [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',    [AuthController::class, 'register']);

// ── Admin Auth ───────────────────────────────────────────────────
Route::get('/admin/login',  [AuthController::class, 'showLoginAdmin'])->name('login.admin');
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);

// ── Logout ───────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Siswa Area ───────────────────────────────────────────────────
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard',         [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/diagnosa',          [SiswaController::class, 'startDiagnosa'])->name('diagnosa');
    Route::post('/diagnosa',         [SiswaController::class, 'submitDiagnosa'])->name('diagnosa.submit');
    Route::get('/hasil/{id}',        [SiswaController::class, 'hasil'])->name('hasil');
    Route::get('/hasil/{id}/cetak',  [SiswaController::class, 'cetakHasil'])->name('hasil.cetak');
    Route::get('/riwayat',           [SiswaController::class, 'riwayat'])->name('riwayat');
});

// ── Admin Area ───────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Data Siswa (CRUD)
    Route::get('/siswa',                [AdminController::class, 'indexSiswa'])->name('siswa.index');
    Route::get('/siswa/create',         [AdminController::class, 'createSiswa'])->name('siswa.create');
    Route::post('/siswa',               [AdminController::class, 'storeSiswa'])->name('siswa.store');
    Route::get('/siswa/cetak-semua',    [AdminController::class, 'cetakSemuaSiswa'])->name('siswa.cetak');
    Route::get('/siswa/{id}',           [AdminController::class, 'showSiswa'])->name('siswa.show');
    Route::get('/siswa/{id}/edit',      [AdminController::class, 'editSiswa'])->name('siswa.edit');
    Route::put('/siswa/{id}',           [AdminController::class, 'updateSiswa'])->name('siswa.update');
    Route::delete('/siswa/{id}',        [AdminController::class, 'destroySiswa'])->name('siswa.destroy');
    Route::get('/diagnosa/{id}/cetak',  [AdminController::class, 'cetakDiagnosa'])->name('diagnosa.cetak');

    // Data Gejala (CRUD)
    Route::get('/gejala',           [GejalaController::class, 'index'])->name('gejala.index');
    Route::get('/gejala/create',    [GejalaController::class, 'create'])->name('gejala.create');
    Route::post('/gejala',          [GejalaController::class, 'store'])->name('gejala.store');
    Route::get('/gejala/{id}/edit', [GejalaController::class, 'edit'])->name('gejala.edit');
    Route::put('/gejala/{id}',      [GejalaController::class, 'update'])->name('gejala.update');
    Route::delete('/gejala/{id}',   [GejalaController::class, 'destroy'])->name('gejala.destroy');

    // Data Aturan / Rules (CRUD)
    Route::get('/aturan',           [RuleController::class, 'index'])->name('rules.index');
    Route::get('/aturan/create',    [RuleController::class, 'create'])->name('rules.create');
    Route::post('/aturan',          [RuleController::class, 'store'])->name('rules.store');
    Route::get('/aturan/{id}/edit', [RuleController::class, 'edit'])->name('rules.edit');
    Route::put('/aturan/{id}',      [RuleController::class, 'update'])->name('rules.update');
    Route::delete('/aturan/{id}',   [RuleController::class, 'destroy'])->name('rules.destroy');

    // Laporan (read-only + cetak)
    Route::get('/laporan',                 [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak/siswa',     [LaporanController::class, 'cetakSiswa'])->name('laporan.cetak.siswa');
    Route::get('/laporan/cetak/riwayat',   [LaporanController::class, 'cetakRiwayat'])->name('laporan.cetak.riwayat');
    Route::get('/laporan/cetak/gejala',    [LaporanController::class, 'cetakGejala'])->name('laporan.cetak.gejala');
    Route::get('/laporan/cetak/output',    [LaporanController::class, 'cetakOutput'])->name('laporan.cetak.output');
    Route::get('/laporan/cetak/aturan',    [LaporanController::class, 'cetakAturan'])->name('laporan.cetak.aturan');
});