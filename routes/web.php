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



Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

Route::post('subscriber', 'App\Http\Controllers\SubscriberController@store')->name('subscriber.store');
Auth::routes();


Route::group(['as'=> 'admin.','prefix'=>'admin', 'middleware'=>['auth','admin']], function()
{
    Route::get('dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
    Route::resource('tag', 'App\Http\Controllers\Admin\TagController');
    Route::resource('category', 'App\Http\Controllers\Admin\CategoryController');
    Route::resource('post', 'App\Http\Controllers\Admin\PostController');

    Route::get('pending/post', 'App\Http\Controllers\Admin\PostController@pending')->name('post.pending');
    Route::put('/post/{id}/approve', 'App\Http\Controllers\Admin\PostController@approval')->name('post.approve');

    Route::get('/subscriber', 'App\Http\Controllers\Admin\SubscriberController@index')->name('subscriber.index');
    Route::delete('/subscriber/{subscriber}', 'App\Http\Controllers\Admin\SubscriberController@destroy')->name('subscriber.destroy');


});
Route::group(['as'=> 'author.','prefix'=>'author', 'middleware'=>['auth','author']], function()
{
    Route::get('dashboard', 'App\Http\Controllers\Author\DashboardController@index')->name('dashboard');
    Route::resource('post', 'App\Http\Controllers\Author\PostController');
});
