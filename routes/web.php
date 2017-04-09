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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/survey/{id}', 'SurveyController@show');
Route::post('/survey/submit/{id}', 'SurveyController@submit');

Route::get('/response/export/{survey}', 'ResponseController@export');
Route::get('/response/{survey}', 'ResponseController@show');
