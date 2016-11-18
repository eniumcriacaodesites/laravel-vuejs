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

Route::get('/client', function () {
    \Illuminate\Support\Facades\Auth::loginUsingId(2);
});

Auth::routes();

Route::get('/home', function () {
    return redirect()->route('admin.home');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => 'can:access-admin',
], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});
