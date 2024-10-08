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

Route::get('/', 'HomeController@index');
Route::get('users', 'UserController@index')->name('users.index');
Route::post('users', 'UserController@store')->name('users.store');
Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy');

Route::resource('pages', 'PageController');
Route::get('eloquent', function() {
    //$posts = \App\Post::all();
    
    //$posts = \App\Post::where('id', '>=', '20')
    //    ->get();

    $posts = \App\Post::where('id', '>=', '20')
        ->orderBy('id', 'desc')
        ->get();

    foreach ($posts as $key => $post) {
        echo "$post->id $post->title <br>";
    }
});


Route::get('posts', function() {
    $posts = \App\Post::get();

    foreach ($posts as $key => $post) {
        echo "
        $post->id 
        <strong>{$post->user->name}</strong>
        $post->title <br>";
    }
});

Route::get('users', function() {
    $users = \App\User::get();

    foreach ($users as $key => $user) {
        echo "
        $user->id
        <strong>{$user->name}</strong>
        {$user->posts->count()} posts <br>";
    }
});


Route::get('collections', function() {
    $users = \App\User::all();

    //dd($users);
    //dd($users->contains(4)); // true
    //dd($users->except([1, 2, 3])); // shows only 4
    //dd($users->only(4)); // shows only 4
    //dd($users->find(4)); // shows only 4
    dd($users->load('posts'));
});

Route::get('serialization', function() {
    $users = \App\User::all();

   //dd($users->toArray());
   $user = $users->find(1)->toJson();
   dd($user);
});