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

Route::get('/', 'HomeController@welcome');
Route::get('/data', 'HomeController@data');
Route::get('/download', 'HomeController@downloadActions');
Route::get('/downloadResults', 'HomeController@downloadResults');
Route::get('/faq', 'HomeController@faq');
Route::get('/legal', 'HomeController@legal');
Route::get('/levels', 'HomeController@levels');

Auth::routes();

Route::get('/my-overview', 'MyOverviewController@show');
Route::get('/debates/{debate}', 'DebateController@show');
Route::get('/debates/{debate}/random', 'DebateController@random');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/proposals/{proposal}', 'ProposalController@show');
Route::get('/questions/{question}/read', 'QuestionController@read');
Route::get('/questions/{question}', 'QuestionController@show');
Route::get('/ai-limits', 'HomeController@limits');
Route::get('/book', 'HomeController@book');
Route::get('/random', 'HomeController@random');
Route::get('/tags/{tag}', 'TagController@show');

Route::get('/api/debates/{debate}', 'Api\DebateController@show');
Route::get('/api/questions/{question}/next', 'Api\ResponseController@next');
Route::get('/api/questions/{question}/tags', 'Api\QuestionController@tags');
Route::get('/api/responses/random', 'Api\ResponseController@random');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/account', 'Auth\UserController@show');
    Route::get('/messages', 'MessageController@index');
    Route::get('/messages/{message}', 'MessageController@show');
    Route::get('/quit', 'Auth\UserController@showQuit');
    Route::post('/quit', 'Auth\UserController@doQuit');
    Route::get('/questions/{question}/search', 'QuestionController@search');
    Route::get('/questions/{question}/tags/create', 'TagController@create');
    Route::post('/questions/{question}/tags', 'TagController@store');
    Route::get('/tags/{tag}/edit', 'TagController@edit');
    Route::get('/tags/{tag}/inject', 'TagController@showInject');
    Route::post('/tags/{tag}/inject', 'TagController@doInject');
    Route::post('/tags/{tag}', 'TagController@update');
    Route::get('/tags/{tag}/delete', 'TagController@showDelete');
    Route::delete('/tags/{tag}', 'TagController@delete');

    Route::get('/api/responses', 'Api\ResponseController@search');
    Route::get('/api/downloads/search/{query}', 'Api\ResponseController@downloadSearch');
    Route::post('/api/responses', 'Api\ResponseController@update');
    Route::post('/api/tags', 'Api\TagController@store');
});
