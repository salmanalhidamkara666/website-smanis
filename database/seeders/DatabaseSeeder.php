<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;use Illuminate\Support\Facades\Hash;use App\Models\{User,Siswa,Pembina,Kelas,Ekstrakurikuler,AnggotaEkstrakurikuler,Jadwal,SesiAbsensi,Absensi,Izin,Notifikasi,Setting};
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin=User::create(['name'=>'Admin Sekolah','username'=>'admin','email'=>'admin@sekolah.test','password'=>Hash::make('password'),'role'=>'admin','status'=>'aktif']);
        $wali=User::create(['name'=>'Wali Siswa','username'=>'wali','email'=>'wali@sekolah.test','password'=>Hash::make('password'),'role'=>'wali','status'=>'aktif']);
        $pUser=User::create(['name'=>'Pembina Utama','username'=>'pembina','email'=>'pembina@sekolah.test','password'=>Hash::make('password'),'role'=>'pembina','status'=>'aktif']);
        $pembina1=Pembina::create(['user_id'=>$pUser->id,'nip'=>'P001','nama'=>'Pembina Utama','no_hp'=>'0812000001','alamat'=>'Sekolah']);
        $pUser2=User::create(['name'=>'Pembina Seni','username'=>'pembina2','password'=>Hash::make('password'),'role'=>'pembina','status'=>'aktif']);
        $pembina2=Pembina::create(['user_id'=>$pUser2->id,'nip'=>'P002','nama'=>'Pembina Seni','no_hp'=>'0812000002','alamat'=>'Sekolah']);
        $kelas=[]; foreach([['3A','3','Umum'],['4A','4','Umum'],['5A','5','Umum']] as $k) $kelas[]=Kelas::create(['nama_kelas'=>$k[0],'tingkat'=>$k[1],'jurusan'=>$k[2]]);
        $first=null; for($i=1;$i<=10;$i++){ $u=User::create(['name'=>'Siswa '.$i,'username'=>$i==1?'siswa':'siswa'.$i,'password'=>Hash::make('password'),'role'=>'siswa','status'=>'aktif']); $s=Siswa::create(['user_id'=>$u->id,'wali_user_id'=>$i==1?$wali->id:null,'nis'=>'20260'.$i,'nama'=>'Siswa '.$i,'jenis_kelamin'=>$i%2?'L':'P','kelas_id'=>$kelas[$i%3]->id,'alamat'=>'Alamat siswa','no_hp'=>'0813'.$i,'wali_nama'=>'Wali '.$i,'wali_no_hp'=>'0822'.$i]); if(!$first) $first=$s; }
        $ek1=Ekstrakurikuler::create(['nama'=>'Pramuka','deskripsi'=>'Kegiatan kepramukaan','pembina_id'=>$pembina1->id,'lokasi'=>'Lapangan','status'=>'aktif']);
        $ek2=Ekstrakurikuler::create(['nama'=>'Futsal','deskripsi'=>'Latihan futsal','pembina_id'=>$pembina1->id,'lokasi'=>'Aula','status'=>'aktif']);
        $ek3=Ekstrakurikuler::create(['nama'=>'Seni Tari','deskripsi'=>'Latihan tari','pembina_id'=>$pembina2->id,'lokasi'=>'Ruang Seni','status'=>'aktif']);
        foreach(Siswa::all() as $s){ AnggotaEkstrakurikuler::create(['siswa_id'=>$s->id,'ekstrakurikuler_id'=>[$ek1->id,$ek2->id,$ek3->id][$s->id%3],'status'=>'aktif']); }
        $j=Jadwal::create(['ekstrakurikuler_id'=>$ek1->id,'hari'=>'Senin','jam_mulai'=>'15:00','jam_selesai'=>'17:00','lokasi'=>'Lapangan']);
        Jadwal::create(['ekstrakurikuler_id'=>$ek2->id,'hari'=>'Rabu','jam_mulai'=>'15:00','jam_selesai'=>'17:00','lokasi'=>'Aula']);
        Jadwal::create(['ekstrakurikuler_id'=>$ek3->id,'hari'=>'Jumat','jam_mulai'=>'14:00','jam_selesai'=>'16:00','lokasi'=>'Ruang Seni']);
        $sesi=SesiAbsensi::create(['ekstrakurikuler_id'=>$ek1->id,'pembina_id'=>$pembina1->id,'jadwal_id'=>$j->id,'tanggal'=>now()->toDateString(),'jam_mulai'=>'15:00','jam_selesai'=>'17:00','status'=>'aktif']);
        foreach(Siswa::whereHas('ekstrakurikuler',fn($q)=>$q->where('ekstrakurikuler.id',$ek1->id))->limit(3)->get() as $s) Absensi::create(['sesi_absensi_id'=>$sesi->id,'siswa_id'=>$s->id,'waktu_masuk'=>now(),'status'=>'hadir']);
        Izin::create(['siswa_id'=>$first->id,'sesi_absensi_id'=>$sesi->id,'jenis'=>'izin','tanggal'=>now()->toDateString(),'keterangan'=>'Keperluan keluarga','status'=>'menunggu']);
        foreach([$admin,$pUser,$wali] as $u) Notifikasi::create(['user_id'=>$u->id,'judul'=>'Selamat Datang','pesan'=>'Aplikasi E-Absensi QR siap digunakan.','tipe'=>'info']);
        foreach(['nama_sekolah'=>'Sekolah Contoh','tahun_ajaran'=>'2026/2027','semester'=>'Ganjil','toleransi_terlambat'=>'10','durasi_qr'=>'10'] as $k=>$v) Setting::create(['key'=>$k,'value'=>$v]);
    }
}
