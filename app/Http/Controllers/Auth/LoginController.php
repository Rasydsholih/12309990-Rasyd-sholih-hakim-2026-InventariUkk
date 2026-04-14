<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
    

    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect('/inventaris');
        }
        return redirect('/')->with('show_login_modal', true);
    }

    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/inventaris')->with('success', 'Login berhasil.');
        }
        
        return back()
            ->withInput()
            ->withErrors([
                'email' => 'Kredensial tidak cocok dengan data kami.',
            ])
            ->with('show_login_modal', true);
            
    }
    
    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
