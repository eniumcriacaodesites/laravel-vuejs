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

Route::group(['prefix' => '/', 'as' => 'site.'], function () {
    Route::get('/', function () {
        return view('site.home');
    })->name('home');

    Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.'], function () {
        Route::get('create', 'Site\SubscriptionsController@create')->name('create');
        Route::post('store', 'Site\SubscriptionsController@store')->name('store');
    });
});

Route::get('/home', function () {
    return redirect()->route('admin.home');
});

Route::get('/app', function () {
    return view('layouts.spa');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Auth::routes();

    Route::get('/', function () {
        return redirect()->route('admin.home');
    });

    Route::group(['middleware' => 'can:access-admin'], function () {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::resource('/banks', 'BanksController', ['except' => 'show']);
        Route::resource('/bill-pays', 'BillPaysController', ['except' => 'show']);
        Route::resource('/bill-receives', 'BillReceivesController', ['except' => 'show']);
    });
});
