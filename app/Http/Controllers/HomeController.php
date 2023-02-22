<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tag;
use App\Models\Tweet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use stdClass;

class HomeController extends Controller
{
    // Function untuk mengakses halaman home
    public function index() {
        $tweetData = Tweet::latest()->get();
            
        return view('tweets.home', ['title' => 'Home Page', 'tweetData' => $tweetData]);
    }

    // Function untuk melakukan aksi upload tweet
    public function postTweet(Request $request) {
        $today = Carbon::now();
        
        $validatedData = $request->validate([
            'tweet' => 'required|max:250'
        ]);

        // Untuk memisahkan # dengan string
        $arrayData = explode('#', $request->tweet);
        $arrayOfTags = array_slice($arrayData, 1, count($arrayData) - 1);
        $tags = implode(',', $arrayOfTags);

        $fname = null;

        if ($request->hasFile('image')) {
            $storage_file = Storage::disk('images');

            $fname = $today->format('Ymd_Hms') . '' . Str::random(5) . '' . Str::slug(Auth::user()->username, '_', 'end') . '.' . $request->file('image')->getClientOriginalExtension();
            $storage_file->putFileAs(null, $request->file('image'), $fname, []);
        }


        Tweet::create([
            'tags' => $tags,
            'tweet' => $request->tweet,
            'image' => $fname,
            'user_id' => Auth::user()->id,
        ]);


        return response()->json(['success' => 'Tweet successfully uploaded!'], 200);
    }

    // Function untuk mengambil data untuk edit tweet
    public function editTweet($id) {
        $showTweet = Tweet::where('id', $id)->first();

        return view('tweets.edit', ['title' => 'Edit Tweet Page', 'dataTweet' => $showTweet]);
    }

    // Function untuk aksi edit data tweet
    public function updateTweet(Request $request, $id) {
        $tweet = Tweet::find($id);

        $today = Carbon::now();

        $validatedData = $request->validate([
            'tweet' => 'required|max:250'
        ]);
        
        $fname = null;
        
        if ($request->hasFile('image')) {
            $storage_file = Storage::disk('images');
            $fname = $today->format('Ymd_Hms') . '' . Str::random(5) . '' . Str::slug(Auth::user()->username, '_', 'end') . '.' . $request->file('image')->getClientOriginalExtension();
            $storage_file->putFileAs(null, $request->file('image'), $fname, []);
        }

        $tweet->update([
            'tweet' => $request->tweet,
            'image' => $fname
        ]);

        return response()->json(['success' => 'Tweet successfully updated!']);
    }

    // Function untuk melakukan aksi penghapusan data tweet dari database
    public function deleteTweet($id) {
        Tweet::findOrFail($id)->delete();
        Comment::where('tweet_id', $id)->delete();

        return redirect()->route('home');
    }
}
