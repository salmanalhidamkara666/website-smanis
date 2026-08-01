<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;use Illuminate\Support\Str;use Illuminate\Support\Facades\DB;use App\Models\{Absensi,Ekstrakurikuler,Izin,Jadwal,Notifikasi,Pembina,QrAbsensi,SesiAbsensi,Siswa};
class AbsensiController extends Controller
{
    public function sesiIndex(){ $items=SesiAbsensi::with(['ekstrakurikuler','pembina'])->latest()->paginate(10); return view('absensi.sesi.index',compact('items')); }
    public function sesiStore(Request $r){ $d=$r->validate(['ekstrakurikuler_id'=>'required','pembina_id'=>'required','jadwal_id'=>'nullable','tanggal'=>'required|date','jam_mulai'=>'required','jam_selesai'=>'required','status'=>'required']); SesiAbsensi::create($d); return back()->with('success','Sesi absensi dibuat.'); }
    public function sesiClose(SesiAbsensi $sesi){ $sesi->update(['status'=>'selesai']); return back()->with('success','Sesi ditutup.'); }
    public function qrPage(SesiAbsensi $sesi){ $qrMasuk=$this->makeQr($sesi,'masuk'); $qrKeluar=$this->makeQr($sesi,'keluar'); return view('absensi.qr.generate',compact('sesi','qrMasuk','qrKeluar')); }
    private function makeQr(SesiAbsensi $sesi,string $jenis){ $minutes=(int)(\App\Models\Setting::where('key','durasi_qr')->value('value') ?? 10); return QrAbsensi::create(['sesi_absensi_id'=>$sesi->id,'token'=>Str::random(80),'jenis_absensi'=>$jenis,'expired_at'=>now()->addMinutes($minutes),'status'=>'aktif']); }
    public function scanPage(){ return view('absensi.qr.scan'); }
    public function validateScan(Request $r){
        $r->validate(['token'=>'required|string']); $qr=QrAbsensi::where('token',$r->token)->with('sesi.ekstrakurikuler')->first();
        if(!$qr || $qr->status!=='aktif') return response()->json(['ok'=>false,'message'=>'QR Code tidak valid.'],422);
        if(now()->greaterThan($qr->expired_at)) return response()->json(['ok'=>false,'message'=>'QR Code sudah kedaluwarsa.'],422);
        $sesi=$qr->sesi; if(!$sesi || $sesi->status!=='aktif') return response()->json(['ok'=>false,'message'=>'Sesi sudah berakhir atau belum aktif.'],422);
        $siswa=auth_user()->siswa; if(!$siswa) return response()->json(['ok'=>false,'message'=>'Akun ini bukan siswa.'],403);
        $terdaftar=$siswa->ekstrakurikuler()->where('ekstrakurikuler.id',$sesi->ekstrakurikuler_id)->wherePivot('status','aktif')->exists();
        if(!$terdaftar) return response()->json(['ok'=>false,'message'=>'Siswa tidak terdaftar di ekstrakurikuler ini.'],422);
        $abs=Absensi::firstOrNew(['sesi_absensi_id'=>$sesi->id,'siswa_id'=>$siswa->id]);
        if($qr->jenis_absensi==='masuk' && $abs->exists && $abs->waktu_masuk) return response()->json(['ok'=>false,'message'=>'Siswa sudah absen masuk.'],422);
        if($qr->jenis_absensi==='keluar' && (!$abs->exists || !$abs->waktu_masuk)) return response()->json(['ok'=>false,'message'=>'Siswa belum absen masuk.'],422);
        $status='hadir'; if($qr->jenis_absensi==='masuk'){$graceMinutes=(int)(\App\Models\Setting::where('key','toleransi_terlambat')->value('value') ?? 0);$jamMulai=\Carbon\Carbon::parse('2000-01-01 '.$sesi->jam_mulai)->addMinutes($graceMinutes);$jamSekarang=\Carbon\Carbon::parse('2000-01-01 '.now()->format('H:i:s'));if($jamSekarang->isAfter($jamMulai))$status='terlambat';}
        if($qr->jenis_absensi==='masuk'){ $abs->waktu_masuk=now(); $abs->status=$status; } else { $abs->waktu_keluar=now(); }
        $abs->qr_absensi_id=$qr->id; $abs->user_agent=substr($r->userAgent(),0,250); $abs->ip_address=$r->ip(); $abs->save();
        if($siswa->wali_user_id){ Notifikasi::create(['user_id'=>$siswa->wali_user_id,'judul'=>'Absensi Anak','pesan'=>$siswa->nama.' berhasil absen '.$qr->jenis_absensi.'.','tipe'=>'absensi']); }
        return response()->json(['ok'=>true,'message'=>$status==='terlambat'?'Absensi berhasil. Status terlambat.':'Absensi berhasil.']);
    }
}
