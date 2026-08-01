<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;use App\Models\{Siswa,Pembina,Kelas,Ekstrakurikuler,AnggotaEkstrakurikuler,Jadwal,User,AuditLog};use Illuminate\Support\Facades\Hash;
class CrudController extends Controller
{
    private function log($act,$table,$new=null,$old=null){ AuditLog::create(['user_id'=>session('user_id'),'aktivitas'=>$act,'tabel'=>$table,'data_lama'=>$old,'data_baru'=>$new,'ip_address'=>request()->ip(),'user_agent'=>substr(request()->userAgent(),0,250)]); }
    public function siswaIndex(Request $r){ $items=Siswa::with('kelas')->when($r->q,fn($q)=>$q->where('nama','like','%'.$r->q.'%')->orWhere('nis','like','%'.$r->q.'%'))->paginate(10); return view('crud.siswa.index',compact('items')); }
    public function siswaStore(Request $r){ $d=$r->validate(['nis'=>'required|unique:siswa','nama'=>'required','jenis_kelamin'=>'required','kelas_id'=>'required','no_hp'=>'nullable','alamat'=>'nullable','wali_nama'=>'nullable','wali_no_hp'=>'nullable']); $u=User::create(['name'=>$d['nama'],'username'=>$d['nis'],'email'=>null,'password'=>Hash::make('password'),'role'=>'siswa','status'=>'aktif']); $d['user_id']=$u->id; Siswa::create($d); $this->log('Tambah siswa','siswa',$d); return back()->with('success','Data siswa ditambahkan.'); }
    public function siswaUpdate(Request $r,Siswa $siswa){ $d=$r->validate(['nis'=>'required|unique:siswa,nis,'.$siswa->id,'nama'=>'required','jenis_kelamin'=>'required','kelas_id'=>'required','no_hp'=>'nullable','alamat'=>'nullable','wali_nama'=>'nullable','wali_no_hp'=>'nullable']); $old=$siswa->toArray(); $siswa->update($d); $this->log('Ubah siswa','siswa',$d,$old); return back()->with('success','Data siswa diperbarui.'); }
    public function siswaDestroy(Siswa $siswa){ $old=$siswa->toArray(); $siswa->delete(); $this->log('Hapus siswa','siswa',null,$old); return back()->with('success','Data siswa dihapus.'); }

    public function pembinaIndex(Request $r){ $items=Pembina::when($r->q,fn($q)=>$q->where('nama','like','%'.$r->q.'%')->orWhere('nip','like','%'.$r->q.'%'))->paginate(10); return view('crud.pembina.index',compact('items')); }
    public function pembinaStore(Request $r){ $d=$r->validate(['nip'=>'required|unique:pembina','nama'=>'required','no_hp'=>'nullable','alamat'=>'nullable']); $u=User::create(['name'=>$d['nama'],'username'=>$d['nip'],'password'=>Hash::make('password'),'role'=>'pembina','status'=>'aktif']); $d['user_id']=$u->id; Pembina::create($d); return back()->with('success','Pembina ditambahkan.'); }
    public function pembinaUpdate(Request $r,Pembina $pembina){ $d=$r->validate(['nip'=>'required|unique:pembina,nip,'.$pembina->id,'nama'=>'required','no_hp'=>'nullable','alamat'=>'nullable']); $pembina->update($d); return back()->with('success','Pembina diperbarui.'); }
    public function pembinaDestroy(Pembina $pembina){ $pembina->delete(); return back()->with('success','Pembina dihapus.'); }

    public function kelasIndex(Request $r){ $items=Kelas::when($r->q,fn($q)=>$q->where('nama_kelas','like','%'.$r->q.'%'))->paginate(10); return view('crud.kelas.index',compact('items')); }
    public function kelasStore(Request $r){ Kelas::create($r->validate(['nama_kelas'=>'required','tingkat'=>'nullable','jurusan'=>'nullable'])); return back()->with('success','Kelas ditambahkan.'); }
    public function kelasUpdate(Request $r,Kelas $kelas){ $kelas->update($r->validate(['nama_kelas'=>'required','tingkat'=>'nullable','jurusan'=>'nullable'])); return back()->with('success','Kelas diperbarui.'); }
    public function kelasDestroy(Kelas $kelas){ $kelas->delete(); return back()->with('success','Kelas dihapus.'); }

    public function ekskulIndex(Request $r){ $items=Ekstrakurikuler::with('pembina')->when($r->q,fn($q)=>$q->where('nama','like','%'.$r->q.'%'))->paginate(10); return view('crud.ekskul.index',compact('items')); }
    public function ekskulStore(Request $r){ Ekstrakurikuler::create($r->validate(['nama'=>'required','deskripsi'=>'nullable','pembina_id'=>'required','lokasi'=>'nullable','status'=>'required'])); return back()->with('success','Ekstrakurikuler ditambahkan.'); }
    public function ekskulUpdate(Request $r,Ekstrakurikuler $ekskul){ $ekskul->update($r->validate(['nama'=>'required','deskripsi'=>'nullable','pembina_id'=>'required','lokasi'=>'nullable','status'=>'required'])); return back()->with('success','Ekstrakurikuler diperbarui.'); }
    public function ekskulDestroy(Ekstrakurikuler $ekskul){ $ekskul->delete(); return back()->with('success','Ekstrakurikuler dihapus.'); }

    public function anggotaIndex(){ $items=AnggotaEkstrakurikuler::with(['siswa','ekstrakurikuler'])->paginate(10); return view('crud.anggota.index',compact('items')); }
    public function anggotaStore(Request $r){ AnggotaEkstrakurikuler::updateOrCreate($r->validate(['siswa_id'=>'required','ekstrakurikuler_id'=>'required']),['status'=>$r->status??'aktif']); return back()->with('success','Anggota disimpan.'); }
    public function anggotaDestroy(AnggotaEkstrakurikuler $anggota){ $anggota->delete(); return back()->with('success','Anggota dihapus.'); }

    public function jadwalIndex(){ $items=Jadwal::with('ekstrakurikuler')->paginate(10); return view('crud.jadwal.index',compact('items')); }
    public function jadwalStore(Request $r){ Jadwal::create($r->validate(['ekstrakurikuler_id'=>'required','hari'=>'required','jam_mulai'=>'required','jam_selesai'=>'required','lokasi'=>'nullable'])); return back()->with('success','Jadwal ditambahkan.'); }
    public function jadwalDestroy(Jadwal $jadwal){ $jadwal->delete(); return back()->with('success','Jadwal dihapus.'); }
}
