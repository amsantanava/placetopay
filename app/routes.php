<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', 'PseController@home');
Route::get('/createPayment', 'PseController@formPayment');
Route::post('/createPayment', 'PseController@createPayment');
Route::post('/endPayment', 'PseController@endPayment');
Route::get('/endPayment', 'PseController@endPayment');
