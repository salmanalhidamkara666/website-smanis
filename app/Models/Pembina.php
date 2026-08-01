<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembina extends Model
{
    use HasFactory;
    protected $table = 'pembina';
    protected $guarded = [];
    protected $fillable = ['user_id','nip','nama','no_hp','alamat'];
    public function user(){return $this->belongsTo(User::class);}
    public function ekstrakurikuler(){return $this->hasMany(Ekstrakurikuler::class);}
}
