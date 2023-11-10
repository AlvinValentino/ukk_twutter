<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Routing untuk path auth
Route::group(['prefix' => '/'], function() {

    // Routing untuk login
    Route::get('/', [LoginController::class, 'index'])->name('auth.login');
    Route::post('/', [LoginController::class, 'loginAction'])->name('auth.loginAction');

    // Routing untuk logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');

    // Routing untuk register
    Route::get('/register', [RegisterController::class, 'index'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'registerAction'])->name('auth.registerAction');
});

Route::group(['middleware' => 'auth'], function() {
    // Routing untuk path home
    Route::group(['prefix' => 'home'], function() {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::post('/', [HomeController::class, 'postTweet'])->name('postTweet');
        Route::post('/deleteTweet/{id}', [HomeController::class, 'deleteTweet'])->name('deleteTweet');
        Route::get('/editTweet/{id}', [HomeController::class, 'editTweet'])->name('editTweet');
        Route::post('/updateTweet/{id}', [HomeController::class, 'updateTweet'])->name('updateTweet');
    });
    
    // Routing untuk path profile
    Route::group(['prefix' => 'profile'], function() {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::get('/edit', [ProfileController::class, 'indexEdit'])->name('editProfile');
        Route::post('/edit/{id}', [ProfileController::class, 'editProfile'])->name('editProfile.action');
    });
    
    // Routing untuk path comment
    Route::group(['prefix' => 'comment'], function() {
        Route::get('/{id}', [CommentController::class, 'index'])->name('comment');
        Route::post('/', [CommentController::class, 'comment'])->name('createComment');
        Route::get('/editComment/{id}', [CommentController::class, 'editComment'])->name('editComment');
        Route::post('/updateComment/{id}', [CommentController::class, 'updateComment'])->name('updateComment');
        Route::post('/deleteComment/{id}', [CommentController::class, 'deleteComment'])->name('deleteComment');
    });
    
    // Routing untuk path explore
    Route::group(['prefix' => 'explore'], function() {
        Route::get('/', [ExploreController::class, 'index'])->name('explore.index');
        Route::get('/search', [ExploreController::class, 'searchData'])->name('explore.search');
    }); 
});