<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    // Function untuk mengakses halaman profile
    public function index() {
        $dataTweet = Tweet::where('user_id', Auth::user()->id)->get();

        return view('profile.index', ['title' => 'Profile Page'], compact('dataTweet'));
    }

    // Function untuk memunculkan data untuk edit
    public function indexEdit() {
        $dataUser = User::findOrFail(Auth::user()->id)->first();

        return view('profile.edit', ['title' => 'Edit Profile Page', 'dataUser' => $dataUser]);
    }

    // Function untuk aksi edit data
    public function editProfile(Request $request, $id) {
        $validatedData = $request->validate([
            'username' => 'required'
        ]);

        $user = User::findOrFail($id);

        if(!User::where('username', $request->username)->exists() || $user->username === $request->username) {
            if($request->hasFile('avatar')) {
                $storage_file = Storage::disk('avatar');
    
                if($user->avatar && $storage_file->exists($user->avatar)) {
                    $storage_file->delete($user->avatar);
                }
    
                $fname = Str::random(5) . '' . Str::slug(Auth::user()->username) . '.' . $request->file('avatar')->getClientOriginalExtension();
                $storage_file->putFileAs(null, $request->file('avatar'), $fname, []);
            }
    
            $user->update([
                'avatar' => $request->avatar ? $fname : $user->avatar,
                'username' => $request->username,
                'name' => $request->name,
                'bio' => $request->bio
            ]);
    
            return response()->json(['message' => 'Profile successfully updated!', 'statusCode' => 200], 200);
        } else {
            return response()->json(['message' => 'Username ini telah digunakan oleh user lain', 'statusCode' => 500], 500);
        }
    }
}
