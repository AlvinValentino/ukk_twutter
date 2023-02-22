<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Untuk middleware auth agar user yang blm login tidak mengakses
    function __construct() {
        $this->middleware('auth')->except('index', 'loginAction');
    }

    // Function untuk mengakses halaman login
    public function index() {
        return view('auth.login', ['title' => 'Login Page']);
    }

    // Function untuk aksi login
    public function loginAction(Request $request) {
        // Validasi data dari client apakah sudah sesuai
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Pengecekan dimana jika data dari client sesuai dengan database
        if(!$token = Auth::attempt($validatedData)) {
            return response()->json(['error' => 'Login failed!'], 422);
        }

        return response()->json(['success' => 'Login successfully'], 200);
    }

    // Function untuk aksi logout
    public function logout() {
        auth()->logout();

        return redirect()->route('auth.login');
    }
}
