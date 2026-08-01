<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    use HasFactory;
    protected $table = 'ekstrakurikuler';
    protected $guarded = [];
    protected $fillable = ['nama','deskripsi','pembina_id','lokasi','status'];
    public function pembina(){return $this->belongsTo(Pembina::class);}
    public function jadwal(){return $this->hasMany(Jadwal::class);}
    public function siswa(){return $this->belongsToMany(Siswa::class,'anggota_ekstrakurikuler')->withPivot('status')->withTimestamps();}
}
