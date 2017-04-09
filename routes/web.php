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
use \App\Survey;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/list', function() {
  $surveys = Survey::all();
  return view('survey.list', ['surveys'=>$surveys]);
});

Route::get('/home', 'HomeController@index');
Route::get('/thanks', function() {
  return view('survey.thanks');
});
Route::get('/new', function() {
  return view('survey.new');
});
Route::post('/survey/create', 'SurveyController@create');
Route::get('/survey/{id}', 'SurveyController@show');
Route::post('/survey/submit/{id}', 'SurveyController@submit');
Route::get('/addquestion/{survey}', function(Survey $survey) {
  return view('survey.addquestion', ['survey'=>$survey]);
});
Route::post('/addquestion/{survey}', 'SurveyController@addquestion');

Route::get('/response/export/{survey}', 'ResponseController@export');
Route::get('/response/{survey}', 'ResponseController@show');
