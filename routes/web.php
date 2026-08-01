<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,DashboardController,CrudController,AbsensiController,IzinController,LaporanController,NotifikasiController,SettingController};

Route::get('/', fn()=>redirect()->route('login'));
Route::middleware('guest')->group(function(){ Route::get('/login',[AuthController::class,'showLogin'])->name('login'); Route::post('/login',[AuthController::class,'login'])->name('login.process'); });
Route::post('/logout',[AuthController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function(){
    Route::middleware('role:admin')->get('/admin/dashboard',[DashboardController::class,'admin'])->name('admin.dashboard');
    Route::middleware('role:pembina')->get('/pembina/dashboard',[DashboardController::class,'pembina'])->name('pembina.dashboard');
    Route::middleware('role:siswa')->get('/siswa/dashboard',[DashboardController::class,'siswa'])->name('siswa.dashboard');
    Route::middleware('role:wali')->get('/wali/dashboard',[DashboardController::class,'wali'])->name('wali.dashboard');

    Route::middleware('role:admin')->group(function(){
        Route::get('/siswa',[CrudController::class,'siswaIndex'])->name('siswa.index'); Route::post('/siswa',[CrudController::class,'siswaStore'])->name('siswa.store'); Route::put('/siswa/{siswa}',[CrudController::class,'siswaUpdate'])->name('siswa.update'); Route::delete('/siswa/{siswa}',[CrudController::class,'siswaDestroy'])->name('siswa.destroy');
        Route::get('/pembina',[CrudController::class,'pembinaIndex'])->name('pembina.index'); Route::post('/pembina',[CrudController::class,'pembinaStore'])->name('pembina.store'); Route::put('/pembina/{pembina}',[CrudController::class,'pembinaUpdate'])->name('pembina.update'); Route::delete('/pembina/{pembina}',[CrudController::class,'pembinaDestroy'])->name('pembina.destroy');
        Route::get('/kelas',[CrudController::class,'kelasIndex'])->name('kelas.index'); Route::post('/kelas',[CrudController::class,'kelasStore'])->name('kelas.store'); Route::put('/kelas/{kelas}',[CrudController::class,'kelasUpdate'])->name('kelas.update'); Route::delete('/kelas/{kelas}',[CrudController::class,'kelasDestroy'])->name('kelas.destroy');
        Route::get('/ekskul',[CrudController::class,'ekskulIndex'])->name('ekskul.index'); Route::post('/ekskul',[CrudController::class,'ekskulStore'])->name('ekskul.store'); Route::put('/ekskul/{ekskul}',[CrudController::class,'ekskulUpdate'])->name('ekskul.update'); Route::delete('/ekskul/{ekskul}',[CrudController::class,'ekskulDestroy'])->name('ekskul.destroy');
        Route::get('/anggota',[CrudController::class,'anggotaIndex'])->name('anggota.index'); Route::post('/anggota',[CrudController::class,'anggotaStore'])->name('anggota.store'); Route::delete('/anggota/{anggota}',[CrudController::class,'anggotaDestroy'])->name('anggota.destroy');
        Route::get('/jadwal',[CrudController::class,'jadwalIndex'])->name('jadwal.index'); Route::post('/jadwal',[CrudController::class,'jadwalStore'])->name('jadwal.store'); Route::delete('/jadwal/{jadwal}',[CrudController::class,'jadwalDestroy'])->name('jadwal.destroy');
        Route::get('/settings',[SettingController::class,'index'])->name('settings.index'); Route::post('/settings',[SettingController::class,'update'])->name('settings.update');
    });

    Route::middleware('role:admin,pembina')->group(function(){
        Route::get('/sesi-absensi',[AbsensiController::class,'sesiIndex'])->name('sesi.index'); Route::post('/sesi-absensi',[AbsensiController::class,'sesiStore'])->name('sesi.store'); Route::post('/sesi-absensi/{sesi}/close',[AbsensiController::class,'sesiClose'])->name('sesi.close'); Route::get('/sesi-absensi/{sesi}/qr',[AbsensiController::class,'qrPage'])->name('qr.generate');
        Route::post('/izin/{izin}/status',[IzinController::class,'updateStatus'])->name('izin.status');
    });
    Route::middleware('role:siswa')->group(function(){ Route::get('/scan',[AbsensiController::class,'scanPage'])->name('qr.scan'); Route::post('/scan/validate',[AbsensiController::class,'validateScan'])->name('qr.validate'); Route::post('/izin',[IzinController::class,'store'])->name('izin.store'); });
    Route::get('/izin',[IzinController::class,'index'])->name('izin.index');
    Route::get('/laporan',[LaporanController::class,'index'])->name('laporan.index')->middleware('role:admin,pembina,wali'); Route::get('/laporan/excel',[LaporanController::class,'excel'])->name('laporan.excel')->middleware('role:admin,pembina'); Route::get('/laporan/pdf',[LaporanController::class,'pdf'])->name('laporan.pdf')->middleware('role:admin,pembina');
    Route::get('/notifikasi',[NotifikasiController::class,'index'])->name('notifikasi.index'); Route::post('/notifikasi/{notifikasi}/read',[NotifikasiController::class,'read'])->name('notifikasi.read');
});
