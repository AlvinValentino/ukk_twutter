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
        for($i = 0; $i < count($arrayOfTags); $i++) {
            $explodeTagSpace = explode(' ', $arrayOfTags[$i]);
            $arrayOfTags[$i] = $explodeTagSpace[0];
        }

        $tags = implode(',', $arrayOfTags);

        if ($request->hasFile('image')) {
            $storage_file = Storage::disk('images');

            $fname = $today->format('Ymd_Hms') . '' . Str::random(5) . '' . Str::slug(Auth::user()->username, '_', 'end') . '.' . $request->file('image')->getClientOriginalExtension();
            $storage_file->putFileAs(null, $request->file('image'), $fname, []);
        }

        Tweet::create([
            'tags' => $tags,
            'tweet' => $arrayData[0],
            'image' => $fname ? $fname : null,
            'user_id' => Auth::user()->id,
        ]);


        return response()->json(['message' => 'Tweet berhasil terunggah', 'statusCode' => 201], 201);
    }

    // Function untuk mengambil data untuk edit tweet
    public function editTweet($id) {
        $showTweet = Tweet::where('id', $id)->first();

        return view('tweets.edit', ['title' => 'Edit Tweet Page', 'dataTweet' => $showTweet]);
    }

    // Function untuk aksi edit data tweet
    public function updateTweet(Request $request, $id) {
        $tweet = Tweet::findOrFail($id);
        $today = Carbon::now();

        $validatedData = $request->validate([
            'tweet' => 'required|max:250'
        ]);

        $arrayData = explode('#', $request->tweet);
        $arrayOfTags = array_slice($arrayData, 1, count($arrayData) - 1);
        for($i = 0; $i < count($arrayOfTags); $i++) {
            $explodeTagSpace = explode(' ', $arrayOfTags[$i]);
            $arrayOfTags[$i] = $explodeTagSpace[0];
        }

        $tags = implode(',', $arrayOfTags);
        
        if ($request->hasFile('image')) {
            $storage_file = Storage::disk('images');

            if($tweet->image && $storage_file->exists($tweet->image)) {
                $storage_file->delete($tweet->image);
            }

            $fname = $today->format('Ymd_Hms') . '' . Str::random(5) . '' . Str::slug(Auth::user()->username, '_', 'end') . '.' . $request->file('image')->getClientOriginalExtension();
            $storage_file->putFileAs(null, $request->file('image'), $fname, []);
        }

        $tweet->update([
            'tweet' => $arrayData[0],
            'tags' => $tags,
            'image' => $request->image ? $fname : $tweet->image
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
