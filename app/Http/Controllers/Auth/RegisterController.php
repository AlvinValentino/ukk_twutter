<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{   // Untuk middleware auth agar user yang blm login tidak mengakses
    function __construct() {
        $this->middleware('auth')->except('index', 'registerAction');
    }

    // Function untuk mengakses halaman register
    public function index() {
        return view('auth.register', ['title' => 'Register Page']);
    }

    // Function untuk aksi register
    public function registerAction(Request $request) {
        // Validasi data dari client apakah sesuai
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users',
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        // Keadaan dimana jika email yang sama pernah digunakan
        if(User::where('email', $request->email)->exists()) {
            return redirect()->back()->with(['error' => 'Email already taken!'], 422);
        } else {
            // Untuk memasukkan data yang dikirimkan client ke database jika berhasil melewati pemeriksaan
            User::create([
                'email' => $request->email,
                'username' =>  $request->username,
                'password' => bcrypt($request->password) // Enkripsi password agar akun tidak gampang dibobol
            ]);

            return redirect()->route('auth.login');
        }
    }
}
