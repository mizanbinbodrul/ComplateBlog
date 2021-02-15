<?php

use Illuminate\Support\Facades\Route;


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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Auth::routes();


Route::group(['as'=> 'admin.','prefix'=>'admin', 'middleware'=>['auth','admin']], function()
{
    Route::get('dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
    Route::resource('tag', 'App\Http\Controllers\Admin\TagController');
    Route::resource('category', 'App\Http\Controllers\Admin\CategoryController');
    Route::resource('post', 'App\Http\Controllers\Admin\PostController');

});
Route::group(['as'=> 'author.','prefix'=>'author', 'middleware'=>['auth','author']], function()
{
    Route::get('dashboard', 'App\Http\Controllers\Author\DashboardController@index')->name('dashboard');

});
