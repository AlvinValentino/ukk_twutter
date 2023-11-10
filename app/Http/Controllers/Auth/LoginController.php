<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Untuk middleware auth agar user yang login tidak mengakses
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
        if(Auth::attempt($validatedData)) {
            return response()->json(['message' => 'Login successfully', 'statusCode' => 200], 200);
        }
        
        return response()->json(['message' => 'Login failed!', 'statusCode' => 401], 401);
    }

    // Function untuk aksi logout
    public function logout() {
        if(Auth::check()) {
            Auth::logout();
            return response()->json(['message' => 'Anda berhasil logout!', 'statusCode' => 200], 200);
        } else { 
            return response()->json(['message' => 'Anda belum login!', 'statusCode' => 500], 500);
        }
    }
}
