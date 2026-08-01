<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;use App\Models\{Izin,Notifikasi};
class IzinController extends Controller
{
    public function index(){ $q=Izin::with(['siswa','sesi']); if(session('role')==='siswa') $q->where('siswa_id',auth_user()->siswa?->id); return view('izin.index',['items'=>$q->latest()->paginate(10)]); }
    public function store(Request $r){ $d=$r->validate(['sesi_absensi_id'=>'nullable','jenis'=>'required|in:izin,sakit','tanggal'=>'required|date','keterangan'=>'nullable','bukti'=>'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048']); $d['siswa_id']=auth_user()->siswa->id; if($r->hasFile('bukti')) $d['bukti']=$r->file('bukti')->store('bukti-izin','public'); Izin::create($d); return back()->with('success','Pengajuan dikirim.'); }
    public function updateStatus(Request $r,Izin $izin){ $d=$r->validate(['status'=>'required|in:disetujui,ditolak','catatan_pembina'=>'nullable']); $izin->update($d); Notifikasi::create(['user_id'=>$izin->siswa->user_id,'judul'=>'Status Pengajuan','pesan'=>'Pengajuan '.$izin->jenis.' '.$d['status'].'.','tipe'=>'izin']); return back()->with('success','Status pengajuan diperbarui.'); }
}
