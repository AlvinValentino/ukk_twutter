<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tweet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    // Function untuk mengakses halaman comment sekaligus mengambil data comment dan tweet
    public function index($id) {
        $dataTweet = Tweet::where('id', $id)->first();
        $dataComment = Comment::where('tweet_id', $id)->orderByDesc('created_at')->get();


        return view('comments.comment', ['title' => 'Comment Page', 'dataTweet' => $dataTweet, 'dataComment' => $dataComment]);
    }

    // Function untuk menambahkan comment pada sebuah tweet
    public function comment(Request $request) {
        $today = Carbon::now();

        $validatedData = $request->validate([
            'comment' => 'required|max:250',
        ]);

        // Untuk memisahkan # dengan string
        $arrayData = explode('#', $request->comment);
        $arrayOfTags = array_slice($arrayData, 1, count($arrayData) - 1);
        $tags = implode(',', $arrayOfTags);

        $fname = null;

        if ($request->hasFile('image')) {
            $storage_file = Storage::disk('comment');

            $fname = $today->format('Ymd_Hms') . '' . Str::random(5) . '' . Str::slug(Auth::user()->username, '_', 'end') . '.' . $request->file('image')->getClientOriginalExtension();
            $storage_file->putFileAs(null, $request->file('image'), $fname, []);
        }

        Comment::create([
            'comment' => $request->comment,
            'image' => $fname,
            'user_id' => Auth::user()->id,
            'tags' => $tags,
            'tweet_id' => $request->tweet_id
        ]);

        return response()->json(['success' => 'Comment successfully created']);
    }

    // Function untuk mengambil data agar dapat mengedit data comment
    public function editComment($id) {
        $dataComment = Comment::where('id', $id)->first();

        return view('comments.edit', ['title' => 'Edit Comment Page', 'dataComment' => $dataComment]);
    }

    // Function untuk aksi edit data comment
    public function updateComment(Request $request, $id) {
        $today = Carbon::now();
        
        $comment = Comment::find($id);

        // Untuk memisahkan # dengan string
        $arrayData = explode('#', $request->comment);
        $arrayOfTags = array_slice($arrayData, 1, count($arrayData) - 1);
        $tags = implode(',', $arrayOfTags);

        $validatedData = $request->validate([
            'comment' => 'required|max:250'
        ]);

        $fname = null;
        
        if ($request->hasFile('image')) {
            $storage_file = Storage::disk('comment');
            $fname = $today->format('Ymd_Hms') . '' . Str::random(5) . '' . Str::slug(Auth::user()->username, '_', 'end') . '.' . $request->file('image')->getClientOriginalExtension();
            $storage_file->putFileAs(null, $request->file('image'), $fname, []);
        }

        $comment->update([
            'image' => $fname,
            'comment' => $request->comment,
            'tags' => $tags,
        ]);

        return response()->json(['success' => 'Comment successfully updated!']);
    }

    // Function untuk mengahpus data comment yang diinginkan dari database
    public function deleteComment($id) {
        Comment::findOrFail($id)->delete();

        return redirect()->back();
    }
}
