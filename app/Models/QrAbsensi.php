<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrAbsensi extends Model
{
    use HasFactory;
    protected $table = 'qr_absensi';
    protected $guarded = [];
    protected $fillable = ['sesi_absensi_id','token','jenis_absensi','expired_at','status'];
    protected $casts=['expired_at'=>'datetime'];
    public function sesi(){return $this->belongsTo(SesiAbsensi::class,'sesi_absensi_id');}
    public function absensi(){return $this->hasMany(Absensi::class);}
}
