<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tweet;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    // Function untuk mengakses halaman explore
    public function index() {
        return view('search.index', ['title' => 'Explore Page']);
    }

    // Function untuk melakukan aksi pencarian data berdasarkan yang diinginkan
    public function searchData(Request $request) {
        if($request->has('search')) {
            $dataTweet = Tweet::where('tweet', 'LIKE', '%' . $request->search . '%')->orWhere('tags', 'LIKE', '%' . $request->search . '%')->get();
            $dataComment = Comment::where('comment', 'LIKE', '%' . $request->search . '%')->orWhere('tags', 'LIKE', '%' . $request->search . '%')->get();
        }

        return view('search.explore', ['title' => 'Explore Page', 'dataTweet' => $dataTweet, 'dataComment' => $dataComment, 'search' => $request->search]);
    }
}
