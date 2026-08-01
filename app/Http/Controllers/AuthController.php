<?php
namespace App\Http\Controllers;
use App\Models\User;use Illuminate\Http\Request;use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function showLogin(){ return view('auth.login'); }
    public function login(Request $request){
        $data=$request->validate(['login'=>'required|string','password'=>'required|string']);
        $user=User::where('username',$data['login'])->orWhere('email',$data['login'])->first();
        if(!$user || !Hash::check($data['password'],$user->password) || $user->status!=='aktif') return back()->withErrors(['login'=>'Username atau password tidak valid.'])->withInput();
        session(['user_id'=>$user->id,'role'=>$user->role,'last_activity'=>now()]);
        return redirect()->route($user->role.'.dashboard');
    }
    public function logout(Request $request){ $request->session()->flush(); return redirect()->route('login')->with('success','Berhasil logout.'); }
}
