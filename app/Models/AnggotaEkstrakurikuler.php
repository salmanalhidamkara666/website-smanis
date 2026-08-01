<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaEkstrakurikuler extends Model
{
    use HasFactory;
    protected $table = 'anggota_ekstrakurikuler';
    protected $guarded = [];
    protected $fillable = ['siswa_id','ekstrakurikuler_id','status'];
    public function siswa(){return $this->belongsTo(Siswa::class);}
    public function ekstrakurikuler(){return $this->belongsTo(Ekstrakurikuler::class);}
}
