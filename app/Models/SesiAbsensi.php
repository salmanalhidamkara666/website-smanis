<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiAbsensi extends Model
{
    use HasFactory;
    protected $table = 'sesi_absensi';
    protected $guarded = [];
    protected $fillable = ['ekstrakurikuler_id','pembina_id','jadwal_id','tanggal','jam_mulai','jam_selesai','status'];
    protected $casts=['tanggal'=>'date'];
    public function ekstrakurikuler(){return $this->belongsTo(Ekstrakurikuler::class);}
    public function pembina(){return $this->belongsTo(Pembina::class);}
    public function jadwal(){return $this->belongsTo(Jadwal::class);}
    public function qrAbsensi(){return $this->hasMany(QrAbsensi::class);}
    public function absensi(){return $this->hasMany(Absensi::class);}
}
