<?php
use App\Models\User;
if (!function_exists('auth_user')) {
    function auth_user(){ return session('user_id') ? User::find(session('user_id')) : null; }
}
