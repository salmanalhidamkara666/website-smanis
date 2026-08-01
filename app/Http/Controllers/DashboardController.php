<?php

namespace App\Http\Controllers;

use App\Models\{Absensi,Ekstrakurikuler,Izin,Jadwal,Pembina,SesiAbsensi,Siswa,User,Notifikasi};

class DashboardController extends Controller
{
    public function admin()
    {
        $grafikHadir = [
            'Senin' => Absensi::where('status','hadir')->whereRaw("DAYOFWEEK(created_at) = 2")->count(),
            'Selasa' => Absensi::where('status','hadir')->whereRaw("DAYOFWEEK(created_at) = 3")->count(),
            'Rabu' => Absensi::where('status','hadir')->whereRaw("DAYOFWEEK(created_at) = 4")->count(),
            'Kamis' => Absensi::where('status','hadir')->whereRaw("DAYOFWEEK(created_at) = 5")->count(),
            'Jumat' => Absensi::where('status','hadir')->whereRaw("DAYOFWEEK(created_at) = 6")->count(),
            'Sabtu' => Absensi::where('status','hadir')->whereRaw("DAYOFWEEK(created_at) = 7")->count(),
        ];

        return view('dashboard.admin',[
            'totalSiswa'=>Siswa::count(),
            'totalPembina'=>Pembina::count(),
            'totalEkskul'=>Ekstrakurikuler::count(),
            'hadirHariIni'=>Absensi::whereDate('created_at',today())->count(),
            'izin'=>Izin::where('jenis','izin')->count(),
            'sakit'=>Izin::where('jenis','sakit')->count(),
            'alpha'=>Absensi::where('status','alpha')->count(),
            'aktivitas'=>Notifikasi::latest()->limit(5)->get(),
            'grafikHadir'=>$grafikHadir
        ]);
    }

    public function pembina()
    {
        $p=auth_user()->pembina;

        return view('dashboard.pembina',[
            'ekskul'=>Ekstrakurikuler::where('pembina_id',$p?->id)->withCount('siswa')->get(),
            'sesi'=>SesiAbsensi::where('pembina_id',$p?->id)->latest()->limit(5)->get(),
            'pengajuan'=>Izin::latest()->limit(5)->get()
        ]);
    }

    public function siswa()
    {
        $s=auth_user()->siswa;

        return view('dashboard.siswa',[
            'siswa'=>$s,
            'jadwal'=>Jadwal::whereHas('ekstrakurikuler.siswa',fn($q)=>$q->where('siswa.id',$s?->id))->get(),
            'riwayat'=>Absensi::where('siswa_id',$s?->id)->latest()->limit(5)->get()
        ]);
    }

    public function wali()
    {
        $anak=Siswa::where('wali_user_id',auth_user()->id)->first();

        return view('dashboard.wali',[
            'anak'=>$anak,
            'riwayat'=>$anak?Absensi::where('siswa_id',$anak->id)->latest()->limit(10)->get():collect()
        ]);
    }
}