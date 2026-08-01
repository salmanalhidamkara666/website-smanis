<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $guarded = [];
    protected $fillable = ['user_id','nis','nama','jenis_kelamin','kelas_id','alamat','no_hp','wali_nama','wali_no_hp','wali_user_id'];
    public function user(){return $this->belongsTo(User::class);}
    public function wali(){return $this->belongsTo(User::class,'wali_user_id');}
    public function kelas(){return $this->belongsTo(Kelas::class);}
    public function ekstrakurikuler(){return $this->belongsToMany(Ekstrakurikuler::class,'anggota_ekstrakurikuler')->withPivot('status')->withTimestamps();}
    public function absensi(){return $this->hasMany(Absensi::class);}
}
