<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('hooks/iugu', 'Api\IuguController@hooks');

Route::group(['middleware' => 'cors', 'as' => 'api.'], function () {
    Route::group(['middleware' => 'check-subscription:after'], function () {
        Route::post('/access_token', 'Api\AuthController@accessToken')->name('access_token');
        Route::post('/refresh_token', 'Api\AuthController@refreshToken')->name('refresh_token');
    });

    Route::group(['middleware' => ['auth:api', 'check-subscription']], function () {
        Route::post('/logout', 'Api\AuthController@logout')->name('logout');

        Route::get('/user', function () {
            return Auth::user('api');
        })->name('user');

        Route::get('/banks', 'Api\BanksController@index')->name('banks');
        Route::resource('/categories', 'Api\CategoriesController', ['except' => ['create', 'edit']]);
        Route::resource('/category_expenses', 'Api\CategoryExpensesController', ['except' => ['create', 'edit']]);
        Route::resource('/category_revenues', 'Api\CategoryRevenuesController', ['except' => ['create', 'edit']]);
        Route::get('/bank_accounts/lists', 'Api\BankAccountsController@lists')->name('bank_accounts.lists');
        Route::resource('/bank_accounts', 'Api\BankAccountsController', ['except' => ['create', 'edit']]);

        Route::get('/bill_pays/total_today', 'Api\BillPaysController@findToPayToday');
        Route::get('/bill_pays/total_rest_of_month', 'Api\BillPaysController@findToPayRestOfMonth');
        Route::resource('/bill_pays', 'Api\BillPaysController', ['except' => ['create', 'edit']]);

        Route::get('/bill_receives/total_today', 'Api\BillReceivesController@findToPayToday');
        Route::get('/bill_receives/total_rest_of_month', 'Api\BillReceivesController@findToPayRestOfMonth');
        Route::resource('/bill_receives', 'Api\BillReceivesController', ['except' => ['create', 'edit']]);

        Route::get('/statements', 'Api\StatementsController@index')->name('statements.index');
        Route::get('/cash_flow', 'Api\CashFlowsController@index')->name('cash_flow.index');
        Route::get('/cash_flow/monthly', 'Api\CashFlowsController@byPeriod')->name('cash_flow.monthly');
    });
});
