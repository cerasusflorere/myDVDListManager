<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// DVD一覧取得
Route::get('/DVDs_all', 'App\Http\Controllers\DVDController@index')->name('DVD.index');

// DVD貸出一覧取得
Route::get('/DVDs_rent', 'App\Http\Controllers\DVDController@rent')->name('DVD.rent');

// 劇場一覧取得
Route::get('/theater', 'App\Http\Controllers\DVDController@theater')->name('DVD.theater');

// 戯曲一覧取得
Route::get('/author', 'App\Http\Controllers\DVDController@author')->name('DVD.author');

// 衣装一覧取得
Route::get('/costumer', 'App\Http\Controllers\DVDController@costumer')->name('DVD.costumer');

// 作詞一覧取得
Route::get('/lyricist', 'App\Http\Controllers\DVDController@lyricist')->name('DVD.lyricist');

// 振付一覧取得
Route::get('/choreo', 'App\Http\Controllers\DVDController@choreo')->name('DVD.choreo');

// ゲキ×シネ監督一覧取得
Route::get('/director', 'App\Http\Controllers\DVDController@director')->name('DVD.director');

// DVD詳細取得
Route::get('/DVD/{id}', 'App\Http\Controllers\DVDController@show')->name('DVD.show');

// DVD削除
Route::delete('/DVD/{id}', 'App\Http\Controllers\DVDController@delete')->name('DVD.delete');

// DVD登録
Route::post('/DVD', 'App\Http\Controllers\DVDController@store')->name('DVD.store');

// 貸出登録
Route::post('/rent', 'App\Http\Controllers\RentController@store')->name('rent.store');

// DVD編集
Route::post('/DVD/{id}', 'App\Http\Controllers\DVDController@update')->name('DVD.update');

// 返却更新
Route::post('/return', 'App\Http\Controllers\RentController@update')->name('rent.update');

// 貸出まとめて更新
Route::post('/rentEdit', 'App\Http\Controllers\RentController@updateAll')->name('rent.updateAll');
