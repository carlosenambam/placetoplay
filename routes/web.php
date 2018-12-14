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

Route::get('/', 'PaymentController@paymentForm');

Route::post('/create-transaction', 'PaymentController@createTransaction');

Route::get('/transaction-list', 'PaymentController@transactionList');

Route::get('/return-url', 'PaymentController@returnUrl');
