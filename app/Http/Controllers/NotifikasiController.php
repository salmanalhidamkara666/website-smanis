<?php
namespace App\Http\Controllers;
use App\Models\Notifikasi;
class NotifikasiController extends Controller
{
    public function index(){ $items=Notifikasi::where('user_id',session('user_id'))->latest()->paginate(15); return view('notifikasi.index',compact('items')); }
    public function read(Notifikasi $notifikasi){ abort_unless($notifikasi->user_id===session('user_id'),403); $notifikasi->update(['status_baca'=>true]); return back(); }
}
