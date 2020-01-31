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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/post/index', 'PostController@index');
Route::get('/post/search', 'PostController@search');
Route::get('/post/detail/{tmdb_id}', 'PostController@detail');//<a href="/post/detail/{{$movie->id}}" class="card">の$movie->idが{tmdb_id}に代入されている
Route::post('/post/release/{tmdb_id}', 'PostController@release');
Route::post('/post/like/{tmdb_id}', 'PostController@like');
Route::get('/post/create/{tmdb_id}', 'PostController@create');
Route::post('/post/register/{tmdb_id}', 'PostController@register');
Route::get('/post/edit/{tmdb_id}/{post_id}', 'PostController@edit');
Route::get('/post/update/{tmdb_id}', 'PostController@update');
Route::get('/post/delete/{tmdb_id}/{post_id}', 'PostController@delete');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
