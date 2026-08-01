<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    protected $guarded = [];
    protected $fillable = ['sesi_absensi_id','siswa_id','qr_absensi_id','waktu_masuk','waktu_keluar','status','keterangan','user_agent','ip_address'];
    protected $casts=['waktu_masuk'=>'datetime','waktu_keluar'=>'datetime'];
    public function siswa(){return $this->belongsTo(Siswa::class);}
    public function sesi(){return $this->belongsTo(SesiAbsensi::class,'sesi_absensi_id');}
    public function qr(){return $this->belongsTo(QrAbsensi::class,'qr_absensi_id');}
}
