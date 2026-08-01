<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    protected $table = 'izin';
    protected $guarded = [];
    protected $fillable = ['siswa_id','sesi_absensi_id','jenis','tanggal','keterangan','bukti','status','catatan_pembina'];
    protected $casts=['tanggal'=>'date'];
    public function siswa(){return $this->belongsTo(Siswa::class);}
    public function sesi(){return $this->belongsTo(SesiAbsensi::class,'sesi_absensi_id');}
}
