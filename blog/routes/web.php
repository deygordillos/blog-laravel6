<?php

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

Route::get('/', 'PageController@posts');
Route::get('blog/{post}', 'PageController@post')->name('post');

Route::get('users', 'UserController@index')->name('users.index');
Route::post('users', 'UserController@store')->name('users.store');
Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');

Route::get('posts', function() {
    $posts = \App\Post::get();

    foreach ($posts as $key => $post) {
        echo "
        $post->id 
        <strong>{$post->user->name}</strong>
        $post->title <br>";
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');