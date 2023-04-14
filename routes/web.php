<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [StoreController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('store')->group(function(){
    Route::get('',[StoreController::class, 'index'])->name('store.index');
    Route::post('searchindex',[StoreController::class, 'searchindex'])->name('store.searchindex');
    Route::get('userindex',[StoreController::class, 'userindex'])->name('store.userindex')->middleware('auth');
    Route::get('niceindex',[StoreController::class, 'niceindex'])->name('store.niceindex')->middleware('auth');
    Route::get('create',[StoreController::class, 'create'])->name('store.create')->middleware('auth');
    Route::post('',[StoreController::class, 'store'])->name('store.store')->middleware('auth');
    Route::get('{store}',[StoreController::class, 'show'])->name('store.show');
    Route::get('{store}/nice',[StoreController::class, 'niceshow'])->name('store.niceshow');
    Route::get('{store}/edit',[StoreController::class, 'edit'])->name('store.edit')->middleware('auth');
    Route::patch('{store}',[StoreController::class, 'update'])->name('store.update')->middleware('auth');
    Route::delete('{store}',[StoreController::class, 'destroy'])->name('store.destroy')->middleware('auth');

    Route::post('nice/{store_id}',[StoreController::class, 'nicestore'])->middleware('auth');
    Route::post('deletenice/{store_id}',[StoreController::class, 'nicedelete'])->name('store.deletenice')->middleware('auth');

    Route::get('{store}/comment',[StoreController::class, 'commentshow'])->name('store.commentshow');

    Route::get('{store}/keywordedit',[StoreController::class, 'keywordsedit'])->name('store.keywordsedit')->middleware('auth');
    Route::patch('{keyword}/keyword',[StoreController::class, 'keywordsupdate'])->name('store.keywordsupdate')->middleware('auth');
    Route::delete('{keyword}/keywordsdelete',[StoreController::class, 'keywordsdestroy'])->name('store.keywordsdestroy')->middleware('auth');
});


// Route::get('comments/create/{store}',[Commentcontroller::class, 'create'])->name('comments.create')->middleware('auth');
// Route::post('',[Commentcontroller::class, 'store'])->name('comments.store')->middleware('auth');

Route::prefix('comments')->group(function(){
    Route::get('index',[CommentController::class, 'index'])->name('comments.index')->middleware('auth');
    Route::get('create/{store}',[CommentController::class, 'create'])->name('comments.create')->middleware('auth');
    Route::get('nicecreate/{store}',[CommentController::class, 'nicecreate'])->name('comments.nicecreate')->middleware('auth');
    Route::post('',[CommentController::class, 'store'])->name('comments.store')->middleware('auth');
    Route::post('nice',[CommentController::class, 'nicestore'])->name('comments.nicestore')->middleware('auth');
    Route::get('{comment}/edit',[CommentController::class, 'edit'])->name('comments.edit')->middleware('auth');
    Route::patch('{comment}',[CommentController::class, 'update'])->name('comments.update')->middleware('auth');
    Route::delete('{comment}',[CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');
});

Route::prefix('photo')->group(function(){
    Route::get('index',[PhotoController::class, 'index'])->name('photo.index')->middleware('auth');
    Route::get('create/{store}',[PhotoController::class, 'create'])->name('photo.create')->middleware('auth');
    Route::get('nicecreate/{store}',[PhotoController::class, 'nicecreate'])->name('photo.nicecreate')->middleware('auth');
    Route::post('',[PhotoController::class, 'store'])->name('photo.store')->middleware('auth');
    Route::post('nice',[PhotoController::class, 'nicestore'])->name('photo.nicestore')->middleware('auth');
    Route::delete('{photo}',[PhotoController::class, 'destroy'])->name('photo.destroy')->middleware('auth');
});

Route::prefix('keywords')->group(function(){
    Route::get('create/{store}',[KeywordController::class, 'create'])->name('keywords.create')->middleware('auth');
    Route::post('',[KeywordController::class, 'store'])->name('keywords.store')->middleware('auth');
});

Route::prefix('users')->group(function(){
    Route::get('index',[UserController::class, 'mypage'])->name('mypage')->middleware('auth');
});