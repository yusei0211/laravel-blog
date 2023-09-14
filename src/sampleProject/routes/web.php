<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

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
//ブログ一覧画面を表示

Route::get('/',[BlogController::class, 'showList'])->name('blogs');

//ブログ登録画面
Route::get('/blog/create',[BlogController::class, 'showCreate'])->name('create');

//ブログ登録
Route::post('/blog/store',[BlogController::class, 'exeStore'])->name('store');

//ブログ詳細を表示
Route::get('/blog/{id}',[BlogController::class, 'showDetail'])->name('show');

//ブログ編集を表示
Route::get('/blog/edit/{id}',[BlogController::class, 'showEdit'])->name('edit');

//ブログ編集
Route::post('/blog/update',[BlogController::class, 'exeUpdate'])->name('update');

//ブログ削除
Route::post('/blog/delete/{id}',[BlogController::class, 'exeDelete'])->name('delete');


// Route::get('/', function () {
//          return view('layout');
//      });

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
