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

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions','QuestionsController')->except('show');
Route::get('/questions/{slug}','QuestionsController@show')->name('questions.show');
Route::resource('questions.answers','AnswersController')->except(['index','create','show']);
Route::post('/answer/{answer}/accept','AcceptAnswerController')->name('answers.accept');
// Route::post('/questions/{question}/answers','AnswersController@store')->name('answers.store');

//favorite Question
Route::post('/question/{question}/favorite','FavoritesController@store')->name('questions.favorite');
Route::delete('/question/{question}/favorite','FavoritesController@delete')->name('questions.unfavorite');
//vote Question
Route::post('/question/{question}/upvote','VoteQuestionController')->name('questions.vote');
// Route::post('/question/{question}/downvote','VoteQuestionController')->name('questions.downvote');
//vote Answer
Route::post('/answer/{answer}/upvote','VoteAnswerController')->name('answers.vote');
// Route::post('/answer/{answer}/downvote','VoteAnswerController')->name('answers.downvote');