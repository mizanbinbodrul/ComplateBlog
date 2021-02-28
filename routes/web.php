<?php
use App\Http\Controllers;
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

Route::get('/category/{slug}', 'App\Http\Controllers\PostController@postByCategory')->name('category.posts');
Route::get('/tag/{slug}', 'App\Http\Controllers\PostController@postByTag')->name('tag.posts');

Route::get('profile/{username}', 'AuthorController@profile')->name('author.profile');
Route::get('post/{slug}', 'App\Http\Controllers\PostController@details')->name('post.details');
Route::get('posts', 'App\Http\Controllers\PostController@index')->name('post.index');

Route::group(['middleware'=>['auth']], function (){
    Route::post('favorite/{post}/add', 'App\Http\Controllers\favoriteController@add')->name('post.favorite');
    Route::post('comment/{post}/add', 'App\Http\Controllers\CommnentController@store')->name('comment.store');
});

Route::group(['as'=> 'admin.','prefix'=>'admin', 'middleware'=>['auth','admin']], function()
{
    // THIS IS FOR ADMIN SETTING
    Route::get('dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
    Route::resource('tag', 'App\Http\Controllers\Admin\TagController');
    Route::get('setting', 'App\Http\Controllers\Admin\SettingController@index')->name('setting');
    Route::put('update-profile', 'App\Http\Controllers\Admin\SettingController@updateProfile')->name('profile.update');
    Route::put('update-password', 'App\Http\Controllers\Admin\SettingController@updatePassword')->name('password.update');

    // THIS IS FOR CATEGORY
    Route::resource('category', 'App\Http\Controllers\Admin\CategoryController');
    Route::resource('post', 'App\Http\Controllers\Admin\PostController');

    // THIS IS FOR PENDIING POST
    Route::get('pending/post', 'App\Http\Controllers\Admin\PostController@pending')->name('post.pending');
    Route::put('/post/{id}/approve', 'App\Http\Controllers\Admin\PostController@approval')->name('post.approve');

    // THIS IS FOR FAVORITE POST
    Route::get('/favorite', 'App\Http\Controllers\Admin\FavoriteController@index')->name('favorite.index');

    // THIS IS FOR COMMENTS
    Route::get('comments', 'App\Http\Controllers\Admin\CommentController@index')->name('comment.index');
    Route::delete('comments/{id}', 'App\Http\Controllers\Admin\CommentController@destroy')->name('comment.destroy');


    // THIS IS FOR SUBSCRIBERS
    Route::get('/subscriber', 'App\Http\Controllers\Admin\SubscriberController@index')->name('subscriber.index');
    Route::delete('/subscriber/{subscriber}', 'App\Http\Controllers\Admin\SubscriberController@destroy')->name('subscriber.destroy');
});



Route::group(['as'=> 'author.','prefix'=>'author', 'middleware'=>['auth','author']], function()
{
    Route::get('dashboard', 'App\Http\Controllers\Author\DashboardController@index')->name('dashboard');
    Route::get('/favorite', 'App\Http\Controllers\Author\FavoriteController@index')->name('favorite.index');

    // THIS IS FOR COMMENTS
    Route::get('comments', 'App\Http\Controllers\Author\CommentController@index')->name('comment.index');
    Route::delete('comments/{id}', 'App\Http\Controllers\Author\CommentController@destroy')->name('comment.destroy');

    // THIS IS FOR AUTHOR SETTING
    Route::get('setting', 'App\Http\Controllers\Author\SettingController@index')->name('setting');
    Route::put('update-profile', 'App\Http\Controllers\Author\SettingController@updateProfile')->name('profile.update');
    Route::put('update-password', 'App\Http\Controllers\Author\SettingController@updatePassword')->name('password.update');
    Route::resource('post', 'App\Http\Controllers\Author\PostController');
});
