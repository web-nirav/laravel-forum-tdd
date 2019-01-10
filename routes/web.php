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

/* 
TODO: Continue from: 
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('threads', 'ThreadsController@index')->name('threads.index');
Route::get('threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('threads/{channel}', 'ThreadsController@index')->name('threads.channel.index');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.channel.show');
Route::post('threads', 'ThreadsController@store')->name('threads.store');

Route::post('threads/{channel}/{thread}/replies', 'RepliesController@store')->name('replies.store');

Route::post('replies/{reply}/favorites', 'FavoritesController@store');

Route::get('profiles/{user}', 'ProfilesController@show')->name('profile');

Route::get('test', function(){

   /*  $collection = collect([
        ['product' => 'Desk', 'price' => 200],
        ['product' => 'Chair', 'price' => 100],
        ['product' => 'Bookcase', 'price' => 150],
        ['product' => 'Door', 'price' => 100],
    ]);
    
    $filtered = $collection->whereNotIn('price', [150, 200]);
    
    return $filtered->all(); */

    /* $collection = collect([
        ['product' => 'Desk', 'price' => 200],
        ['product' => 'Chair', 'price' => 80],
        ['product' => 'Bookcase', 'price' => 150],
        ['product' => 'Pencil', 'price' => 30],
        ['product' => 'Door', 'price' => 100],
    ]);
    
    $filtered = $collection->whereNotInStrict('price', [100, 150, 200]);
    
    return $filtered->all(); */

    dd(\Illuminate\Support\Collection::wrap(collect(['Nilu'])));
    
});