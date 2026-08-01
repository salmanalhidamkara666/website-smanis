<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';
    protected $guarded = [];
    protected $fillable = ['name','username','email','password','role','status'];
    protected $hidden=['password'];
    public function siswa(){return $this->hasOne(Siswa::class);}
    public function pembina(){return $this->hasOne(Pembina::class);}
    public function notifikasi(){return $this->hasMany(Notifikasi::class);}
}
