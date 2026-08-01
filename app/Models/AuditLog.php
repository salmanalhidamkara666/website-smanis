<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;
    protected $table = 'audit_log';
    protected $guarded = [];
    protected $fillable = ['user_id','aktivitas','tabel','data_lama','data_baru','ip_address','user_agent'];
    protected $casts=['data_lama'=>'array','data_baru'=>'array'];
    public function user(){return $this->belongsTo(User::class);}
}
